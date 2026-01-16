@extends('layouts.dashboard')

@section('title', 'إضافة المناطق والمعالم')

@section('page-title')
إضافة المناطق والمعالم
@endsection

@section('breadcrumb')
<a href="#">الرئيسية</a> &raquo;
<a href="#">المناطق والمعالم</a> &raquo;
إضافة
@endsection

@section('content')
@livewire('locations-form' , ['locationId'=> $id ?? null]);
@endsection