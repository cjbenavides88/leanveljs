<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Leankit\LeanKitHelper;
use App\Http\Requests\LeanKit\LeanKitBoardsRequest;
use App\Http\Requests\LeanKit\LeanKitLoginRequest;
use App\Http\Requests\LeanKit\LeanKitRequest;
use Illuminate\Http\Request;

class LeanKitController extends Controller
{
    public function login(LeanKitLoginRequest $request){
        return $request->login();
    }

    public function boards(LeanKitBoardsRequest $request){
        return $request->boards();
    }

    public function board(LeanKitBoardsRequest $request){
       return $request->board($request['boardID']);
    }
}
