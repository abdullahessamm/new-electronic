<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\SparePartsPermit;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\Validation\DataValidationException;
use App\Exceptions\Authorization\UnauthorizedException;

class SparePartsPermitsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->user()->tokenCan(User::ABILITY_SPARE_PARTS_PERMITS_INDEX_FULL))
            return $this->apiSuccessResponse([
                'spare_parts_permits' => SparePartsPermit::with('user')->orderBy('created_at', 'DESC')->get()
            ]);

        if ($request->user()->tokenCan(User::ABILITY_SPARE_PARTS_PERMITS_INDEX))
            return $this->apiSuccessResponse([
                'spare_parts_permits' => SparePartsPermit::with('user')
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
        if (! $request->user()->tokenCan(User::ABILITY_SPARE_PARTS_PERMITS_CREATE))
            throw new UnauthorizedException();

        $validator = Validator::make($request->all(), [
            'permit_number' => 'required|string|min:3|max:60',
            'case_number'   => 'required|string|min:1|max:60',
            'client_name'   => 'required|string|min:1|max:60',
            'description'   => 'required|max:255',
        ]);

        if ($validator->fails())
            throw new DataValidationException($validator->errors()->toArray());

        return $this->apiSuccessResponse([
            'spare_parts_permit' => SparePartsPermit::create([

                'user_id'       => $request->user()->id,
                'permit_number' => $request->permit_number,
                'case_number'   => $request->case_number,
                'client_name'   => $request->client_name,
                'description'   => $request->description,

            ])
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (! $request->user()->tokenCan(User::ABILITY_SPARE_PARTS_PERMITS_UPDATE))
            throw new UnauthorizedException();

        $sparePartsPermit = SparePartsPermit::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'permit_number' => 'string|min:3|max:60',
            'case_number'   => 'string|min:1|max:60',
            'client_name'   => 'string|min:1|max:60',
            'description'   => 'max:255',
        ]);

        if ($validator->fails())
            throw new DataValidationException($validator->errors()->toArray());

        $sparePartsPermit->permit_number = $request->permit_number ?? $sparePartsPermit->permit_number;
        $sparePartsPermit->case_number = $request->case_number ?? $sparePartsPermit->case_number;
        $sparePartsPermit->client_name = $request->client_name ?? $sparePartsPermit->client_name;
        $sparePartsPermit->description = $request->description ?? $sparePartsPermit->description;
        $sparePartsPermit->save();

        return $this->apiSuccessResponse();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if (! $request->user()->tokenCan(User::ABILITY_SPARE_PARTS_PERMITS_DELETE))
            throw new UnauthorizedException();

        SparePartsPermit::where('id', $id)->delete();

        return $this->apiSuccessResponse();
    }
}
