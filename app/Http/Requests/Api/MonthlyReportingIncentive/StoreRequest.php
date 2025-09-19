<?php

namespace App\Http\Requests\Api\MonthlyReportingIncentive;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return request()->user()->tokenCan(User::ABILITY_MONTHLY_REPORTING_INCENTIVES_CREATE);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'case_number'       => 'required|string|max:60',
            'client_name'       => 'required|string|max:60',
            'warranty_status'   => 'required|string|max:100',
            'collection_fees'   => 'required|numeric|min:0|max:999999.99',
            'sap_number'        => 'required|string|max:100',
            'comment'           => 'string|max:65500',
            'damaged_position'  => 'boolean'
        ];
    }
}
