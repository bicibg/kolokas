<?php
/**
 * Created by PhpStorm.
 * User: lisa
 * Date: 11/13/17
 * Time: 7:48 PM
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RecipeCreateRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        $this->merge($this->lang[app()->getLocale()]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => [
                'bail',
                'required',
                Rule::unique('recipes', 'title')->where(function ($query) {
                    $query->where('user_id', auth()->user()->id);
                })
            ],
//            'main_image' => 'required|image|mimes:jpeg,jpg,png',
//            'images' => 'array|max:5',
//            'images.*' => 'image|mimes:png,jpeg,jpg|max:8000',
            'description' => 'max:2000',
            'categories' => 'required|array',
//            'ingredients' => 'required',
//            'instructions' => 'required',
//            'prep_time' => 'integer',
//            'cook_time' => 'integer',
//            'servings' => 'required|max:64',
//            'notes' => 'max:2000',
            'agreement' => 'accepted',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'A title is required',
            'title.unique' => 'Looks like you already have a recipe with this title',
            '*.regex' => 'You can only have text and numbers in :attribute field',
            'main_image' => 'A good quality photo of your creation is crucial and necessary',
            'images' => 'You can upload maximum of 5 images',
            'categories' => 'A recipe requires at least one category',
            'prep_time' => 'An estimated preparation time is required',
            'cook_time' => 'An estimated cooking time is required',
            'servings' => 'We need to know the serving size for your recipe',
            'agreement' => 'You must accept our Terms and Conditions before you can submit this recipe',
        ];
    }
}
