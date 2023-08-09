<?php

namespace App\Http\Requests\V1;

use Arr;
use Illuminate\Foundation\Http\FormRequest;

class BulkStoreCitiesRequest extends FormRequest
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
            //
            '*.name'=>['required'],
            '*.stateId'=>['required','exists:states,id'],
            '*.lat'=>[],
            '*.lng'=>[],
        ];
    }

    protected function passedValidation()
    {
        $data = $this->validated();
        $dataItem = collect($data)->map(function($item){
            $itemData = $item;
            $itemData['state_id'] = $item['stateId'];
            return Arr::except($itemData,['stateId']);
        });

        $this->replace($dataItem->toArray());
    }
}
