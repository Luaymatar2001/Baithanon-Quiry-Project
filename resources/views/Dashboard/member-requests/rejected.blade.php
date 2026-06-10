@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h3 class="mb-3">طلبات الأعضاء - المرفوضة</h3>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>الاسم</th>
                                    <th>رقم الهوية</th>
                                    <th>صلة القرابة</th>
                                    <th>تاريخ الميلاد</th>
                                    <th>الحالة الصحية</th>
                                    <th>سبب الرفض</th>
                                    <th>تمت المراجعة بواسطة</th>
                                    <th>تاريخ المراجعة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($requests as $r)
                                <tr>
                                    <td>{{ $r->FName }} {{ $r->SName }} {{ $r->TName }} {{ $r->LName }}</td>
                                    <td>{{ $r->PersonId }}</td>
                                    <td>{{ $r->relation }}</td>
                                    <td>{{ $r->BirthDate?->format('Y-m-d') }}</td>
                                    <td>{{ $r->health_status }}</td>
                                    <td>{{ $r->reject_reason ?? '-' }}</td>
                                    <td>{{ $r->reviewed_by ?? '-' }}</td>
                                    <td>{{ $r->reviewed_at?->format('Y-m-d H:i') ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">لا توجد طلبات مرفوضة</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection