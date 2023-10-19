<?php

namespace App\Http\Requests\Api\User\EmployeeController;

use App\Http\Requests\Api\BaseApiRequest;

class ReActivateByOtsIdRequest extends BaseApiRequest
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
            'otsId' => 'required|integer',
        ];
    }
}