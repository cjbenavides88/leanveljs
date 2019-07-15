<?php

namespace App\Http\Requests\LeanKit;

use App\Http\Controllers\LeanKitController;
use App\Http\Helpers\Leankit\LeanKitHelper;
use Illuminate\Foundation\Http\FormRequest;

class LeanKitLoginRequest extends FormRequest
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
            'account'   => 'required',
            'email'     => 'required',
            'password'  => 'required',
        ];
    }

    public function login()
    {
        $account    = $this->request->get('account');
        $email      = $this->request->get('email');
        $password   = $this->request->get('password');

        $helper = new LeanKitHelper($account, $email, $password);
        return $helper->getCurrentUser();
    }
}
