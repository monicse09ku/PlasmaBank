<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Storage;

class UserInfoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \DB::table('users')
            ->select('users.id', 'username', 'email', 'phone', 'sex', 'age',
                'weight', 'blood_group', 'image', 'district',
                'test_positive_date', 'test_negative_date',
                'test_negative_date_second')
            ->leftJoin('user_infos', 'users.id', '=', 'user_infos.user_id')
            ->where('users.id', auth()->user()->id)
            ->get();

        return view('profile')->with('userInfos', $user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $this->validate($request,
            [
                'username' => ['required', 'string'],
                'email' => ['required', 'email'],
                'phone' => ['required', 'string'],
                'sex' => ['required', 'string'],
                'image' => ['mimes:jpeg,bmp,png', 'max:1999'],
                'age' => ['required', 'integer'],
                'weight' => ['required', 'integer'],
                'blood_group' => ['required', 'string'],
                'district' => ['required', 'string'],
                'test_positive_date' => 'required|date',
                'test_negative_date' => 'required|date',
                'test_negative_date_second' => 'required|date',
        ]);

        $user           = User::find($id);
        $user->username = $request->input('username');
        $user->email    = $request->input('email');
        $user->phone    = $request->input('phone');
        $user->sex      = $request->input('sex');

        if ($user->isDirty()) {
            try {
                $user->update();
            } catch (\Exception $e) {
                return redirect(route('profile.index'))->with('error', 'User basic info not updated.');
            }
        }

        $user_info = UserInfo::firstWhere('user_id', $id);

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
                    $image = $this->uploadImageLocal($request->file('image'),$previousImage);
                    
                    $user_info->image = $image;
                }

                if ($user_info->isDirty()) {
                    $user_info->update();
                    return redirect(route('profile.index'))->with('success', 'User info updated.');
                }else{
                    return redirect(route('profile.index'));
                }
            } catch (\Exception $e) {
                return redirect(route('profile.index'))->with('error', 'User info not updated.');
            }
        } else {

            try {
                $image = '';
                if ($request->hasFile('image')) {
                     $image = $this->uploadImageLocal($request->file('image'));
                }
                $userInfo                             = new UserInfo();
                $userInfo->user_id                    = $id;
                $userInfo->weight                    = $request->input('weight');
                $userInfo->age                       = $request->input('age');
                $userInfo->blood_group               = $request->input('blood_group');
                $userInfo->district                  = $request->input('district');
                $userInfo->test_positive_date        = $request->input('test_positive_date');
                $userInfo->test_negative_date        = $request->input('test_negative_date');
                $userInfo->test_negative_date_second = $request->input('test_negative_date_second');
                $userInfo->image = $image;

                $userInfo->save();
                return redirect(route('profile.index'))->with('success', 'User Info Created.');
            } catch (\Exception $e) {
                return redirect(route('profile.index'))->with('error', 'User info table can not save.');
            }
        }
    }

    /**
     * Upload image
     * in public directory
     * @param file $imageFile image type file
     */
    public function uploadImageLocal($imageFile,$previousImage='noImage')
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}