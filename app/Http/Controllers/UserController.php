<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
      public function index()
    {
        $users = User::latest()->paginate(10);
        return view('Dashboard.users.index', compact('users'));
    }

    
    public function store(UserRequest $request)
    {
     User::create([
    'name' => $request->name,
    'email' => $request->email,
    'password' => Hash::make($request->password),
    'email_verified_at' => now(), // اختياري
    'role' => $request->role,
     ]);
        // User::create($request->validated());
        return back()->with('success', 'تمت الإضافة بنجاح');
    }

    public function update(UserRequest $request, User $user)
    {
        $user->update($request->validated());
        return back()->with('success', 'تم التحديث بنجاح');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'تم الحذف');
    }

    public function show()  {
        return view('Dashboard.users.show');
    }

    public function updatePassword(Request $request, User $user)
{
    $request->validate([
        'password' => 'required|min:6'
    ]);

    $user->update([
        'password' => bcrypt($request->password)
    ]);

    return back()->with('success', 'تم تغيير كلمة المرور بنجاح');
}


public function bulkDelete(Request $request)
{
    $request->validate([
        'users' => 'required|array',
        'users.*' => 'exists:users,id',
    ]);

    User::whereIn('id', $request->users)->delete();

    return redirect()->back()->with('success', 'تم حذف المستخدمين بنجاح');
}
}
