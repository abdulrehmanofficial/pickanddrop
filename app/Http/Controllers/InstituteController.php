<?php

namespace App\Http\Controllers;

use App\DriverData;
use App\Institute;
use App\Rating;
use App\Schedule;
use Illuminate\Http\Request;

class InstituteController extends Controller
{
    public function addInstitute(Request $request)
    {
        $name = $request->name;
        $lat = $request->lat;
        $long = $request->long;
        $driver_id = $request->driver_id;

        $institute = new Institute;
        $institute->name = $name;
        $institute->lat = $lat;
        $institute->long = $long;
        $institute->driver_id = $driver_id;

        $institute->save();

        $response[] = [
            'status' => 'true',
            'message' => 'Institute added successfully!'
        ];

        return response()->json($response);
    }

    public function deleteInstitute(Request $request)
    {
        $institute = Institute::find($request->institute_id);
        $institute->delete();

        $response[] = [
            'status' => 'true',
            'message' => 'Institute deleted successfully!'
        ];

        return response()->json($response);
    }

    public function getInstitutes()
    {
        $institutes = Institute::all();

        $response[] = [
            'status' => 'true',
            'institutes' => $institutes
        ];

        return response()->json($response);
    }

    public function getDriverInstitutes(Request $request)
    {
        $institutes = Institute::where('driver_id',$request->driver_id)->get();

        $response[] = [
            'status' => 'true',
            'institutes' => $institutes
        ];

        return response()->json($response);
    }

    public function searchDrivers(Request $request)
    {
        $institutes = Institute::where('name',$request->name)->get();
        $institute = Institute::where('name',$request->name)->first();

        $drivers = [];

        foreach ($institutes as $institute)
        {
            $drivers[] = [
                'id' =>$institute->driver->id,
                'name' =>$institute->driver->name,
                'email' =>$institute->driver->email,
                'mobile' =>$institute->driver->mobile,
                'address' =>$institute->driver->address,
                'user_image' =>$institute->driver->user_image,
                'user_type' =>$institute->driver->user_type,
                'user_status' =>$institute->driver->user_status,
                'average_rating' => $institute->driver->rating ?
                    $institute->driver->rating->where('driver_id',$institute->driver->id)->avg('rating') : 0
            ];
        }

        $response[] = [
            'status' => 'true',
            'institute_id' => $institute->id,
            'institute_name' => $institute->name,
            'drivers' => $drivers
        ];

        return response()->json($response);
    }

    public function requestDriver(Request $request)
    {
        $driverRequest = new \App\Request;
        $driverRequest->user_id = $request->user_id;
        $driverRequest->institute_id = $request->institute_id;
        $driverRequest->lat = $request->lat;
        $driverRequest->long = $request->long;
        $driverRequest->no_of_seats = $request->no_of_seats;
        $driverRequest->driver_id = $request->driver_id;

        $driverRequest->save();

        $response[] = [
            'status' => 'true',
            'message' => 'Request has been sent to driver for approval'
        ];

        return response()->json($response);
    }

    public function driverRequests(Request $request)
    {
        $driverRequests = \App\Request::where('driver_id',$request->driver_id)->with('user')->with('institute')->get();

        $requests = [];
        foreach ($driverRequests as $driverRequest)
        {
            $requests[] = [
                'request' => $driverRequest
            ];
        }

        $response[] = [
            'status' => 'true',
            'requests' => $requests
        ];

        return response()->json($response);
    }

    public function userRequests(Request $request)
    {
        $userRequests = \App\Request::where('user_id',$request->user_id)
            ->with('driver')->with('institute')->with('schedule')->get();

        $requests = [];
        foreach ($userRequests as $driverRequest)
        {
            $singleRequest = [
                'request' => $driverRequest,
                'average_rating' => $driverRequest->driver->rating ?
                    $driverRequest->driver->rating->where('driver_id',$driverRequest->driver->id)->avg('rating') : 0
            ];

            $requests[] = $singleRequest;
        }

        $response[] = [
            'status' => 'true',
            'requests' => $requests
        ];

        return response()->json($response);
    }

    public function changeRequestStatus(Request $request)
    {
        $userRequest = \App\Request::where('id',$request->request_id)->first();

        $userRequest->status = $request->status;
        $userRequest->save();

        $response[] = [
            'status' => 'true',
            'message' => 'Request status changed successfully'
        ];

        return response()->json($response);
    }

    public function startTrip(Request $request)
    {
        $driverData = DriverData::where('user_id',$request->driver_id)->first();
        $driverData->on_route = true;
        $driverData->save();

        $response[] = [
            'status' => 'true',
            'message' => 'Trip started successfully'
        ];

        return response()->json($response);

    }

    public function endTrip(Request $request)
    {
        $driverData = DriverData::where('user_id',$request->driver_id)->first();
        $driverData->on_route = false;
        $driverData->save();

        $response[] = [
            'status' => 'true',
            'message' => 'Trip ended successfully'
        ];

        return response()->json($response);
    }

    public function startTracking(Request $request)
    {
        $driverData = DriverData::where('user_id',$request->driver_id)->first();

        $response[] = [
            'status' => 'true',
            'driver_data' => $driverData
        ];

        return response()->json($response);
    }

    public function setLiveLocation(Request $request)
    {
        $driverData = DriverData::where('user_id',$request->driver_id)->first();
        $driverData->lat = $request->lat;
        $driverData->long = $request->long;

        $driverData->save();

        $response[] = [
            'status' => 'true',
            'message' => 'Location has been updated'
        ];

        return response()->json($response);
    }

    public function setDriverSchedule(Request $request)
    {
        $schedule = Schedule::where('driver_id',$request->driver_id)->first();
        if(!$schedule)
        {
            $schedule = new Schedule;
            $schedule->driver_id = $request->driver_id;
        }
        $schedule->start_time = $request->start_time;
        $schedule->end_time = $request->end_time;

        $schedule->save();

        $response[] = [
            'status' => 'true',
            'message' => 'Schedule has been updated'
        ];

        return response()->json($response);
    }

    public function getDriverSchedule(Request $request)
    {
        $schedule = Schedule::where('driver_id',$request->driver_id)->first();
        if(!$schedule)
        {
            $response[] = [
                'status' => 'false',
                'message' => 'Driver has not updated his schedule'
            ];

            return response()->json($response);
        }

        $response[] = [
            'status' => 'true',
            'start_time' => $schedule->start_time,
            'end_time' => $schedule->end_time
        ];

        return response()->json($response);
    }

    public function addRating(Request $request)
    {
        $rating = new Rating;
        $rating->user_id = $request->user_id;
        $rating->rating = $request->rating;
        $rating->driver_id = $request->driver_id;

        $rating->save();

        $response[] = [
            'status' => 'true',
            'message' => 'Rating has been added'
        ];

        return response()->json($response);
    }

    public function getRatings(Request $request)
    {
        $ratings = Rating::where('driver_id',$request->driver_id)->ge();
        if($ratings)
        {
            $response[] = [
                'status' => 'true',
                'ratings' => $ratings
            ];

            return response()->json($response);
        }

        $response[] = [
            'status' => 'false',
            'message' => 'No Rating for this driver yet'
        ];

        return response()->json($response);
    }
}
