@extends('layouts.dashboard')

@section('title', 'إضافة الأزواج')

@section('page-title')
إضافة أزواج
@endsection

@section('breadcrumb')
<a href="#">الرئيسية</a> &raquo;
<a href="#">الأزواج</a> &raquo;
إضافة
@endsection

@section('content')


@livewire('partners-form' ,['partnerId'=>$id ?? null]);
@endsection