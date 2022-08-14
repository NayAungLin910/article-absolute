@extends('layout.master')
@section('title-meta')
    <title>Absolute - Profile</title>
    <meta name="description" content="Absolute Profile">
@endsection
@section('style')
    <style>
        .cus-con {
            background: rgb(9, 45, 44);
            background: linear-gradient(335deg, rgba(9, 45, 44, 1) 0%, rgba(92, 178, 223, 1) 80%);
            border-radius: 20px;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-5">
            <div class="cus-con p-1 table-responsive">
                <table class="table table-borderless">
                    <tr>
                        <td>
                            <img src="{{ $user->image }}" class="rounded-circle" alt="{{ $user->name }}" class="text-center">
                        </td>
                        <td>
                            <table class="table table-borderless text-white">
                                <tr>
                                    <td><strong>{{ $user->name }}</strong></td>
                                </tr>
                                <tr>
                                    <td><strong>{{ $user->email }}</strong></td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>
                                            Role:
                                            <span class="badge badge-primary">
                                                {{ $user->role }}
                                            </span>
                                        </strong>
                                    </td>
                                </tr>
                                @if (auth()->user()->role === 'moderator' || auth()->user()->role === 'admin')
                                    <tr>
                                        <td>
                                            <strong>
                                                Article Count:
                                                <span class="badge badge-primary">
                                                    {{ $user->article_count }}
                                                </span>
                                            </strong>
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td>
                                        <strong>
                                            Favourite Articles:
                                            <span class="badge badge-primary">
                                                {{ $user->fav_count }}
                                            </span>
                                        </strong>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

            </div>
        </div>
        <div class="col-sm-6">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            <h4>Favourtie articles</h4>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if ($user->fav !== '')
                        @foreach ($user->fav->reverse() as $f)
                            <tr>
                                <td>
                                    <a href="{{ url('/article-view/' . $f->slug) }}">
                                        @if ($f->header->file == 'image')
                                            <img src="{{ $f->header->file_path }}" class="img-fluid"
                                                alt="{{ $f->name }}" width="200" style="max-width: 100%" />
                                        @endif
                                        @if ($f->header->file == 'video')
                                            <div class="ratio ratio-16x9">
                                                <video class="w-100" controls>
                                                    <source src="{{ url($f->header->file_path) }}" type="video/mp4">
                                                </video>
                                            </div>
                                        @endif
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ url('/article-view/' . $f->slug) }}" class="text-dark">
                                        <strong>
                                            <h6>{{ $f->name }}</h6>
                                        </strong>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
