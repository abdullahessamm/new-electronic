<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Authorization\UnauthorizedException;
use App\Exceptions\Models\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Employees\CreateEmployeeRequest;
use App\Http\Requests\Api\Employees\UpdateEmployeeRequest;
use App\Http\Requests\Api\Employees\UpdateFeesRequest;
use App\Models\Employee;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class EmployeesController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        if (! request()->user()->tokenCan(User::ABILITY_EMPLOYEES_INDEX))
            throw new UnauthorizedException();

        return $this->apiSuccessResponse([
            'employees' => Employee::get()
        ]);
    }

    /**
     * @param integer $empId
     * @return JsonResponse
     */
    public function show(int $empId)
    {
        if (! request()->user()->tokenCan(User::ABILITY_EMPLOYEES_INDEX))
            throw new UnauthorizedException();

        $emp = Employee::with('fees')->find($empId);

        if (! $emp)
            throw new NotFoundException(Employee::class, $empId);

        $month = new Carbon('' . now()->month . '/1' . '/' . now()->year);
        $emp->fees()->firstOrCreate([
            'month' => $month
        ]);

        return $this->apiSuccessResponse([
            'employee' => $emp->refresh()
        ]);
    }

    public function create(CreateEmployeeRequest $request)
    {
        return $this->apiSuccessResponse([
            'employee' => Employee::create($request->validated())
        ]);
    }

    /**
     * @param UpdateEmployeeRequest $request
     * @param integer $empId
     * @return JsonResponse
     */
    public function update(UpdateEmployeeRequest $request, int $empId)
    {
        Employee::where('id', $empId)->update($request->validated());
        return $this->apiSuccessResponse();
    }

    /**
     * @param UpdateFeesRequest $request
     * @param integer $empId
     * @return JsonResponse
     */
    public function updateFees(UpdateFeesRequest $request, int $empId)
    {
        $emp = Employee::with('fees')->find($empId);

        if (! $emp)
            throw new NotFoundException(Employee::class, $empId);

        $reqData = collect($request->validated());
        $month = $reqData->get('month');
        $month = new Carbon($month);
        $month = new Carbon("$month->month/1/$month->year");

        $empFee = $emp->fees->filter(function ($fee) use ($month) {
            return $fee->month->month === $month->month;
        })->first();
        if(! $empFee)
            throw new NotFoundException('\\EmployeeFee', "$month->month/$month->year");

        if ($reqData->has('discounts'))
            $empFee->discounts = $reqData->get('discounts');

        if ($reqData->has('obtain') && ! $empFee->obtained_at)
            $empFee->obtained_at = now();

        $emp->push();

        return $this->apiSuccessResponse();
    }

    public function delete(int $empId)
    {
        Employee::where('id', $empId)->delete();
        return $this->apiSuccessResponse();
    }
}
