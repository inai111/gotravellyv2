<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class StoreStatesRequest extends FormRequest
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
            'name'=>['required'],
            'countryId'=>['required','exists:countries,id']
        ];
    }

    protected function passedValidation(): void
    {
        $data = $this->validated();
        $data['country_id'] = $this->countryId??null;
        $data = Arr::except($data,['countryId']);
        $this->replace($data);
    }
}
