@extends('layouts.dashboard')

@section('title', 'إضافة المدن')

@section('page-title')
إضافة المدن
@endsection

@section('breadcrumb')
<a href="#">الرئيسية</a> &raquo;
<a href="#">المدن</a> &raquo;
إضافة
@endsection

@section('content')
@livewire('city-form' , ['cityId'=> $id ?? null]);
@endsection