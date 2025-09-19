<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Authorization\UnauthorizedException;
use App\Exceptions\Validation\DataValidationException;
use App\Http\Controllers\Controller;
use App\Models\Export;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->user()->tokenCan(User::ABILITY_EXPORTS_INDEX_FULL))
            return $this->apiSuccessResponse([
                'exports' => Export::with(['user'])->orderBy('created_at', 'DESC')->get()
            ]);

        if ($request->user()->tokenCan(User::ABILITY_EXPORTS_INDEX))
            return $this->apiSuccessResponse([
                'exports' => Export::with(['user'])
                ->whereDate('created_at', Carbon::today())
                ->orderBy('created_at', 'DESC')
                ->get()
            ]); 

        throw new UnauthorizedException();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! $request->user()->tokenCan(User::ABILITY_EXPORTS_CREATE))
            throw new UnauthorizedException();

        $validator = Validator::make($request->all(), [
            'reason'    => 'required|string|min:3|max:255',
            'amount'    => 'required|numeric|max:999999.99',
            'comment'   => 'string|max:255',
        ]);

        if ($validator->fails())
            throw new DataValidationException($validator->errors()->toArray());

        return $this->apiSuccessResponse([
            'export' => Export::create([
                'user_id'       => $request->user()->id,
                'reason'        => $request->reason,
                'amount'        => $request->amount,
                'comment'       => $request->comment,
            ])
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Export  $export
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Export $export)
    {
        if (! $request->user()->tokenCan(User::ABILITY_EXPORTS_UPDATE))
            throw new UnauthorizedException();

        $validator = Validator::make($request->all(), [
            'reason'    => 'string|min:3|max:255',
            'amount'    => 'numeric|max:999999.99',
            'comment'   => 'string|max:255',
        ]);

        if ($validator->fails())
            throw new DataValidationException($validator->errors()->toArray());

        $export->reason  = $request->reason ?? $export->reason;
        $export->amount  = $request->amount ?? $export->amount;
        $export->comment = $request->comment ?? $export->comment;
        $export->save();

        return $this->apiSuccessResponse();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Export  $export
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Export $export)
    {
        if (! $request->user()->tokenCan(User::ABILITY_EXPORTS_DELETE))
            throw new UnauthorizedException();

        $export->delete();
        return $this->apiSuccessResponse();
    }
}
