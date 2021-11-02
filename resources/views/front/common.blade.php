@extends('front.layout_1')
@section('title', $data->name)
@section('content')
    {!! html_entity_decode($data->content) !!}
@endsection