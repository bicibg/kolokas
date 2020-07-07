<?php
/**
 * Created by PhpStorm.
 * User: lisa
 * Date: 11/13/17
 * Time: 7:48 PM
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecipeUpdateRequest extends FormRequest
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
            'main_image' => 'image|mimes:jpeg,jpg,png',
            'existing_images' => 'array|max:5',
            'existing_images.*' => 'integer',
            'images' => 'bail|array|max:5|total_images_with_existing:5,existing_images',
            'images.*' => 'image|mimes:png,jpeg,jpg|max:8000',
            'description' => 'max:2000',
            'categories' => 'required',
            'ingredients' => 'required',
            'instructions' => 'required',
            'prep_time' => 'integer',
            'cook_time' => 'integer',
            'servings' => 'required|max:64',
            'notes' => 'max:2000',
            'agreement' => 'accepted',
        ];
    }

    public function messages()
    {
        return [
            'main_image' => 'A good quality photo of your creation is crucial and necessary',
            'categories' => 'A recipe requires at least one category',
            'prep_time' => 'An estimated preparation time is required',
            'cook_time' => 'An estimated cooking time is required',
            'servings' => 'We need to know the serving size for your recipe',
            'agreement' => 'You must accept our Terms and Conditions before you can submit this recipe',
        ];
    }
}
