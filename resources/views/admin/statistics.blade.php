@extends('admin.layout.dashboard')
@section('content-dashboard')
    <div id="root"></div>
    <script src="{{ env("APP_URL") . '/js/statistics.js' }}"></script>
    {{-- <script src="{{ mix('/js/statistics.js') }}"></script> --}}
@endsection