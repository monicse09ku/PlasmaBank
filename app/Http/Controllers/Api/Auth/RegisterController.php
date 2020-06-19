<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use App\User;
use App\Models\UserInfo;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except(['createUser']);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createUser(Request $request)
    {

        $validator = \Validator::make($request->all(), [
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
            'phone' => ['required', 'string', 'max:255', 'unique:users'],
            'sex' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            $failedRules = $validator->failed();

            if(isset($failedRules['email']['Unique'])) {
                return respondError('Email Already Taken');
            }

            if(isset($failedRules['phone']['Unique'])) {
                return respondError('Phone Number Already Taken');
            }

            return respondError('Parameters failed validation');
        }

        try {
            event(new Registered($user = $this->create($request->all())));
            
            if ($user) {
                return $this->createAccessToken($user);
            }

            return respondError(FAIL);
        } catch (\Exception $e) {
            return respondError($e->getMessage());
            return respondError('Failed to register!');
        }
    }

    public function completeRegistration(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'user_id' => ['required', 'integer'],
            'age' => ['required', 'integer'],
            'weight' => ['required', 'integer'],
            'blood_group' => ['required', 'string'],
            'lat' => ['required', 'string'],
            'long' => ['required', 'string'],
            'device_id' => ['required', 'string'],
            'test_positive_date' => 'required',
        ]);

        if ($validator->fails()) {
            $failedRules = $validator->failed();

            return respondError('Parameters failed validation');
        }

        if(!empty($request->test_negative_date)){
            if($request->test_positive_date > $request->test_negative_date){
                return respondError('Wrong Test Negative Date');
            }

            if(!empty($request->test_negative_date_second) && ($request->test_negative_date > $request->test_negative_date_second)){
                return respondError('Wrong Test Negative Date Second Date');
            }
        }

        try {
            $user = User::where('id', $request->user_id)->first();

            if(!empty($request->image)){
                $file = base64_decode($request->image);
                $folderName = 'public/images/donors/';
                $safeName = strtotime(date('Y-m-d H:i:s')).'.'.'png';
                $destinationPath = public_path() . $folderName;
                $success = file_put_contents(public_path().'/images/donors/'.$safeName, $file);
            }

            if(!empty($user)){
                UserInfo::create([
                    'user_id' => $request->user_id,
                    'age' => $request->age,
                    'weight' => $request->weight,
                    'image' => !empty($safeName) ? $safeName : '',
                    'blood_group' => $request->blood_group,
                    'lat' => $request->lat,
                    'long' => $request->long,
                    'device_id' => $request->device_id,
                    'test_positive_date' => $request->test_positive_date,
                    'test_negative_date' => $request->test_negative_date,
                    'test_negative_date_second' => $request->test_negative_date_second,

                ]);

                return respondSuccess('User Registered Successfully');
            }else{
                return respondError('User not found!!!');
            }

        } catch (\Exception $e) {
            return respondError($e->getMessage());
            return respondError('Failed to register!');
        }

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'role' => 'donor',
            'sex' => $data['sex'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Create auth user access token
     * @param  Object $user
     * @return Token
     */
    protected function createAccessToken($user)
    {
        if ($token = $user->createToken('PlasmaBank Personal Access Client')->accessToken) {
            return (new UserResource($user))->additional([
                'token' => $token,
            ]);
        }

        throw new \Exception('Failed to create generate token!');
    }

    protected function isDonor($request)
    {
        # code...
    }
}
