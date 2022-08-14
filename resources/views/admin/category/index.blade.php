@extends('admin.layout.dashboard')
@section('content-dashboard')
    <div class="row">
        <div class="col-sm-9">
            <div>
                <a href="{{ route('category.create') }}" class="btn btn-success"><i class="fa-solid fa-plus"
                        style="margin-right: 5px"></i>Create Category</a>
            </div>
            <div class="input-group mt-3">
                <form action="{{ url('/mod-admin/category/search') }}" class="d-inline" method="POST">
                    @csrf
                    <div class="input-group rounded">
                        <input type="search" name="search" class="form-control rounded" placeholder="Search"
                            aria-label="Search" aria-describedby="search-addon" required />
                        <button type="submit" value="Search" class="btn btn-sm btn-dark">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="card mt-3">
                <div class="card-header bg-dark">
                    <h4 class="text-white">Creategories</h4>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    <strong>
                                        <h5>Name</h5>
                                    </strong>
                                </th>
                                <th>
                                    <strong>
                                        <h5>Aricle Count</h5>
                                    </strong>
                                </th>
                                <th>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $c)
                                <tr>
                                    <td>
                                        <a href="{{ url('/article-view-by-category/' . $c->slug) }}">
                                            <span class="badge badge-primary bold">
                                                {{ $c->name }}
                                            </span>
                                        </a>
                                    </td>
                                    <td>
                                        <h6>{{ $c->article_count }}</h6>
                                    </td>
                                    <td>
                                        <a href="{{ route('category.edit', $c->slug) }}" class="btn btn-sm btn-primary"
                                            style="margin-left: 5px; margin-right: 5px;"><i
                                                class="fa-solid fa-pen-to-square"></i></a>
                                        <form action="{{ route('category.destroy', $c->slug) }}" class="d-inline"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                style="margin-left: 5px; margin-right: 5px;"><i
                                                    class="fa-solid fa-trash"></i></button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
