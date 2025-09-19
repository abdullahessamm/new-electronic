<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Authorization\UnauthorizedException;
use App\Exceptions\Validation\DataValidationException;
use App\Http\Controllers\Controller;
use App\Models\Import;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->user()->tokenCan(User::ABILITY_IMPORTS_INDEX_FULL))
            return $this->apiSuccessResponse([
                'imports' => Import::with(['user'])->orderBy('created_at', 'DESC')->get()
            ]);

        if ($request->user()->tokenCan(User::ABILITY_IMPORTS_INDEX))
            return $this->apiSuccessResponse([
                'imports' => Import::with(['user'])
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
        if (! $request->user()->tokenCan(User::ABILITY_IMPORTS_CREATE))
            throw new UnauthorizedException();

        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|min:3|max:70',
            'cost'          => 'required|numeric|max:999999.99',
            'comment'       => 'string|max:255',
        ]);

        if ($validator->fails())
            throw new DataValidationException($validator->errors()->toArray());

        return $this->apiSuccessResponse([
            'import' => Import::create([
                'user_id'       => $request->user()->id,
                'customer_name' => $request->customer_name,
                'cost'          => $request->cost,
                'comment'       => $request->comment
            ])
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Import  $import
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Import $import)
    {
        if (! $request->user()->tokenCan(User::ABILITY_IMPORTS_UPDATE))
            throw new UnauthorizedException();

        $validator = Validator::make($request->all(), [
            'customer_name' => 'string|min:3|max:70',
            'cost'          => 'numeric|max:999999.99',
            'comment'       => 'string|max:255',
        ]);

        if ($validator->fails())
            throw new DataValidationException($validator->errors()->toArray());

        $import->customer_name = $request->customer_name ?? $import->customer_name;
        $import->cost = $request->cost ?? $import->cost;
        $import->comment = $request->comment ?? $import->comment;
        $import->save();

        return $this->apiSuccessResponse();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Import  $import
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Import $import)
    {
        if (! $request->user()->tokenCan(User::ABILITY_IMPORTS_DELETE))
            throw new UnauthorizedException();

        $import->delete();
        return $this->apiSuccessResponse();
    }
}
