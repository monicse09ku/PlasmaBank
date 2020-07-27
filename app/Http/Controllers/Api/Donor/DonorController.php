<?php

namespace App\Http\Controllers\Api\Donor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserInfo;
use App\Models\Report;

class DonorController extends Controller
{
    public function searchDonor(Request $request)
    {


        $validator = \Validator::make($request->all(), [
            'blood_group' => ['required', 'string'],
            'district' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return respondError('Parameters failed validation');
        }

        try {
            // $donors = UserInfo::where([
            //     ['blood_group', '=', $request->blood_group],
            //     ['district', '=', $request->district]
            // ])->get();

            $donors = \DB::table('user_infos')
                ->join('users', 'users.id', '=', 'user_infos.user_id')
                ->where([
                    ['user_infos.blood_group', '=', $request->blood_group],
                    ['user_infos.district', '=', $request->district]
                ])
                ->get();

            if (!empty($donors)) {
                return respond($donors);
            }

            return respondError('No Donor Found');
        } catch (\Exception $e) {
            if (isset($filename)) {
                \UploadBuilder::deleteFile($filename);
            }
            return respondError(FAIL);
        }
    }

    public function ratingDonor(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'user_id' => ['required'],
            'reporter_id' => ['required'],
            'subject' => ['required', 'string'],
            'message' => ['required', 'string'],
            'rating' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return respondError('Parameters failed validation');
        }

        try {
            Report::create([
                'user_id' => $request->user_id,
                'reporter_id' => $request->reporter_id,
                'subject' => $request->subject,
                'message' => $request->message,
                'rating' => $request->rating,
            ]);

            return respondSuccess('Successfully Done.');
        } catch (\Exception $e) {
            return respondError(FAIL);
        }
    }
}
