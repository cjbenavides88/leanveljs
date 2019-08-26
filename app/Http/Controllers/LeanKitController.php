<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Leankit\LeanKitHelper;
use App\Http\Requests\LeanKit\LeanKitBoardsRequest;
use App\Http\Requests\LeanKit\LeanKitLoginRequest;
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
        return $request->board($request['boardID']);
    }

    public function juls(LeanKitBoardsRequest $request){

        $account    = session()->get('account');
        $email      = session()->get('email');
        $password   = session()->get('password');
        $helper = new LeanKitHelper($account, $email, $password);

        $cardsQuery = [
            'board' => 487537051,
            'limit' => 500,
            'lanes' => [
                    883690216, // Sprint
                    583840596, // Under Review
                    845075320, // Blockers
                    622709644, // Ready for Work
                    624091426, // In Progress
                ],
            'only' => 'title,id,color,lane,type'


        ];
        return ($helper->getCards($cardsQuery));
    }
}


//'lanes' => [
//    835189008, // Sprint
//    583840596, // Under Review
//    845075320, // Blockers
//    622709644, // Ready for Work
//    624091426, // In Progress
//]