<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Leankit\LeanKitHelper;
use App\Http\Requests\LeanKit\LeanKitBoardsRequest;
use App\Http\Requests\LeanKit\LeanKitLoginRequest;
use App\Http\Requests\LeanKit\LeanKitRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LeanKitController extends Controller
{
    public function login(LeanKitLoginRequest $request){
        return $request->login();
    }

    public function boards(LeanKitBoardsRequest $request){
        return $request->boards();
    }

    public function board(LeanKitBoardsRequest $request){

        $key = 'board_' . $request['boardID'];

        if(Cache::has($key)){
            return Cache::get($key);
        }else{
            $value = $request->board($request['boardID']);
            Cache::put($key, $value, now()->addDays(7)); // Set days for testing.
            return $value;
        }
    }
}
