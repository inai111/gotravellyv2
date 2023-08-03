<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class UpdateCountriesRequest extends FormRequest
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
                'shortCode'=>['required'],
                'name'=>['required'],
                'timezone'=>[],
                'phoneCode'=>[],
            ];
        }else{
            return [
                //
                'shortCode'=>['sometimes','required'],
                'name'=>['sometimes','required'],
                'timezone'=>[],
                'phoneCode'=>[],
            ];
        }
    }

    protected function passedValidation(): void
    {
        $data = $this->validated();
        if(isset($data['phoneCode'])) $data['phone_code'] = $this->phoneCode;
        if(isset($data['shortCode'])) $data['short_code'] = $this->shortCode;
        
        $data = Arr::except($data,['phoneCode','shortCode']);
        $this->replace($data);
    }
}
