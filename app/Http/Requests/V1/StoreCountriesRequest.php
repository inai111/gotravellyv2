<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class StoreCountriesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        return $user != null && $user->tokenCan('create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
            'shortCode'=>['required','unique:countries,short_code'],
            'name'=>['required'],
            'timezone'=>[],
            'phoneCode'=>[],
            'continentId'=>['required','exists:continents,id']
        ];
    }

    protected function passedValidation(): void
    {
        $data = $this->validated();
        $data['phone_code'] = $this->phoneCode?? null;
        $data['short_code'] = $this->shortCode?? null;
        $data['continent_id'] = $this->continentId?? null;
        
        $data = Arr::except($data,['continentId','phoneCode','shortCode']);
        $this->replace($data);
    }
}
