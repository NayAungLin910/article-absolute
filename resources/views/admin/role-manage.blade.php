@extends('admin.layout.dashboard')
@section('content-dashboard')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4>
                        Role Management
                    </h4>
                </div>
                <div class="card-body table-responsive">
                    <form action="{{ url('/admin/role-manage') }}" method="POST">
                        @csrf
                        <label for="" class="text-dark">Search user by email</label>
                        <div class="input-group">
                            <div class="form-outline">
                                <input type="search" name="search" id="form1" class="form-control" />
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                    @if ($search_user && $search_user !== '')
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <img src="{{ $search_user->image }}" height="30" class="rounded-circle"
                                            alt="">
                                    </td>
                                    <td>
                                        {{ $search_user->name }}
                                    </td>
                                    <td>
                                        {{ $search_user->email }}
                                    </td>
                                    <td>
                                        <span class="badge badge-success">{{ $search_user->role }}</span>
                                    </td>
                                    <td>
                                        @if ($search_user->role === 'moderator')
                                            <a href="{{ url("/admin/change-role/$search_user->id") }}" class="btn btn-sm btn-warning">Change to user</a>
                                        @endif
                                        @if ($search_user->role === 'user')
                                            <a href="{{ url("/admin/change-role/$search_user->id") }}" class="btn btn-sm btn-primary">Change to moderator</a>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
