@extends('layouts.dashboard')

@section('title', 'إضافة المعالم')

@section('page-title')
إضافة المعالم
@endsection

@section('breadcrumb')
<a href="#">الرئيسية</a> &raquo;
<a href="#">المعالم</a> &raquo;
إضافة
@endsection

@section('content')
<livewire:locations-table />
@endsection