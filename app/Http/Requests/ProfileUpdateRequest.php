<?php
/**
 * Created by PhpStorm.
 * User: lisa
 * Date: 11/13/17
 * Time: 7:48 PM
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:100|regex:^[A-ZÀ-ȕa-z0-9 _]*[A-ZÀ-ȕa-z0-9][A-ZÀ-ȕa-z0-9 _]*$^',
            'website' => 'string|max:200|regex:https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)',
            'facebook' => 'string|regex:(?:(?:http|https):\/\/)?(?:www.)?facebook.com\/(?:(?:\w)*#!\/)?(?:pages\/)?(?:[?\w\-]*\/)?(?:profile.php\?id=(?=\d.*))?([\w\-]*)?',
            'instagram' => 'string|regex:(?:(?:http|https):\/\/)?(?:www.)?instagram\.com\/[a-z\d-_]{1,255}\s*$/i',
            'twitter' => 'string|regex:(?:(?:http|https):\/\/)?(?:www.)?twitter\.com\/(?:(?:\w)*#!\/)?(?:pages\/)?(?:[\w\-]*\/)*([\w\-]*)$/i',
            'pinterest' => 'string|regex:(?:(?:http|https):\/\/)?(?:www.)?pinterest\.com\/[a-z\d-_]{1,255}\s*$/i',
        ];
    }

    public function messages()
    {
        return [
            'name.regex' => 'You can only have text and numbers in name field',
            'website.regex' => 'Please enter a valid website URL',
            'twitter.regex' => 'Please enter a valid Twitter profile URL',
            'instagram.regex' => 'Please enter a valid Instagram profile URL',
            'facebook.regex' => 'Please enter a valid Facebook profile URL',
            'pinterest.regex' => 'Please enter a valid Pinterest feed URL',
        ];
    }
}
