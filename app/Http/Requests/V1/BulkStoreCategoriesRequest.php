<?php

namespace App\Http\Requests\V1;

use Arr;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BulkStoreCategoriesRequest extends FormRequest
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
            '*.name'=>'required|unique:categories,name|distinct',
            '*.active'=>[Rule::in([0,1])],
            '*.priorityOrder'=>[]            
        ];
    }

    protected function passedValidation(): void
    {
        $data = $this->validated();
        $dataItem = collect($data)->map(function($item){
            $itemData = $item;
            if(isset($item['priorityOrder'])) $itemData['priority_order'] = $item['priorityOrder'];

            return Arr::except($itemData,['priorityOrder']);
        });

        $this->replace($dataItem->toArray());
    }
}
