<?php

namespace App\Http\Requests\Api\User\DeviceActivityController;

use App\Http\Requests\Api\BaseApiRequest;

class GetByDeviceIdRequest extends BaseApiRequest
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
            'deviceId' => 'required|integer'
        ];
    }
}
