<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

       return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $this->user?->id,
            'role' => 'required|in:admin,supervisor',
            'password' => 'nullable|min:6'
        ];
    }
    
    public function messages(): array
    {
        return [
            'name.required' => 'الاسم مطلوب',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'صيغة البريد الإلكتروني غير صحيحة',
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل',
            'role.required' => 'الدور مطلوب',
            'role.in' => 'الدور غير صالح',
            'password.min' => 'كلمة المرور يجب أن تكون على الأقل 6 أحرف',
        ];
    }
}
