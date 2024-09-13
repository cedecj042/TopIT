@extends('main')

@section('title', 'Course')

@section('page-content')
<div class="container-fluid">
    <div class="row">
        @include('student.shared.student-sidebar')
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-5">
            @include('student.shared.student-navbar')
            <a href="{{route('student-course-detail',$module->course_id)}}" class="btn btn-transparent">Back to Modules</a>
            <div class="d-flex justify-content-between pt-5 pb-2 mt-3 mb-3">
                <h1 class="h3 fw-semibold">{{ $module->title}}</h1>
            </div>
            <div class="course-list mx-auto" style="width: 100%">
                @foreach ($moduleContent as $item)
                    @if ($item['type'] == 'Header')
                        <h5>{{ $item['text'] }}</h5>
                    @elseif ($item['type'] == 'Text')
                        <p>{{ nl2br(e($item['text'])) }}</p>
                    @endif
                @endforeach
            </div>
            <hr>
            <div>
                @foreach($module->lessons as $lesson)
                    <div class="lesson">
                        <h4 class="lesson-title">{{ $lesson->title }}</h4> <!-- Lesson title -->
                        @php
                            $lessonContent = json_decode($lesson->content, true);
                        @endphp
                        @foreach($lessonContent as $content)
                            @if ($content['type'] == 'text')
                                <p>{{ $content['text'] }}</p>
                            @endif
                        @endforeach
                        @foreach($lesson->sections as $section)
                        <div class="section">
                            <h5 class="section-title">{{ $section->title }}</h5> <!-- Section title -->
                            @php
                                // Decode subsection content (text items) and add 'order' for sorting
                                $sectionContent = collect(json_decode($section->content, true))->map(function ($item) {
                                    return [
                                        'type' => 'text',
                                        'order' => $item['order'],
                                        'content' => $item['text']
                                    ];
                                });

                                // Add tables with 'order' to the same collection
                                $tables = $section->tables->map(function ($table) {
                                    return [
                                        'type' => 'table',
                                        'order' => $table->order,
                                        'content' => $table
                                    ];
                                });

                                // Add figures with 'order' to the same collection
                                $figures = $section->figures->map(function ($figure) {
                                    return [
                                        'type' => 'figure',
                                        'order' => $figure->order,
                                        'content' => $figure
                                    ];
                                });

                                // Add codes with 'order' to the same collection
                                $codes = $section->codes->map(function ($code) {
                                    return [
                                        'type' => 'code',
                                        'order' => $code->order,
                                        'content' => $code
                                    ];
                                });

                                // Merge all the collections and sort by 'order'
                                $mergedContent = $sectionContent
                                    ->merge($tables)
                                    ->merge($figures)
                                    ->merge($codes)
                                    ->sortBy('order');
                            @endphp

                            @foreach($mergedContent as $item)
                                @if ($item['type'] == 'text')
                                    <!-- Display text content -->
                                    <p>{{ $item['content'] }}</p>
                                @elseif ($item['type'] == 'table')
                                    <!-- Display table content -->
                                    <div class="table">
                                        <p class="table-title">{{ $item['content']->caption }}</p>
                                        @if($item['content']->images->isNotEmpty())
                                            <div class="table-images">
                                                @foreach($item['content']->images as $image)
                                                    <img src="{{ $image->file_path }}" alt="Table Image" class="img-fluid">
                                                @endforeach
                                            </div>
                                        @else
                                            <p>No images available for this table.</p>
                                        @endif
                                    </div>
                                @elseif ($item['type'] == 'figure')
                                    <!-- Display figure content -->
                                    <div class="figure">
                                        <p class="figure-title">{{ $item['content']->caption }}</p>
                                        <div class="figure-images">
                                            @foreach($item['content']->images as $image)
                                                <img src="{{ $image->file_path }}" alt="Figure Image" class="img-fluid">
                                            @endforeach
                                        </div>
                                    </div>
                                @elseif ($item['type'] == 'code')
                                    <!-- Display code content -->
                                    <div class="code">
                                        <p class="code-title">{{ $item['content']->caption }}</p>
                                        <div class="code-images">
                                            @foreach($item['content']->images as $image)
                                                <img src="{{ $image->file_path }}" alt="Code Image" class="img-fluid">
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach       
                            
                            
                            @foreach($section->subsections as $subsection)
                                <div class="subsection">
                                    <h6 class="subsection-title">{{ $subsection->title }}</h6> <!-- Subsection title -->
                                    @php
                                        // Decode subsection content (text items) and add 'order' for sorting
                                        $subsectionContent = collect(json_decode($subsection->content, true))->map(function ($item) {
                                            return [
                                                'type' => 'text',
                                                'order' => $item['order'],
                                                'content' => $item['text']
                                            ];
                                        });

                                        // Add tables with 'order' to the same collection
                                        $tables = $subsection->tables->map(function ($table) {
                                            return [
                                                'type' => 'table',
                                                'order' => $table->order,
                                                'content' => $table
                                            ];
                                        });

                                        // Add figures with 'order' to the same collection
                                        $figures = $subsection->figures->map(function ($figure) {
                                            return [
                                                'type' => 'figure',
                                                'order' => $figure->order,
                                                'content' => $figure
                                            ];
                                        });

                                        // Add codes with 'order' to the same collection
                                        $codes = $subsection->codes->map(function ($code) {
                                            return [
                                                'type' => 'code',
                                                'order' => $code->order,
                                                'content' => $code
                                            ];
                                        });

                                        // Merge all the collections and sort by 'order'
                                        $mergedContent = $subsectionContent
                                            ->merge($tables)
                                            ->merge($figures)
                                            ->merge($codes)
                                            ->sortBy('order');
                                    @endphp

                                    @foreach($mergedContent as $item)
                                        @if ($item['type'] == 'text')
                                            <!-- Display text content -->
                                            <p>{{ $item['content'] }}</p>
                                        @elseif ($item['type'] == 'table')
                                            <!-- Display table content -->
                                            <div class="table">
                                                <p class="table-title">{{ $item['content']->caption }}</p>
                                                @if($item['content']->images->isNotEmpty())
                                                    <div class="table-images">
                                                        @foreach($item['content']->images as $image)
                                                            <img src="{{ $image->file_path }}" alt="Table Image" class="img-fluid">
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <p>No images available for this table.</p>
                                                @endif
                                            </div>
                                        @elseif ($item['type'] == 'figure')
                                            <!-- Display figure content -->
                                            <div class="figure">
                                                <p class="figure-title">{{ $item['content']->caption }}</p>
                                                <div class="figure-images">
                                                    @foreach($item['content']->images as $image)
                                                        <img src="{{ $image->file_path }}" alt="Figure Image" class="img-fluid">
                                                    @endforeach
                                                </div>
                                            </div>
                                        @elseif ($item['type'] == 'code')
                                            <!-- Display code content -->
                                            <div class="code">
                                                <p class="code-title">{{ $item['content']->caption }}</p>
                                                <div class="code-images">
                                                    @foreach($item['content']->images as $image)
                                                        <img src="{{ $image->file_path }}" alt="Code Image" class="img-fluid">
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach                                   

                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
                @endforeach
            </div>

        </main>
    </div>
</div>
@endsection