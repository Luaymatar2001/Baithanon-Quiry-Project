@extends('layouts.dashboard')

@section('title', 'إضافة أطفال')

@section('page-title')
إضافة أطفال
@endsection

@section('breadcrumb')
<a href="#">الرئيسية</a> /
<a href="#">إضافة أطفال</a> /
إضافة
@endsection

@section('content')

@livewire('childrenTable')

@endsection