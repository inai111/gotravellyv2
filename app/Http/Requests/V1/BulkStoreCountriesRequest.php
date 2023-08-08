<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class BulkStoreCountriesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        return $user!=null&&$user->tokenCan('create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            '*.shortCode'=>['required','unique:countries,short_code','distinct'],
            '*.name'=>['required','distinct'],
            '*.timezone'=>[],
            '*.phoneCode'=>[],
            '*.continentId'=>['required','exists:continents,id']
        ];
    }

    protected function passedValidation(): void
    {
        $data = $this->validated();

        $dataReplace = collect($data)->map(function($item){
            $itemData = $item;
            $itemData['short_code'] = $item['shortCode'];
            $itemData['continent_id'] = $item['continentId'];

            if(isset($item['phoneCode'])) $itemData['phone_code'] = $item['phoneCode'];
            
            return Arr::except($itemData,['shortCode','phoneCode','continentId']);
        });
        $this->replace($dataReplace->toArray());
    }
}
