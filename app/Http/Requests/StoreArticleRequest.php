<?php

namespace App\Http\Requests;

use App\Rules\NotString;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreArticleRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "name" => ["required", "string", "max:64"],
            "description" => ["required", "string", "max:2048"],
            "category" => ["required", "string", "max:64"],
            "price" => ["required", "numeric", "min:0", new NotString()],
            "currency" => ["required_unless:price,0", "string", "size:3"]
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json()->setStatusCode(400)
        );
    }
}
