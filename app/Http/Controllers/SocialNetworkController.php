<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SocialNetworkController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function getUserData(Request $request)
    {
        $instance = $this->driverInstance($request->driver);
        if($request->has('code')) {
            $profile = $instance->getUserProfile($request->code);
        } else {
            $profile = $instance->getUserProfile();
        }
        return response()->json((array)$profile);
    }

    /**
     * @param $driver
     * @return mixed
     */
    protected function driverInstance($driver) {
        return app()->make($driver);
    }
}
