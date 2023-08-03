<?php

namespace App\Http\Requests\V1;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContinentsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        return $user != null && $user->tokenCan('update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    // public function rules(): array
    public function rules(): array
    {
        $id = $this->route('continent');
        $method = $this->method();

        if($method=='PUT'){
            return [
                'name'=>['required',Rule::unique('continents','name')->ignore($id)]
            ];
        }else{
            return [
                'name'=>['sometimes','required',Rule::unique('continents','name')->ignore($id)]
            ];
        }

    }
}
