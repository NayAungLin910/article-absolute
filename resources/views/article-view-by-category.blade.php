@extends('layout.master')
@section('title-meta')
    <title>Absolute - {{ $category->name }} Category</title>
    <meta name="description" content="{{ $category->name }} absolute category">
@endsection
@section('content')
    <h3><i class="fa-solid fa-tag"></i> {{ $category->name }}</h3>
    <div class="row mt-3">
        @foreach ($articles as $a)
            <div class="col-sm-4">
                <a href="{{ url('/article-view/' . $a->slug) }}">
                    <div class="card" style="width: 21rem;">
                        @if ($a->header->file == 'image')
                            <img src="{{ $a->header->file_path }}" class="card-img-top" alt="Sunset Over the Sea" />
                        @endif
                        @if ($a->header->file == 'video')
                            <video class="w-100" controls>
                                <source src="{{ url($a->header->file_path) }}" type="video/mp4">
                            </video>
                        @endif
                        <div class="card-body">
                            <p class="card-text text-dark"><strong>{{ $a->header->name }}</strong></p>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
        <div class="mt-4">
            {{ $articles->links() }}
        </div>
    </div>
@endsection
