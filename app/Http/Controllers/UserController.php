<?php

namespace App\Http\Controllers;

use App\DriverData;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function registerApiUser(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'address' => 'required',
            'password' => 'required',
            'user_image' => 'required',
            'cnic_front' => 'required',
            'cnic_back' => 'required',
            'user_type' => 'required',
        ]);

        if ($validator->fails()) {
            $response = array('response' => '', 'success'=>false);
            $response['response'] = $validator->messages();
            return $response;
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->address = $request->address;
        $user->password = Hash::make($request->password);

        // User Image
        $user_image = $request->user_image;
        $db_user_image = time()."_".str_replace(' ','',$request->name)."_user_image.jpg";
        $path = public_path()."/uploads/$db_user_image";
        File::put($path, base64_decode($user_image));
        $user->user_image = $db_user_image;

        // Cnic Front Image
        $cnic_front = $request->cnic_front;
        $db_cnic_front = time()."_".str_replace(' ','',$request->name)."_cnic_front.jpg";
        $path = public_path()."/uploads/$db_cnic_front";
        File::put($path, base64_decode($cnic_front));
        $user->cnic_front = $db_cnic_front;

        // Cnic back Image
        $cnic_back = $request->cnic_back;
        $db_cnic_back = time()."_".str_replace(' ','',$request->name)."_cnic_back.jpg";
        $path = public_path()."/uploads/$db_cnic_back";
        File::put($path, base64_decode($cnic_back));
        $user->cnic_back = $db_cnic_back;

        $user->user_type = $request->user_type;
        $user_status = 1;
        if($request->user_type == 3)
        {
            $user_status = 0;
        }

        $user->user_status = $user_status;
        $user->save();

        $response[] = [
            'status' => 'true',
            'message' => 'User Registered Successfully'
        ];

        return response()->json($response);
    }

    public function isUserExist(Request $request){
        $mobile = $request->mobile;

        $user = User::where('mobile',$mobile)->count();
        if($user)
        {
            $response[] = [
                'status' => 'true',
                'message' => 'User already exists'
            ];

            return response()->json($response);
        }

        $response[] = [
            'status' => 'false',
            'message' => 'User do not exists'
        ];

        return response()->json($response);
    }

    public function loginUser(Request $request){
        $mobile = $request->mobile;
        $password = $request->password;

        $user = User::where(['mobile' => $mobile])->first();

        if(Hash::check($password ,$user->password))
        {
            $response[] = [
                'status' => 'true',
                'user' => $user
            ];

            return response()->json($response);
        }

        $response[] = [
            'status' => 'false',
            'message' => 'Username or password does not match'
        ];

        return response()->json($response);
    }

    public function updateProfile(Request $request)
    {
        $user = User::find($request->user_id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->address = $request->address;

        if(filter_var($request->user_image, FILTER_VALIDATE_URL) === true)
        {
            $user->user_image = $request->user_image;
        }
        else{
            // user Image
            $db_user_image = time()."_".str_replace(' ','',$request->name)."_licence_image.jpg";
            $path = public_path()."/uploads/$db_user_image";
            File::put($path, base64_decode($request->user_image));
            $user->user_image = $db_user_image;
        }

        $user->save();

        $response[] = [
            'status' => 'true',
            'message' => 'Profile updated successfully'
        ];

        return response()->json($response);
    }

    public function submitDriverDocuments(Request $request)
    {
        $vehicle_type = $request->vehicle_type;
        $vehicle_num = $request->vehicle_num;
        $licence_image = $request->licence_image;
        $certificate_image = $request->certificate_image;
        $user_id = $request->user_id;

        $driver_data = new DriverData;
        $driver_data->vehicle_type = $vehicle_type;
        $driver_data->vehicle_num = $vehicle_num;
        $driver_data->user_id = $user_id;

        // Licence Image
        $db_licence_image = time()."_".str_replace(' ','',$request->name)."_licence_image.jpg";
        $path = public_path()."/uploads/$db_licence_image";
        File::put($path, base64_decode($licence_image));
        $driver_data->licence_image = $db_licence_image;

        // Certificate Image
        $db_certificate_image = time()."_".str_replace(' ','',$request->name)."_certificate_image.jpg";
        $path = public_path()."/uploads/$db_certificate_image";
        File::put($path, base64_decode($certificate_image));
        $driver_data->certificate_image = $db_certificate_image;

        $driver_data->save();

        $user = User::find($user_id);
        $user->user_status = 2;
        $user->save();

        $response[] = [
            'status' => 'true',
            'message' => 'Documents submitted to admin for approval'
        ];

        return response()->json($response);
    }

    public function getDriverData(Request $request)
    {
        $user_id = $request->user_id;
        $driver_data = DriverData::where('user_id',$user_id)->first();

        if($driver_data)
        {
            $response[] = [
                'status' => 'true',
                'driver_data' => $driver_data
            ];

            return response()->json($response);
        }

        $response[] = [
            'status' => 'false',
            'message' => 'No documents submitted by the user yet!'
        ];

        return response()->json($response);
    }

    public function forgetPassword(Request $request){
        $mobile = $request->mobile;
        $password = $request->password;

        $user = User::where(['mobile' => $mobile])->first();
        $user->password = Hash::make($password);

        $user->save();

        $response[] = [
            'status' => 'true',
            'message' => 'Password has been updated'
        ];

        return response()->json($response);
    }

    public function changePassword(Request $request){
        $mobile = $request->name;
        $password = $request->password;
        $new_password = $request->new_password;

        $user = User::where('mobile',$mobile)->first();

        if(Hash::check($password ,$user->password))
        {
            $user->password = Hash::make($new_password);
            $user->save();

            $response[] = [
                'status' => 'true',
                'message' => 'Password updated successfully'
            ];

            return response()->json($response);
        }

        $response[] = [
            'status' => 'false',
            'message' => 'Invalid Password'
        ];

        return response()->json($response);
    }

}
