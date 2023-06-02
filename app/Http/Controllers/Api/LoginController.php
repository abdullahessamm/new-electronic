<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Validation\DataValidationException;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    
    /**
     * login controller
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:50',
            'password' => 'required|string|max:255'
        ]);

        if ($validator->fails())
            throw new DataValidationException($validator->errors()->all());

        $user = User::where('username', $request->username)->first();
        if (! $user)
            return response()->json([
                'success' => false,
                'errors'  => [
                    'username' => true,
                    'password' => false
                ],
            ], Response::HTTP_UNAUTHORIZED);

        if (! Hash::check($request->password, $user->password))
            return response()->json([
                'success' => false,
                'errors'  => [
                    'username' => false,
                    'password' => true
                ],
            ], Response::HTTP_UNAUTHORIZED);

        return $this->apiSuccessResponse([
            'token' => $user->createToken($request->userAgent(), $user->getAbilities())->plainTextToken,
            'user'  => $user
        ]);
    }

    public function logout(Request $request)
    {
        auth('sanctum')->user()->currentAccessToken()->delete();
        return $this->apiSuccessResponse();
    }
}
