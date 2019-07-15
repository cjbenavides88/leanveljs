<?php

namespace App\Http\Requests\LeanKit;

use App\Http\Helpers\Leankit\LeanKitHelper;
use Illuminate\Foundation\Http\FormRequest;

class LeanKitRequest extends FormRequest
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
}
