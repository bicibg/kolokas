<?php
/**
 * Created by PhpStorm.
 * User: lisa
 * Date: 11/13/17
 * Time: 7:48 PM
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RecipeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => [
                'required',
                Rule::unique('recipes', 'title')->where(function ($query) {
                    $query->where('user_id', auth()->user()->id);
                })
            ],
            'description' => 'max:1000',
            'ingredients' => 'required',
            'instructions' => 'required',
            'notes' => 'max:1000',
            'prep_time' => 'integer',
            'cook_time' => 'integer',
            'servings' => 'max:64',
            'main_image' => 'required',
            'agreement' => 'accepted'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'A title is required',
            'title.unique' => 'Looks like you already have a recipe with this title',
            'prep_time' => 'An estimated preparation time is required',
            'cook_time' => 'An estimated cooking time is required',
            'servings' => 'We need to know the serving size for your recipe',
            'main_image' => 'A good quality photo of your creation is crucial and necessary',
            'agreement' => 'You must accept our Terms and Conditions before you can submit this recipe'
        ];
    }
}
