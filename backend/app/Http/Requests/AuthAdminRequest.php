<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AuthAdminRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'min:6', 'max:255'],
        ];
    }

     public function attributes()
    {
        return [
            'email' => 'メールアドレス',
            'password' => 'パスワード',
        ];
    }

    public function messages()
    {
        return [
            // メールアドレスのエラー文
            'email.required' => ':attributeが入力されていません。',
            'email.email' => ':attributeはメールアドレスの形式で入力してください。',
            'email.max' => ':attributeは255文字以内で入力してください。',

            // パスワードのエラー文
            'password.required' => ':attributeが選択されていません。',
            'password.min' => ':attributeは 6文字以上で入力してください',
            'password.max' => ':attributeは 255文字以内で入力してください',
        ];
    }
}
