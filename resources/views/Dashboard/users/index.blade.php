@extends('layouts.dashboard')

@section('title', 'إضافة رب الأسرة')

@section('page-title')
إضافة رب الأسرة
@endsection

@section('breadcrumb')
<a href="#">الرئيسية</a> &raquo;
<a href="#">المستخدمين</a> &raquo;
إضافة
@endsection

@section('content')
@if(session('success'))
<script>
Swal.fire({
  icon: 'success',
  title: 'نجاح',
  text: '{{ session('success') }}'
})
</script>
@endif

<div class="mt-4 overflow-x-auto">
<div class="relative bg-neutral-primary-soft shadow-xs rounded-base border border-default">
    <div class="overflow-x-auto max-w-full">
    <div class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 p-4">
        <div>
        <!-- <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="inline-flex items-center justify-center text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary shadow-xs font-medium leading-5 rounded-base text-sm px-3 py-2 focus:outline-none" type="button">
            Action
            <svg class="w-4 h-4 ms-1.5 -me-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/></svg>
        </button> -->
<button
    id="openAddModal"
    class="inline-flex items-center gap-2
           text-white bg-green-500 hover:bg-green-700
           focus:ring-2 focus:ring-green-300
           shadow-sm font-medium rounded-md
           text-sm px-3 py-2 transition">
    إضافة مستخدم جديد
    <i class="fa-solid fa-plus"></i>
</button>
<button
    type="button"
    id="deleteSelectedBtn"
    class="inline-flex items-center gap-2
           text-white bg-red-500 hover:bg-red-700
           focus:ring-2 focus:ring-red-300
           shadow-sm font-medium rounded-md
           text-sm px-3 py-2 transition">
    حذف المستخدمين المحددين
    <i class="fa-solid fa-trash"></i>
</button>


        <!-- Dropdown menu -->
<div id="dropdown"
     class="absolute mt-2 z-50 hidden w-36
            bg-white dark:bg-gray-100
            border border-gray-200 dark:border-gray-700
            rounded-lg shadow-lg">
             <ul class="p-2 text-sm text-body font-medium" aria-labelledby="dropdownDefaultButton">
            <li>
                <a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Reward</a>
            </li>
            <li>
                <a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Promote</a>
            </li>
            <li>
                <a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Archive</a>
            </li>
            <li>
                <a href="#" class="inline-flex items-center w-full p-2 text-fg-danger hover:bg-neutral-tertiary-medium rounded">Delete</a>
            </li>
            </ul>
        </div>
        </div>
        <label for="input-group-1" class="sr-only">Search</label>
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-body" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/></svg>
            </div>
            <input type="text" id="input-group-1" class="block w-full max-w-96 ps-9 pe-3 py-2 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body" placeholder="Search">
        </div>
    </div>
    <form id="deleteUsersForm"
      method="POST"
      action="{{ route('users.bulkDelete') }}">
    @csrf
    @method('DELETE')
    <table class="w-full text-sm text-left rtl:text-right text-body">
        <thead class="text-sm text-body bg-neutral-secondary-medium border-b border-t border-default-medium">
         
            <tr>
                <th scope="col" class="p-4">
                    <div class="flex items-center">
                        <!-- <input id="table-checkbox-45" type="checkbox" value="" class="w-4 h-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft"> -->
                        <label for="table-checkbox-45" class="sr-only">Table checkbox</label>
                    </div>
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    الإسم الكامل
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    البريد الإلكتروني
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    الحالة
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    الإجراءات
                </th>
            </tr>
        </thead>
        <tbody>
    @foreach( $users as $user )
            <tr class="bg-neutral-primary-soft hover:bg-neutral-secondary-medium">
                <td class="w-4 p-4">
                    <div class="flex items-center">
                        <input
    type="checkbox"
    name="users[]"
    value="{{ $user->id }}"
    class="user-checkbox w-4 h-4 border border-default-medium rounded-xs bg-neutral-secondary-medium">

                        <label for="table-checkbox-50" class="sr-only">Table checkbox</label>
                    </div>
                </td>
                <th scope="row" class="flex items-center px-6 py-4 font-medium text-heading whitespace-nowrap">
                    <div class="ps-3">
                        <div class="text-base font-semibold">{{$user->name}}</div>
                    </div>
                </th>
                
                <td class="px-6 py-4">
                   {{$user->email}}
                </td>
                  <td class="px-6 py-4">
                   @if($user->role == 'admin')
                       <span class="text-green-600 font-semibold">admin</span>
                   @else
                          <span class="text-red-600 font-semibold">supervisor</span>
                     @endif

                </td>
                <td class="px-6 py-4">
                    <button
                        type="button"
                        class="changePasswordBtn text-red-600 hover:underline"
                        data-id="{{ $user->id }}"
                    >
                    <i class="fa-regular fa-pen-to-square"></i>
                        تغيير كلمة المرور
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </form>

</div>

<div id="addUserModal"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">

    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
        <h2 class="text-lg font-bold mb-4">إضافة مستخدم جديد</h2>

        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            <div class="mb-3">
                <label class="block text-sm mb-1">الإسم الكامل</label>
                <input name="name" required
                       class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-3">
                <label class="block text-sm mb-1">البريد الإلكتروني</label>
                <input type="email" name="email" required
                       class="w-full border rounded px-3 py-2">
            </div>
            <div class="mb-3">
                <label class="block text-sm mb-1">نوع المستخدم</label>
                <select name="role" required
                        class="w-full border rounded px-3 py-2">
                    <option value="admin">مشرف</option>
                    <option value="supervisor"> مشرف أعلى</option>
                </select>

            </div>

            <div class="mb-4">
                <label class="block text-sm mb-1">كلمة المرور</label>
                <input type="password" name="password" required
                       class="w-full border rounded px-3 py-2">
            </div>

            <div class="flex justify-end gap-2">
                <button type="button"
                        id="closeAddModal"
                        class="px-4 py-2 border rounded">
                    إلغاء
                </button>

                <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded">
                    حفظ
                </button>
            </div>
        </form>
    </div>
</div>

<div id="passwordModal"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">

    <div class="bg-white rounded-lg shadow-lg w-full max-w-sm p-6">
        <h2 class="text-lg font-bold mb-4">تغيير كلمة المرور</h2>

        <form id="passwordForm" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm mb-1">كلمة المرور الجديدة</label>
                <input type="password" name="password" required
                       class="w-full border rounded px-3 py-2">
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" id="closePasswordModal"
                        class="px-4 py-2 border rounded">
                    إلغاء
                </button>

                <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded">
                    حفظ
                </button>
            </div>
        </form>
    </div>
</div>

</div>
</div>
<script>
const openBtn  = document.getElementById('openAddModal');
const modal    = document.getElementById('addUserModal');
const closeBtn = document.getElementById('closeAddModal');

openBtn.onclick = () => {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
};

closeBtn.onclick = () => {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
};

// إغلاق عند الضغط خارج المودال
modal.addEventListener('click', e => {
    if (e.target === modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
});
</script>
<script>
document.getElementById('deleteSelectedBtn').addEventListener('click', function () {
    const checkboxes = document.querySelectorAll('.user-checkbox:checked');

    if (checkboxes.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'تنبيه',
            text: 'يرجى تحديد مستخدم واحد على الأقل'
        });
        return;
    }

    Swal.fire({
        title: 'هل أنت متأكد؟',
        text: 'سيتم حذف المستخدمين المحددين نهائيًا',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'نعم، احذف',
        cancelButtonText: 'إلغاء'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('deleteUsersForm').submit();
        }
    });
});
</script>

<script>
const passwordModal = document.getElementById('passwordModal');
const passwordForm  = document.getElementById('passwordForm');

document.querySelectorAll('.changePasswordBtn').forEach(btn => {
    btn.onclick = () => {
        passwordForm.action = `/users/${btn.dataset.id}/password`;
        passwordModal.classList.remove('hidden');
        passwordModal.classList.add('flex');
    };
});

document.getElementById('closePasswordModal').onclick = () => {
    passwordModal.classList.add('hidden');
    passwordModal.classList.remove('flex');
};
</script>



@endsection
