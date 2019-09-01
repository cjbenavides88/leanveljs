<?php

namespace App\Http\Requests\LeanKit;

use App\Http\Helpers\Leankit\LeanKitHelper;
use Illuminate\Foundation\Http\FormRequest;

class LeanKitBoardsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    public function boards()
    {
        $account    = session()->get('account');
        $email      = session()->get('email');
        $password   = session()->get('password');

        $helper = new LeanKitHelper($account, $email, $password);
        $response = $helper->getBoards();

        return $response;
    }

    public function board($boardID)
    {

        $account    = session()->get('account');
        $email      = session()->get('email');
        $password   = session()->get('password');

        $helper = new LeanKitHelper($account, $email, $password);
        $response['board'] = json_decode($helper->getBoard($boardID)->getBody()->getContents());
        $cardsQuery = [
            'board' => $boardID,
            'limit' => 500,
            'lanes' => [
                835189009, // Sprint 18
                583840596, // Under Review
                845075320, // Blockers
                622709644, // Ready for Work
                624091426, // In Progress
            ],
        ];
        $response['cards'] = json_decode($helper->getCards($cardsQuery)->getBody()->getContents());
        return $response;
    }


}
