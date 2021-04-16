<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Category;

class StoreCategoryRequest extends BaseFormRequest
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
            'name' => ['required', 'string', 'max:100', 'unique:categories,name'],
            'parent_id' => ['exists:categories,id','nullable','isParent'], 
        ];
    }

    public function withValidator($validator)
    {
        $validator->addExtension('isParent', function ($attribute, $value, $parameters, $validator) {

            return Category::where('id',$value)->where('parent_id',null)->exists();
        });

        $validator->addReplacer('isParent', function ($message, $attribute, $rule, $parameters, $validator) {
            return __("The :attribute must be parent.", compact('attribute'));
        });
    }
}
