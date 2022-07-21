<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{
    public function subscribe(Job $job){

       $job->users()->attach(auth('sanctum')->user());

       
       return response()
            ->json([], 200);
    }

    public function unsubscribe(Job $job){
        $user = auth('sanctum')->user();
        $user->jobs()->detach($job->id);

       
       return response()
            ->json([], 200);
    }
}
