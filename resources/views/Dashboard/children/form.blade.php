@extends('layouts.dashboard')

@section('title', 'إضافة أطفال')

@section('page-title')
إضافة أطفال
@endsection

@section('breadcrumb')
<a href="#">الرئيسية</a> &raquo;
<a href="#">الأطفال</a> &raquo;
إضافة
@endsection

@section('content')
@livewire('children-form' , ['childrenId'=> $id ?? null]);
@endsection