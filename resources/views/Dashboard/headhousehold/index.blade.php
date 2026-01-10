@extends('layouts.dashboard')

@section('title', 'إضافة رب الأسرة')

@section('page-title')
إضافة رب الأسرة
@endsection

@section('breadcrumb')
<a href="#">الرئيسية</a> &raquo;
<a href="#">رب الأسرة</a> &raquo;
إضافة
@endsection

@section('content')
{{-- <div class="mb-4">
   <a href="{{ route('headhousehold.create') }}"
class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
إضافة جديد
</a>
</div>
<div class="relative z-0"> --}}
   <livewire:head-households-table />
</div>

@endsection