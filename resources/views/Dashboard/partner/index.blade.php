@extends('layouts.dashboard')

@section('title', 'إضافة الأزواج')

@section('page-title')
إضافة الأزواج
@endsection

@section('breadcrumb')
<a href="#">الرئيسية</a> &raquo;
<a href="#">الأزواج</a> &raquo;
إضافة
@endsection

@section('content')

   <livewire:partners-table />

@endsection