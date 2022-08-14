@extends('layout.master')
@section('title-meta')
    <title>Absolute - Home</title>
    <meta name="description" content="Home absolute">
@endsection
@section('content')
    @if ($featured_article)
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <div class="p-3">
                    <center>
                        <a href="{{ url('/article-view/' . $featured_article->slug) }}">
                            @if ($featured_article->header->file == 'image')
                                <img src="{{ $featured_article->header->file_path }}"
                                    alt="{{ $featured_article->header->name }}" width="400" class="img-fluid"
                                    style="max-width: 100%" />
                            @endif
                            @if ($featured_article->header->file == 'video')
                                <video class="w-100" controls>
                                    <source src="{{ url($featured_article->header->file_path) }}" type="video/mp4">
                                </video>
                            @endif
                        </a>
                    </center>
                    <br />
                    <a href="{{ url('/article-view/' . $featured_article->slug) }}">
                        <h5 class="text-center text-dark">{{ $featured_article->name }}</h5>
                    </a>
                </div>
            </div>
            <div class="col-sm-2"></div>
        </div>
    @endif
    @if ($latest_news)
        <h5><i class="fa-solid fa-tag"></i> Latest news</h5>
        <div class="row">
            @foreach ($latest_news as $l)
                <div class="col-sm-4">
                    <a href="{{ url('/article-view/' . $l->article->slug) }}">
                        <div class="card" style="width: 21rem;">
                            @if ($l->file == 'image')
                                <img src="{{ $l->file_path }}" class="card-img-top" alt="Sunset Over the Sea" />
                            @endif
                            @if ($l->file == 'video')
                                <div class="ratio ratio-16x9">
                                    <video class="w-100" controls>
                                        <source src="{{ url($l->file_path) }}" type="video/mp4">
                                    </video>
                                </div>
                            @endif
                            <div class="card-body">
                                <p class="card-text text-dark"><strong>{{ $l->name }}</strong></p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
            <hr class="mt-2" />
        </div>
    @endif
    @if ($inter)
        <h5><i class="fa-solid fa-tag"></i> International News</h5>
        <div class="row">
            @if (sizeof($inter->article) > 0)
                @foreach ($inter->article as $a)
                    @if ($loop->index < 3)
                        <div class="col-sm-4">
                            <a href="{{ url('/article-view/' . $a->slug) }}">
                                <div class="card" style="width: 21rem;">
                                    @if ($a->header->file == 'image')
                                        <img src="{{ $a->header->file_path }}" class="card-img-top"
                                            alt="{{ $a->header->name }}" />
                                    @endif
                                    @if ($a->header->file == 'video')
                                        <div class="ratio ratio-16x9">
                                            <video class="w-100" controls>
                                                <source src="{{ url($a->header->file_path) }}" type="video/mp4">
                                            </video>
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        <p class="card-text text-dark"><strong>{{ $a->header->name }}</strong></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                @endforeach
            @else
                <div>
                    <span class="badge badge-secondary">No articles yet</span>
                </div>
            @endif
            @if (sizeof($inter->article) > 3)
                <div class="mt-3">
                    <a href="{{ url('/article-view-by-category/' . $inter->slug) }}" class="btn btn-sm btn-primary">
                        More ...
                    </a>
                </div>
            @endif
            <hr class="mt-2" />
        </div>
    @endif
    @if ($myan)
        <h5><i class="fa-solid fa-tag"></i> Myanamr News</h5>
        <div class="row">
            @if (sizeof($myan->article) > 0)
                @foreach ($myan->article as $a)
                    @if ($loop->index < 3)
                        <div class="col-sm-4">
                            <a href="{{ url('/article-view/' . $a->slug) }}">
                                <div class="card" style="width: 21rem;">
                                    @if ($a->header->file == 'image')
                                        <img src="{{ $a->header->file_path }}" class="card-img-top"
                                            alt="{{ $a->header->name }}" />
                                    @endif
                                    @if ($a->header->file == 'video')
                                        <div class="ratio ratio-16x9">
                                            <video class="w-100" controls>
                                                <source src="{{ url($a->header->file_path) }}" type="video/mp4">
                                            </video>
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        <p class="card-text text-dark"><strong>{{ $a->header->name }}</strong></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                @endforeach
            @else
                <div>
                    <span class="badge badge-secondary">No articles yet</span>
                </div>
            @endif
            @if (sizeof($myan->article) > 3)
                <div class="mt-3">
                    <a href="{{ url('/article-view-by-category/' . $myan->slug) }}" class="btn btn-sm btn-primary">
                        More ...
                    </a>
                </div>
            @endif
            <hr class="mt-2" />
        </div>
    @endif
    @if ($sports)
        <h5><i class="fa-solid fa-tag"></i> Sports News</h5>
        <div class="row">
            @if (sizeof($sports->article) > 0)
                @foreach ($sports->article as $a)
                    @if ($loop->index < 3)
                        <div class="col-sm-4">
                            <a href="{{ url('/article-view/' . $a->slug) }}">
                                <div class="card" style="width: 21rem;">
                                    @if ($a->header->file == 'image')
                                        <img src="{{ $a->header->file_path }}" class="card-img-top"
                                            alt="{{ $a->header->name }}" />
                                    @endif
                                    @if ($a->header->file == 'video')
                                        <div class="ratio ratio-16x9">
                                            <video class="w-100" controls>
                                                <source src="{{ url($a->header->file_path) }}" type="video/mp4">
                                            </video>
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        <p class="card-text text-dark"><strong>{{ $a->header->name }}</strong></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                @endforeach
            @else
                <div>
                    <span class="badge badge-secondary">No articles yet</span>
                </div>
            @endif
            @if (sizeof($sports->article) > 3)
                <div class="mt-3">
                    <a href="{{ url('/article-view-by-category/' . $sports->slug) }}" class="btn btn-sm btn-primary">
                        More ...
                    </a>
                </div>
            @endif
            <hr class="mt-2" />
        </div>
    @endif
@endsection
@section('script')
@endsection
