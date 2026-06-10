@extends('layouts.dashboard')

@section('title', 'إضافة رب الأسرة')

@section('page-title')
طلبات قيد المراجعة
@endsection
@section('breadcrumb')

<a href="#">الرئيسية</a> &raquo;
<a href="#">طلبات قيد المراجعة</a> &raquo;
إضافة
@endsection

@section('content')
<livewire:member-request-table />
@endsection