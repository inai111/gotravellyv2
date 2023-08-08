<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class BulkStoreStatesRequest extends FormRequest
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
            '*.name'=>'required',
            '*.countryId'=>'required|exists:countries,id'
        ];
    }

    protected function passedValidation(): void
    {
        $data = $this->validated();

        $dataItem = collect($data)->map(function($item){
            $itemData = $item;
            $itemData['country_id'] = $item['countryId'];
            return Arr::except($itemData,['countryId']);
        });
        $this->replace($dataItem->toArray());
    }
}
