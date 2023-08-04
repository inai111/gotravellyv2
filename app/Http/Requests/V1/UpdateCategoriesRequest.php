<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class UpdateCategoriesRequest extends FormRequest
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
        $id = $this->route('category');

        if($method=='PUT'){
            return [
                'name'=>['required',Rule::unique('categories','name')->ignore($id)],
                'active'=>[],
                'priorityOrder'=>[]
            ];
        }else{
            return [
                'name'=>['sometimes','required',Rule::unique('categories','name')->ignore($id)],
                'active'=>[],
                'priorityOrder'=>[]            
            ];
        }
    }

    protected function passedValidation(): void
    {
        $data = $this->validated();

        if(isset($data['priorityOrder'])) $data['priority_order'] = $this->priorityOrder;
        
        $data = Arr::except($data,['priorityOrder']);
        $this->replace($data);
    }
}
