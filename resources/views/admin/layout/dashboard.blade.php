@extends('layout.master')
@section('content')
    <div class="d-flex flex-column flex-md-row">
        <nav class="navbar navbar-expand-md navbar-light  d-flex flex-md-column">
            <div class="p-2">
                <h5><i class="fa-solid fa-chart-bar"></i>Functionalites</h5>
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toogle Navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse w-100" id="navbarSupportedContent">
                <ul class="navbar-nav w-100 flex-md-column text-center text-md-end p-2">
                    <li>
                        <a href="{{ url('/mod-admin/statistics') }}" class="nav-link" aria-current="page">
                            <span class="{{ request()->is('mod-admin/statistics*') ? 'text-dark' : '' }}">
                                <i class="fa-solid fa-chart-line"></i>
                                Statistics
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('category.index') }}" class="nav-link" aria-current="page">
                            <span class="{{ request()->is('mod-admin/category*') ? 'text-dark' : '' }}">
                                <i class="fa-solid fa-tag"></i>
                                Category
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('article.index') }}" class="nav-link" aria-current="page">
                            <span class="{{ request()->is('mod-admin/article*') ? 'text-dark' : '' }}">
                                <i class="fa-solid fa-newspaper"></i>
                                Articles
                            </span>
                        </a>
                    </li>
                    @auth
                        @if (auth()->user()->role === 'admin')
                            <li>
                                <a href="{{ url('/admin/role-manage') }}" class="nav-link" aria-current="page">
                                    <span class="{{ request()->is('admin/role-manage*') ? 'text-dark' : '' }}">
                                        <i class="fa-solid fa-users"></i>
                                        Roles
                                    </span>
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>
        </nav>
        <main class="ps-0 ps-md-5 flex-grow-1">
            <div class="container">
                <div class="row mt-3">
                    <div class="col-sm-12">
                        @yield('content-dashboard')
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
