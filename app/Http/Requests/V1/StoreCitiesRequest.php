<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class StoreCitiesRequest extends FormRequest
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
            'stateId'=>['required','exists:states,id'],
            'lat'=>[],
            'lng'=>[],
        ];
    }

    protected function passedValidation(): void
    {
        $data = $this->validated();
        $data['state_id'] = $this->stateId??null;
        $data = Arr::except($data,['stateId']);
        $this->replace($data);
    }
}
