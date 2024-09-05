<!doctype html>
<html lang="en">

@include('layouts.partials.head')

<body data-sidebar="{{ session('theme', 'light') }}" data-layout-mode="{{ session('theme', 'light') }}">

    {{$slot}}
    <!-- end account-pages -->

    <!-- JAVASCRIPT -->
    @include('layouts.partials.plugin')
</body>

</html>
