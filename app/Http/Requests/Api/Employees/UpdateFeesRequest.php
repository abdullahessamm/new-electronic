<?php

namespace App\Http\Requests\Api\Employees;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFeesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return request()->user()->tokenCan(User::ABILITY_EMPLOYEES_UPDATE);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'month'                 => ['required', 'date'],
            'discounts'             => ['array'],
            'discounts.*.amount'    => ['required', 'numeric'],
            'discounts.*.reason'    => ['required', 'string'],
            'obtain'                => ['boolean']
        ];
    }
}
