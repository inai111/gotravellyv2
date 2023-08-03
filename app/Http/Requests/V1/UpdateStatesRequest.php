<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStatesRequest extends FormRequest
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
                'name'=>['required']
            ];
        }else{
            return [
                'name'=>['sometimes','required']
            ];
        }
    }

    protected function passedValidation(): void
    {
        $data = $this->validated();
        $this->replace($data);
    }
}
