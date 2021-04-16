<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Category;

class StoreProductRequest extends BaseFormRequest
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
        switch($this->method()) {

            case 'POST':
                return [
                    'name' => ['required', 'string', 'max:100'],
                    'description' => ['required', 'string', 'max:300'], 
                    'stock' => ['numeric','min:0'],  
                    'image' => ['nullable','image','mimes:jpeg,png,jpg,gif,svg','max:2048'],  
                    'price' => ['numeric','min:0'], 
                    'category_id' => ['required','exists:categories,id','subcategory'], 
                ];

            case 'PUT':
                    return [
                        'name' => ['string', 'max:100'],
                        'description' => [ 'string', 'max:300'], 
                        'stock' => ['numeric','min:0'],  
                        'price' => ['numeric','min:0'], 
                        'category_id' => ['exists:categories,id','subcategory'], 
                    ];  

            default:break;
        }
    }

    public function withValidator($validator)
    {
        $validator->addExtension('subcategory', function ($attribute, $value, $parameters, $validator) {

            return !Category::where('id',$value)->where('parent_id',null)->exists();
        });

        $validator->addReplacer('subcategory', function ($message, $attribute, $rule, $parameters, $validator) {
            return __("The :attribute can't be parent.", compact('attribute'));
        });
    }
}
