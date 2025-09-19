<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Authorization\UnauthorizedException;
use App\Exceptions\Models\NotFoundException;
use App\Exceptions\Validation\DataValidationException;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->user()->tokenCan(User::ABILITY_USERS_INDEX))
            return $this->apiSuccessResponse([
                'users' => User::all()
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
        if (! $request->user()->tokenCan(User::ABILITY_USERS_CREATE))
            throw new UnauthorizedException();

        $validator = Validator::make($request->all(), [
            'f_name'    => 'required|regex:/^[a-zA-Z\x{0621}-\x{064A}]{2,20}$/u',
            'l_name'    => 'required|regex:/^[a-zA-Z\x{0621}-\x{064A}]{2,20}$/u',
            'email'     => 'required|email|max:50|unique:users,email',
            'username'  => 'required|regex:/^[a-zA-Z0-9\.]+$/|min:3|max:50|unique:users,username',
            'password'  => 'required|string|min:8|max:100',
            'abilities' => [
                'required',
                'array',
                'min:1',
                'max:' . count(User::ABILITIES),
                Rule::in(User::ABILITIES)
            ],
        ]);

        if ($validator->fails())
            throw new DataValidationException($validator->errors()->toArray());

        $userData = $request->only(['f_name', 'l_name', 'email', 'username']);
        $userData['password']  = Hash::make($request->password);
        $userData['abilities'] = implode(',', $request->abilities);

        return $this->apiSuccessResponse([
            'user' => User::create($userData)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if ($request->user()->tokenCan(User::ABILITY_USERS_INDEX))
            return $this->apiSuccessResponse([
                'users' => User::find($id)
            ]);

        throw new UnauthorizedException();
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
        if (! $request->user()->tokenCan(User::ABILITY_USERS_UPDATE))
            throw new UnauthorizedException();

        if (count($request->all()) == 0)
            return $this->apiSuccessResponse();

        if (! $user = User::find($id))
            throw new NotFoundException(User::class, $id);

        $validator = Validator::make($request->all(), [
            'f_name'    => 'regex:/^[a-zA-Z\x{0621}-\x{064A}]{2,20}$/u',
            'l_name'    => 'regex:/^[a-zA-Z\x{0621}-\x{064A}]{2,20}$/u',
            'email'     => 'email|max:50|unique:users,email',
            'username'  => ['regex:/^[a-zA-Z0-9\.]{3,50}$/' , 'unique:users,username'],
            'password'  => 'string|min:8|max:100',
            'abilities' => [
                'array',
                'min:1',
                'max:' . count(User::ABILITIES),
                Rule::in(User::ABILITIES)
            ],
        ]);

        if ($validator->fails())
            throw new DataValidationException($validator->errors()->toArray());

        $user->f_name = $request->f_name ?? $user->f_name;
        $user->l_name = $request->l_name ?? $user->l_name;
        $user->email = $request->email ?? $user->email;
        $user->username = $request->username ?? $user->username;
        $user->password = $request->password ? Hash::make($request->password) : $user->password;
        $request->has('abilities') && $request->user()->id !== $user->id ? $user->setAbilities($request->abilities) : null;
        $user->save();

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
        if (! $request->user()->tokenCan(User::ABILITY_USERS_DELETE) || $request->user()->id == $id)
            throw new UnauthorizedException();

        User::where('id', $id)->where('abilities', '!=', '*')->delete();
        return $this->apiSuccessResponse();
    }
}
