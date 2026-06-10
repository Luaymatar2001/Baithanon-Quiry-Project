@extends('layouts.dashboard')

@section('title', 'إضافة محافظة')

@section('page-title')
إضافة محافظة
@endsection

@section('breadcrumb')
<a href="#">الرئيسية</a> &raquo;
<a href="#">المحافظات</a> &raquo;
إضافة
@endsection

@section('content')
@livewire('governorate-form' , ['governorateId'=> $id ?? null]);
@endsection