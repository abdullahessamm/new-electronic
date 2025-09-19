<?php

namespace App\Http\Requests\Api\MonthlyReportingIncentive;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return request()->user()->tokenCan(User::ABILITY_MONTHLY_REPORTING_INCENTIVES_UPDATE);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'case_number'       => 'string|max:60',
            'client_name'       => 'string|max:60',
            'warranty_status'   => 'string|max:100',
            'collection_fees'   => 'numeric|min:0|max:999999.99',
            'sap_number'        => 'string|max:100',
            'comment'           => 'string|nullable|max:65500',
            'damaged_position'  => 'boolean'
        ];
    }
}
