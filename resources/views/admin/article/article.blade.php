@extends('admin.layout.dashboard')
@section('content-dashboard')
    <div id="root"></div>
    <script>
        window.auth = @json(auth()->user());
    </script>
    <script src="{{ mix('/js/articleCreate.js') }}"></script>
@endsection
