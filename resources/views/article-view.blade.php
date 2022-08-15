@extends('layout.master')
@section('title-meta')
    <title>
        Absolute - {{ $article->header->name }}</title>
    <meta name="description" content="{{ $article->header->name }} absolute article">
@endsection
@section('style')
    <style>
        #articleDes img {
            max-width: 100%;
            width: 500px;
        }

        .cus-con {
            background: rgb(9, 45, 44);
            background: linear-gradient(335deg, rgba(9, 45, 44, 1) 0%, rgba(92, 178, 223, 1) 80%);
            border-radius: 10px;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-8">
            <h3>{{ $article->header->name }}</h3>
            <br />
            @if ($article->header->file === 'image')
                <img width="500" style="max-width: 100%" class="img-fluid" src="{{ url($article->header->file_path) }}"
                    alt="{{ $article->header->name }}" />
            @elseif ($article->header->file === 'video')
                <div class="row">
                    <div class="col-sm-7">
                        <video class="w-100" controls>
                            <source src="{{ url($article->header->file_path) }}" type="video/mp4">
                        </video>
                    </div>
                </div>
            @endif
            <br />
            <br />
            <div id="articleDes">
                {!! $article->description !!}
            </div>
            <hr />
            <div class="row">
                <div class="col-sm-8">
                    <div>
                        <p class="h5"><i class="fa-solid fa-tag" style="margin-right: 3px;"></i>Categories</p>
                        @foreach ($article->category as $c)
                            <a href="{{ url('/article-view-by-category/' . $c->slug) }}">
                                <span class="badge badge-primary">{{ $c->name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="col-sm-4">
                    @auth
                        <div id="root"></div>
                        <script>
                            window.article_slug = "{{ $article->slug }}"
                            window.auth = @json(auth()->user());
                        </script>
                        <script src="{{ env("APP_URL") . '/js/articleLike.js' }}"></script>
                        {{-- <script src="{{ mix('/js/articleLike.js') }}"></script> --}}
                    @endauth
                </div>
            </div>
            <br />
            <div class="card cus-con" style="width: 18rem;">
                <div class="card-body text-white">
                    <h4 class="card-title">Author</h4>
                    <p>
                        <img src="{{ $article->user->image }}" class="rounded-circle" height="30"
                            alt="{{ $article->user->name }}">
                        <span style="margin-left: 3px;" class="h6">{{ $article->user->name }}</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <h5 class="text-center">Latest Articles</h5>
            <div class="table-responsive">
                <table class="table table-borderless">
                    <tbody>
                        @foreach ($latest_article as $la)
                            <tr>
                                <td>
                                    <a href="{{ url('/article-view/' . $la->slug) }}">
                                        @if ($la->header->file == 'image')
                                            <img src="{{ url($la->header->file_path) }}" class="img-fluid"
                                                style="max-width: 100%" alt="{{ $la->header->name }}" />
                                        @endif
                                        @if ($la->header->file == 'video')
                                            <video class="w-100" controls>
                                                <source src="{{ url($la->header->file_path) }}" type="video/mp4">
                                            </video>
                                        @endif
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h6><a href="{{ url('/article-view/' . $la->slug) }}"
                                            class="text-dark">{{ $la->name }}</a></h6>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
