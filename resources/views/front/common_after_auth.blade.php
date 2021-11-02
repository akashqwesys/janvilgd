@extends('front.layout_2')
@section('title', $title)
@section('css')

@endsection

@section('content')
{!! html_entity_decode($data->content) !!}
@endsection

@section('js')

@endsection