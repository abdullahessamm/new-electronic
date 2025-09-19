<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Authorization\UnauthorizedException;
use App\Exceptions\Validation\DataValidationException;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileSettingsController extends Controller
{

    protected function passwordUpdater(User $user, string $oldPassword, string $newPassword)
    {
        if (! Hash::check($oldPassword, $user->password))
            throw new UnauthorizedException();

        $user->password = Hash::make($newPassword);
    }
    
    protected function updateForAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'f_name'        => 'regex:/^[a-zA-Z\x{0621}-\x{064A}]{2,20}$/u',
            'l_name'        => 'regex:/^[a-zA-Z\x{0621}-\x{064A}]{2,20}$/u',
            'email'         => 'email|max:50|unique:users,email',
            'username'      => ['regex:/^[a-zA-Z0-9\.]{3,50}$/' , 'unique:users,username'],
            'password'      => 'string|min:8|max:100',
            'old_password'  => 'required_with:password|max:100',
        ]);

        if ($validator->fails())
            throw new DataValidationException($validator->errors()->toArray());

        $user = $request->user();
        $user->f_name = $request->f_name ?? $user->f_name;
        $user->l_name = $request->l_name ?? $user->l_name;
        $user->email = $request->email ?? $user->email;
        $user->username = $request->username ?? $user->username;

        if ($request->has('password'))
            $this->passwordUpdater($user, $request->old_password, $request->password);

        $user->save();
        return $this->apiSuccessResponse();
    }

    protected function updateForUsers(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username'      => ['regex:/^[a-zA-Z0-9\.]{3,50}$/' , 'unique:users,username'],
            'email'         => 'email|max:50|unique:users,email',
            'password'      => 'string|min:8|max:100',
            'old_password'  => 'required_with:password|max:100',
        ]);

        if ($validator->fails())
            throw new DataValidationException($validator->errors()->toArray());

        $user = $request->user();
        $user->username = $request->username ?? $user->username;
        $user->email = $request->email ?? $user->email;
        if ($request->has('password'))
            $this->passwordUpdater($user, $request->old_password, $request->password);

        $user->save();
        return $this->apiSuccessResponse();
    }

    public function update(Request $request)
    {
        return $request->user()->abilities === '*' ? $this->updateForAdmin($request) : $this->updateForUsers($request);
    }
}
