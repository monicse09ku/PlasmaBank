<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\UserInfo;
use App\Http\Resources\UserResource;

class AccountSettingController extends Controller
{
    /**
     * get logged in user profile
     *
     * @param Request $request
     * @return Response
     */
    public function me(Request $request)
    {
        return new UserResource($request->user());
    }

    /**
     * Update user profile information
     * @param Request $request
     *
     * @return Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        try {
            $data = $request->only('name', 'phone', 'address');

            if ($request->hasFile('avatar')) {
                $filename = \UploadBuilder::uploadFile($request->file('avatar'), 'avatars')->fit(200, 200);
                $data['avatar'] = $filename;
            }

            $user = User::findOrFail(auth()->id());
            $oldAvatar = $user->avatar;

            if ($user->update($data)) {
                if (isset($filename) && $oldAvatar != null) {
                    \UploadBuilder::deleteFile($oldAvatar);
                }

                return respondSuccess(UPDATE_SUCCESS);
            }
        } catch (\Exception $e) {
            if (isset($filename)) {
                \UploadBuilder::deleteFile($filename);
            }
            return respondError(UPDATE_FAIL);
        }
    }

    /**
     * Reset user password
     * @param Request $request
     *
     * @return Response
     */
    public function resetPassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:6',
        ]);

        try {
            if (\Hash::check($request->current_password, $request->user()->password)) {
                $request->user()->update([
                    'password' => bcrypt($request->new_password)
                ]);

                return respondSuccess('Your password has been changed.');
            }

            return respondError('Old password could\'t match.');
        } catch (\Exception $e) {
            return respondError('Failed to reset your password!');
        }
    }

    /**
     * User Upload avatar
     *
     * @param Request $request
     * @return mixed
     */
    public function uploadAvatar(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'user_id' => ['required'],
            'image' => ['required'],
        ]);

        if ($validator->fails()) {
            return respondError('Parameters failed validation');
        }

        $user_info = UserInfo::where('user_id', $request->user_id)->first();

        if(!empty($user_info)){
            
            try{

                if(!empty($user_info->image)){
                    if(file_exists(public_path() . '/images/donors/' . $user_info->image)){
                        unlink(public_path() . '/images/donors/' . $user_info->image);
                    }
                }

                if(!empty($request->image)){
                    $file = base64_decode($request->image);
                    $safeName = strtotime(date('Y-m-d H:i:s')).'.'.'png';
                    $success = file_put_contents(public_path().'/images/donors/'.$safeName, $file);

                    UserInfo::where('user_id', $user_info->user_id)->update([
                        'image' => $safeName
                    ]);

                    return respondSuccess('Image Uploaded Successfully.');
                }

                return respondError('Could not Upload Image!');
            }catch(\Exception $e){
                return respondError('Could not Upload Image!');
            }
        }else{
            return respondError('User Not Found...');
        }
    }
}
