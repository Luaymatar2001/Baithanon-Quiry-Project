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
<div class="container">
    <div class="row">
        <div class="col-12">
            <h3 class="mb-3">طلبات الزواج</h3>
            @livewire('marriage-requests-table')
        </div>
    </div>
</div>
@endsection