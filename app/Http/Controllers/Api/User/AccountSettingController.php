<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\UserInfo;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Storage;

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
        $update = false;
        $validate = \Validator::make($request->all(), [
            'user_id' => ['required', 'integer'],
            'username' => ['required', 'string'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'string'],
            'sex' => ['required', 'string'],
            'image' => ['nullable', 'mimes:jpeg,bmp,png', 'max:1999'],
            'age' => ['required', 'integer'],
            'weight' => ['required', 'integer'],
            'blood_group' => ['required', 'string'],
            'district' => ['required', 'string'],
            'test_positive_date' => 'required|date',
            'test_negative_date' => 'required|date',
            'test_negative_date_second' => 'date',
        ]);
        if ($validate->fails()) {
            $messages = $validate->messages();
            return respondError($messages);
        }
        $user_id  = $request->input('user_id');

        try {
            $user           = User::find($user_id);
            $user->username = $request->input('username');
            $user->email    = $request->input('email');
            $user->phone    = $request->input('phone');
            $user->sex      = $request->input('sex');
            if ($user->isDirty()) {
                try {
                    $user->update();
                    $update = true;
                } catch (\Exception $e) {
                    return respondError($e->getMessage());
                }
            }

            $user_info = UserInfo::firstWhere('user_id', $user_id);
            if (!empty($user_info)) {
                $user_info->weight                    = $request->input('weight');
                $user_info->age                       = $request->input('age');
                $user_info->blood_group               = $request->input('blood_group');
                $user_info->district                  = $request->input('district');
                $user_info->test_positive_date        = $request->input('test_positive_date');
                $user_info->test_negative_date        = $request->input('test_negative_date');
                $user_info->test_negative_date_second = $request->input('test_negative_date_second');


                try {
                    if ($request->hasFile('image')) {
                        $previousImage = !empty($user_info->image) ? $user_info->image : '';
                        $image = $this->uploadImageLocal($request->file('image'), $previousImage);

                        $user_info->image = $image;
                    }

                    if ($user_info->isDirty()) {
                        $user_info->update();
                        return (new UserResource($user_info))->additional([
                            'user' => User::where('id', $user_info->user_id)->first()
                        ]);
                    } elseif ($update) {
                        return (new UserResource($user_info))->additional([
                            'user' => User::where('id', $user_info->user_id)->first()
                        ]);
                    } else {
                        return true;
                    }
                } catch (\Exception $e) {
                    return respondError($e->getMessage());
                }
            } else {
                try {
                    $image = '';
                    if ($request->hasFile('image')) {
                        $image = $this->uploadImageLocal($request->file('image'));
                    }
                    $userInfo                             = new UserInfo();
                    $userInfo->user_id                    = $user_id;
                    $userInfo->weight                    = $request->input('weight');
                    $userInfo->age                       = $request->input('age');
                    $userInfo->blood_group               = $request->input('blood_group');
                    $userInfo->district                  = $request->input('district');
                    $userInfo->test_positive_date        = $request->input('test_positive_date');
                    $userInfo->test_negative_date        = $request->input('test_negative_date');
                    $userInfo->test_negative_date_second = $request->input('test_negative_date_second');
                    $userInfo->image = $image;

                    $userInfo->save();
                    return (new UserResource($userInfo))->additional([
                        'user' => User::where('id', $userInfo->user_id)->first()
                    ]);
                } catch (\Exception $e) {
                    return respondError($e->getMessage());
                }
            }
        } catch (\Exception $e) {
            return respondError($e->getMessage());
        }
    }

    /**
     * Upload image
     * in public directory
     * @param file $imageFile image type file
     */
    public function uploadImageLocal($imageFile, $previousImage = 'noImage')
    {

        // get file name with extension
        $fileNameWithExtension = $imageFile->getClientOriginalName();

        // get the file name
        $fileName = pathinfo($fileNameWithExtension, PATHINFO_FILENAME);

        // get just extension
        $fileExtension = $imageFile->getClientOriginalExtension();

        // file name to store
        $fileNameToStore = $fileName . '_' . time() . '.' . $fileExtension;

        // local file upload
        $path = $imageFile->storeAs('public/images', $fileNameToStore);

        if ($previousImage != 'noImage') {
            Storage::delete('public/images/' . $previousImage);
        }

        return $fileNameToStore;
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

        if (!empty($user_info)) {

            try {

                if (!empty($user_info->image)) {
                    if (file_exists(public_path() . '/images/donors/' . $user_info->image)) {
                        unlink(public_path() . '/images/donors/' . $user_info->image);
                    }
                }

                if (!empty($request->image)) {
                    $file = base64_decode($request->image);
                    $safeName = strtotime(date('Y-m-d H:i:s')) . '.' . 'png';
                    $success = file_put_contents(public_path() . '/images/donors/' . $safeName, $file);

                    UserInfo::where('user_id', $user_info->user_id)->update([
                        'image' => $safeName
                    ]);

                    return respondSuccess('Image Uploaded Successfully.');
                }

                return respondError('Could not Upload Image!');
            } catch (\Exception $e) {
                return respondError('Could not Upload Image!');
            }
        } else {
            return respondError('User Not Found...');
        }
    }
}
