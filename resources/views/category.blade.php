@extends('layout.master')
@section('title-meta')
    <title>Absolute - Categories</title>
    <meta name="description" content="Categories absolute">
@endsection
@section('content')
    <h3><i class="fa-solid fa-tag"></i> Categories</h3>
    <form action="" method="POST">
        @csrf
        <div class="input-group">
            <div class="form-outline">
                <input type="search" name="search" id="form1" class="form-control" />
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>
    <br />
    <div>
        @foreach ($categories as $c)
            <div>
                <h5><i class="fa-solid fa-tag"></i> {{ $c->name }}</h5>
                <div class="row">
                    @if (sizeof($c->article) > 0)
                        @foreach ($c->article as $a)
                            @if ($loop->index < 3)
                                <div class="col-sm-4">
                                    <a href="{{ url('/article-view/' . $a->slug) }}">
                                        <div class="card" style="width: 21rem;">
                                            @if ($a->header->file == 'image')
                                                <img src="{{ url($a->header->file_path) }}" class="card-img-top"
                                                    alt="Sunset Over the Sea" />
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
                            @endif
                        @endforeach
                    @else
                        <div>
                            <span class="badge badge-secondary">No articles yet</span>
                        </div>
                    @endif
                    @if (sizeof($c->article) > 3)
                        <div class="mt-3">
                            <a href="{{ url('/article-view-by-category/' . $c->slug) }}" class="btn btn-sm btn-primary">
                                More ...
                            </a>
                        </div>
                    @endif
                    <hr class="mt-2" />
                </div>

            </div>
        @endforeach
    </div>
    <br />
    {{ $categories->links() }}
@endsection
