<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'name' => 'required|string|max:100|regex:^[A-ZÀ-ȕa-z0-9 _]*[A-ZÀ-ȕa-z0-9][A-ZÀ-ȕa-z0-9 _]*$^',
            'info' => 'string|max:2000',
            'website' => 'nullable|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
            'facebook' => 'nullable|regex:/^(https?:\/\/)?(?:www.)?facebook.com([\/\w \.-]*)*\/?$/',
            'instagram' => 'nullable|regex:/^(https?:\/\/)?(?:www.)?instagram.com([\/\w \.-]*)*\/?$/',
            'twitter' => 'nullable|regex:/^(https?:\/\/)?(?:www.)?twitter.com([\/\w \.-]*)*\/?$/',
            'pinterest' => 'nullable|regex:/^(https?:\/\/)?(?:www.)?pinterest.com([\/\w \.-]*)*\/?$/',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
