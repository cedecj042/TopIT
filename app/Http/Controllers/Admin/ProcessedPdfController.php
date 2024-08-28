<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\Subsection;
use App\Models\Figure;
use App\Models\Table;
use App\Models\Code;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Make sure to include the Log facade
use Illuminate\Support\Facades\Storage;


class ProcessedPdfController extends Controller
{
    public function store(Request $request)
    {
        Log::info('Starting the process of storing processed PDF data', [
            'course_id' => $request->course_id,
            'processed_data_length' => count($request->processed_data),
        ]);

        $request->validate([
            'course_id' => 'required|exists:courses,course_id',
            'processed_data' => 'required|array',
        ]);

        DB::beginTransaction();

        try {
            foreach ($request->processed_data['Modules'] as $moduleData) {
                Log::info('Processing module', ['module_title' => $moduleData['Title']['text']]);

                $module = Module::create([
                    'course_id' => $request->course_id,
                    'title' => $moduleData['Title']['text'],
                    'content' => json_encode($moduleData), // Encode data to JSON
                    'order' => $moduleData['Order']
                ]);

                foreach ($moduleData['Lessons'] as $lessonData) {
                    Log::info('Processing lesson', ['lesson_title' => $lessonData['Title']['text'] ?? 'Untitled Lesson']);

                    $lesson = Lesson::create([
                        'module_id' => $module->module_id,
                        'title' => $lessonData['Title']['text'] ?? 'Untitled Lesson',
                        'content' => json_encode($lessonData['Content']),
                        'order' => $lessonData['Order']
                    ]);

                    foreach ($lessonData['Sections'] as $sectionData) {
                        Log::info('Processing section', [
                            'section_title' => $sectionData['Title']['text'],
                            'section_content' => $sectionData['Content']
                        ]);

                        $section = Section::create([
                            'lesson_id' => $lesson->lesson_id,
                            'title' => $sectionData['Title']['text'],
                            'content' => json_encode($sectionData['Content']),
                            'order' => $sectionData['Order']
                        ]);

                        $this->processContent($sectionData['Content'], $section);

                        foreach ($sectionData['Subsections'] as $subsectionData) {
                            Log::info('Processing subsection', [
                                'subsection_title' => $subsectionData['Title']['text'],
                                'subsection_content' => $subsectionData['Content'] // Logging the entire content for inspection
                            ]);

                            $subsection = Subsection::create([
                                'section_id' => $section->section_id,
                                'title' => $subsectionData['Title']['text'],
                                'content' => json_encode($subsectionData['Content']),
                                'order' => $subsectionData['Order']
                            ]);

                            $this->processContent($subsectionData['Content'], $subsection);
                        }
                    }
                }
            }

            DB::commit();
            Log::info('Successfully stored processed PDF data');
            return response()->json(['message' => 'Processed PDF data stored successfully'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to store processed PDF data', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to store processed PDF data', 'error' => $e->getMessage()], 500);
        }
    }

    private function processContent($contentArray, $parent)
    {
        $content = [];
        foreach ($contentArray as $contentItem) {
            // Log the content item to understand its structure
            Log::info('Processing content item', ['contentItem' => $contentItem]);

            // Check for Figures, Tables, or Code within the 'value' key
            if (isset($contentItem['type']) && $contentItem['type'] === 'Figures') {
                Log::info('Processing Figures content', ['content' => $contentItem]);
                $this->processFigures($contentItem['value'], $parent);
            } elseif (isset($contentItem['type']) && $contentItem['type'] === 'Tables') {
                Log::info('Processing Tables content', ['content' => $contentItem]);
                $this->processTables($contentItem['value'], $parent);
            } elseif (isset($contentItem['type']) && $contentItem['type'] === 'Code') {
                Log::info('Processing Code content', ['content' => $contentItem]);
                $this->processCode($contentItem['value'], $parent);
            } elseif (isset($contentItem['type']) && $contentItem['type'] === 'Text') {
                $content[] = [
                    'type' => 'Text',
                    'text' => $contentItem['value']['text'] ?? ''
                ];
            }
        }

        if (!empty($content)) {
            $parent->update(['content' => json_encode($content)]);
        }
    }


    private function storeBase64Image($base64Image, $folder = 'images/')
    {
        $image = base64_decode($base64Image);
        $imageName = uniqid() . '.png';
        $path = $folder . $imageName;

        Log::info('Storing image', ['path' => $path]);
        Storage::put($path, $image);

        return $path;
    }

    private function processFigures($data, $parent)
    {
        if (isset($data['image_base64'])) {
            Log::info('Processing image_base64 for Figures', ['data' => $data]);

            $imagePath = $this->storeBase64Image($data['image_base64'], 'figures/');
            $figure = $parent->figures()->create([
                'caption' => $data['caption'] ?? null,
                'description' => $data['description'] ?? null,
                'metadata' => json_encode($data['metadata'] ?? []),
            ]);

            $figure->images()->create([
                'file_name' => basename($imagePath),
                'file_path' => $imagePath,
            ]);
        } else {
            Log::warning('image_base64 is missing for Figures', ['data' => $data]);
        }
    }

    private function processTables($data, $parent)
    {
        if (isset($data['image_base64'])) {
            Log::info('Processing image_base64 for Tables', ['data' => $data]);

            $imagePath = $this->storeBase64Image($data['image_base64'], 'tables/');
            $table = $parent->tables()->create([
                'content' => json_encode($data['content'] ?? []),
                'caption' => $data['caption'] ?? null,
            ]);

            $table->images()->create([
                'file_name' => basename($imagePath),
                'file_path' => $imagePath,
            ]);
        } else {
            Log::warning('image_base64 is missing for Tables', ['data' => $data]);
        }
    }

    private function processCode($data, $parent)
    {
        if (isset($data['image_base64'])) {
            Log::info('Processing image_base64 for Code', ['data' => $data]);

            $imagePath = $this->storeBase64Image($data['image_base64'], 'code/');
            $code = $parent->codes()->create([
                'description' => $data['description'] ?? null,
                'caption' => $data['caption'] ?? null,
                'metadata' => json_encode($data['metadata'] ?? []),
            ]);

            $code->images()->create([
                'file_name' => basename($imagePath),
                'file_path' => $imagePath,
            ]);
        } else {
            Log::warning('image_base64 is missing for Code', ['data' => $data]);
        }
    }
}