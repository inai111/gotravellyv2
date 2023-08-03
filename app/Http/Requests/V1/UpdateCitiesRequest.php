<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class UpdateCitiesRequest extends FormRequest
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
    public function rules(): array
    {
        $method = $this->method();

        if($method=='PUT'){
            return [
                'name'=>['required'],
                'lat'=>[],
                'lng'=>[],
            ];
        }else{
            return [
                'name'=>['sometimes','required'],
                'lat'=>[],
                'lng'=>[],
            ];
        }
    }

    protected function passedValidation(): void
    {
        $data = $this->validated();
        $this->replace($data);
    }
}
