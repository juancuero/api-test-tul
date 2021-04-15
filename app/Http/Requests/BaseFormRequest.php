<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

use ApiResponser;

class BaseFormRequest extends FormRequest
{
    public function failedValidation(Validator $validator)
    {

    $errors = (new ValidationException($validator))->errors();

    throw new HttpResponseException(response()->json([
        'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
        'message' => "Wrong data...",
        'data' => $errors,
    ], 200));
    
   }
}