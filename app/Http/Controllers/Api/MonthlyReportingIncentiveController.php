<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Authorization\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\MonthlyReportingIncentive\StoreRequest;
use App\Http\Requests\Api\MonthlyReportingIncentive\UpdateRequest;
use App\Models\MonthlyReportingIncentive;
use App\Models\User;

class MonthlyReportingIncentiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! request()->user()->tokenCan(User::ABILITY_MONTHLY_REPORTING_INCENTIVES_INDEX))
            throw new UnauthorizedException();

        return $this->apiSuccessResponse([
            'reports' => MonthlyReportingIncentive::orderBy('date', 'DESC')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $reqData   = collect($request->validated());
        $reqData->put('by', $request->user()->id);
        $reqData->put('date', now());
        
        return $this->apiSuccessResponse([
            'report' => MonthlyReportingIncentive::create($reqData->toArray())
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MonthlyReportingIncentive  $monthlyReportingIncentive
     * @return \Illuminate\Http\Response
     */
    public function show(MonthlyReportingIncentive $monthlyReportingIncentive)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MonthlyReportingIncentive  $monthlyReportingIncentive
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, MonthlyReportingIncentive $monthlyReportingIncentive)
    {
        $monthlyReportingIncentive->update($request->validated());
        return $this->apiSuccessResponse();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MonthlyReportingIncentive  $monthlyReportingIncentive
     * @return \Illuminate\Http\Response
     */
    public function destroy(MonthlyReportingIncentive $monthlyReportingIncentive)
    {
        if (! request()->user()->tokenCan(User::ABILITY_MONTHLY_REPORTING_INCENTIVES_DELETE))
            throw new UnauthorizedException();

        $monthlyReportingIncentive->delete();
        return $this->apiSuccessResponse();
    }
}
