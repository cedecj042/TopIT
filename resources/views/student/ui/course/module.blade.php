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
                        <h5>{{ $item['value']['text'] }}</h5>
                    @elseif ($item['type'] == 'Text')
                        <p>{{ nl2br(e($item['value']['text'])) }}</p>
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
                                $sectionContent = json_decode($section->content, true);
                            @endphp 
                            @foreach($sectionContent as $item) 
                                @if ($item['type'] == 'Text')
                                    <p>{{ $item['text'] }}</p>
                                @endif
                            @endforeach
                            @foreach($section->subsections as $subsection)
                                <div class="subsection">
                                    <h6 class="subsection-title">{{ $subsection->title }}</h6> <!-- Subsection title -->
                                    @php
                                        $subsectionContent = json_decode($subsection->content, true);
                                    @endphp

                                    @foreach($subsectionContent as $item)
                                        @if ($item['type'] == 'Text')
                                            <p>{{ $item['text'] }}</p>
                                        @endif
                                    @endforeach

                                    <!-- Display Tables -->
                                    @if($subsection->tables->isNotEmpty())
                                        <div class="tables">
                                            <h5>Tables</h5>
                                            @foreach($subsection->tables as $table)
                                                <p class="table-title">{{ $table->caption }}</p>
                                                @if($table->images->isNotEmpty())
                                                    <div class="table-images">
                                                        @foreach($table->images as $image)
                                                            <img src="{{ $image->file_path }}" alt="Table Image" class="img-fluid">
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <p>No images available for this table.</p>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif

                                    <!-- Display Figures -->
                                    @if($subsection->figures->isNotEmpty())
                                        <div class="figures">
                                            @foreach($subsection->figures as $figure)
                                                <p class="figure-title"> {{ $figure->caption }}</p>
                                                <div class="figure-images">
                                                    @foreach($figure->images as $image)
                                                        <img src="{{ $image->file_path }}" alt="Figure Image"  class="img-fluid">
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <!-- Display Codes -->
                                    @if($subsection->codes->isNotEmpty())
                                        <div class="codes">
                                            @foreach($subsection->codes as $code)
                                                <p class="code-title">{{ $code->caption }}</p>
                                                <div class="code-images">
                                                    @foreach($code->images as $image)
                                                        <img src="{{ $image->file_path }}" alt="Code Image" class="img-fluid">
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

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