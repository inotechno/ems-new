
@extends('beautymail::templates.ark')

@section('content')

    @include('beautymail::templates.ark.contentStart')

       {!! $body !!}

    @include('beautymail::templates.ark.contentEnd')

@stop
