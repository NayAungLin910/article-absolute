@extends('admin.layout.dashboard')
@section('content-dashboard')
    <div class="row">
        <div class="col-sm-9">
            <div>
                <a href="{{ route('category.index') }}" class="btn btn-dark"><i class="fa-solid fa-angle-left"
                        style="margin-right: 5px"></i>Categories</a>
            </div>
            <div class="card mt-3">
                <div class="card-header bg-dark">
                    <h3 class="text-white">Create category</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('category.store') }}" method="POST">
                        @csrf
                        <div class="form-outline mb-4">
                            <input type="text" name="name" class="form-control" />
                            <label class="form-label" for="form1Example1">Enter Category</label>
                        </div>
                        @if ($errors->has('name'))
                            <p class="text-danger">{{ $errors->first('name') }}</p>
                        @endif
                        <button type="submit" class="btn btn-success">
                            <i class="fa-solid fa-plus" style="margin-right:3px;font-size:16px"></i>
                            Create
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
