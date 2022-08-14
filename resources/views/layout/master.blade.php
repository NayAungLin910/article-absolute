<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="{{ url('/icons/absolute_header.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @yield('title-meta')
    {{-- <title>Absolute</title> --}}
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <!-- custom -->
    <link href="{{ url('/css/custom.css') }}" rel="stylesheet" />
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.3.0/mdb.min.css" rel="stylesheet" />
    <!-- appvarun totastify -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <!-- jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- react-quill -->
    <link rel="stylesheet" href="//cdn.quilljs.com/1.2.6/quill.snow.css">

    @yield('style')
</head>
<div>
    <nav class="navbar navbar-expand-lg sticky-top navbar-light bg-white">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ url('/icons/absolute_transparent.png') }}" height="40" loading="lazy"
                    alt="Absolute logo">
            </a>
            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav text-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'text-dark fw-bold' : '' }}" aria-current="page"
                            href="{{ url('/') }}" style="font-family: 'Inter', sans-serif;">
                            <i class="fa-solid fa-house"></i>
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('category*') ? 'text-dark fw-bold' : '' }}"
                            aria-current="page" href="{{ url('/category') }}" style="font-family: 'Inter', sans-serif;">
                            <i class="fa-solid fa-tag"></i>
                            Categories
                        </a>
                    </li>
                    @guest
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" style="font-family: 'Inter', sans-serif;" href="#"
                                id="navbarDropdownMenuLink" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                                Login
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li>
                                    <a href="{{ url('/login/google') }}" class="dropdown-item"
                                        style="font-family: 'Inter', sans-serif;">Sign
                                        in with <strong>Gmail</strong></a>
                                </li>
                            </ul>
                        </li>
                    @endguest
                    @auth
                        @if (auth()->user()->role === 'moderator' || auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('mod-admin*') ? 'text-dark fw-bold' : '' }}"
                                    href="{{ url('/mod-admin/statistics') }}" style="font-family: 'Inter', sans-serif;">
                                    <i class="fa-solid fa-chart-bar"></i>
                                    Dashboard
                                </a>
                            </li>
                        @endif
                    @endauth
                    @auth
                        <div class="d-flex align-items-center">
                            <div class="dropdown dropend">
                                <a class="dropdown-toggle d-flex align-items-center hidden-arrow" href="#"
                                    id="navbarDropdownMenuAvatar" role="button" data-mdb-toggle="dropdown"
                                    aria-expanded="false">
                                    <img src="{{ auth()->user()->image }}" class="rounded-circle" height="30"
                                        alt="{{ auth()->user()->name }}" loading="lazy" />
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar">
                                    <li>
                                        <div class="container">
                                            <table>
                                                <tr>
                                                    <td><i class="fa-solid fa-user"></i></td>
                                                    <td><a class="dropdown-item" href="{{ url('/profile') }}">Profile</a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider" />
                                    </li>
                                    <li>
                                        <div class="container">
                                            <table>
                                                <form action="{{ url('/logout') }}" method="POST">
                                                    @csrf
                                                    <tr>
                                                        <td>
                                                            <i class="fa-solid fa-door-open"></i>
                                                        </td>
                                                        <td>
                                                            <input type="submit" class="dropdown-item" value="Logout" />
                                                        </td>
                                                    </tr>
                                                </form>
                                            </table>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 mt-4">
                @yield('content')
            </div>
        </div>
        <br />
        <hr />
        <div class="row">
            <div class="col-sm-12">
                <!-- Footer -->
                <footer class="text-center text-lg-start bg-white text-muted">
                    <!-- Section: Links  -->
                    <section class="">
                        <div class="container text-center text-md-start mt-5">
                            <!-- Grid row -->
                            <div class="row mt-3">
                                <!-- Grid column -->
                                <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                                    <!-- Content -->
                                    <h6 class="text-uppercase fw-bold mb-4">
                                        <img src="{{ url('/icons/absolute_transparent.png') }}"
                                            style="margin-right: 7px" height="40" loading="lazy"
                                            alt="Absolute logo"> Absolute
                                    </h6>
                                    <p>
                                        Absolute news deliverying you informative content with absolute accurancy and
                                        timing.
                                    </p>
                                </div>
                                <!-- Grid column -->

                                <!-- Grid column -->
                                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                                    <!-- Links -->
                                    <a href="{{ url('/terms-and-conditions') }}">
                                        <h6 class="text-uppercase fw-bold mb-4 text-dark">
                                            Terms and conditions
                                        </h6>
                                    </a>
                                </div>
                                <!-- Grid column -->

                                <!-- Grid column -->
                                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                                    <!-- Links -->
                                    <a href="{{ url('/cookie-policy') }}">
                                        <h6 class="text-uppercase fw-bold mb-4 text-dark">
                                            Cookie Policy
                                        </h6>
                                    </a>
                                </div>
                                <!-- Grid column -->

                                <!-- Grid column -->
                                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                                    <!-- Links -->
                                    <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
                                    <p>
                                        <i class="fas fa-envelope me-3 text-grayish"></i>
                                        nayaunglin910@gmail.com
                                    </p>
                                </div>
                                <!-- Grid column -->
                            </div>
                            <!-- Grid row -->
                        </div>
                    </section>
                    <!-- Section: Links  -->

                    <!-- Copyright -->
                    <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.025);">
                        © 2022 Copyright:
                        <a class="text-reset fw-bold" href="{{ url('/disclaimer') }}">absolute.nayaunglin.xyz</a>
                    </div>
                    <!-- Copyright -->
                </footer>
                <!-- Footer -->
            </div>
        </div>
    </div>
</div>

<body>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
    </script>
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.3.0/mdb.min.js"></script>
    <!-- appvaran Toastify -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        // global logined user data
        window.auth = @json(auth()->user());

        // show toast function with message and type
        const showToast = (message, type) => {
            if (type == "info") {
                Toastify({
                    text: message,
                    duration: 3000,
                    destination: "", // can put link 
                    newWindow: true,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    style: {
                        background: "linear-gradient(to right, #9CB1E9, #5B82EA)",
                    },
                    onClick: function() {} // Callback after click
                }).showToast();
            }
            if (type == "success") {
                Toastify({
                    text: message,
                    duration: 3000,
                    destination: "", // can put link 
                    newWindow: true,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    style: {
                        background: "linear-gradient(to right, #76CC68, #40CD29)",
                    },
                    onClick: function() {} // Callback after click
                }).showToast();
            }
            if (type == "error") {
                Toastify({
                    text: message,
                    duration: 3000,
                    destination: "", // can put link 
                    newWindow: true,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    style: {
                        background: "linear-gradient(to right, #F07E63, #F04D26)",
                    },
                    onClick: function() {} // Callback after click
                }).showToast();
            }
        }
    </script>
    <!-- Session flashing -->
    @if (session()->has('error'))
        <script>
            Toastify({
                text: "{{ session('error') }}",
                duration: 3000,
                destination: "", // can put link 
                newWindow: true,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                // className: ['bg-danger'],
                style: {
                    background: "linear-gradient(to right, #F58C7E, #F02C11)",
                },
                onClick: function() {} // Callback after click
            }).showToast();
        </script>
    @endif
    @if (session()->has('info'))
        <script>
            Toastify({
                text: "{{ session('info') }}",
                duration: 3000,
                destination: "", // can put link 
                newWindow: true,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: "linear-gradient(to right, #9CB1E9, #5B82EA)",
                },
                onClick: function() {} // Callback after click
            }).showToast();
        </script>
    @endif
    @if (session()->has('success'))
        <script>
            Toastify({
                text: "{{ session('success') }}",
                duration: 3000,
                destination: "", // can put link 
                newWindow: true,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: "linear-gradient(to right, #76CA86, #35CD52)",
                },
                onClick: function() {} // Callback after click
            }).showToast();
        </script>
    @endif
    @yield('script')
</body>

</html>
