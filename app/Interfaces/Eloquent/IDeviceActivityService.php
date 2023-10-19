<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

interface IDeviceActivityService extends IEloquentService
{
    /**
     * @param int $deviceId
     *
     * @return \App\Core\ServiceResponse
     */
    public function getByDeviceId(
        int $deviceId
    ): ServiceResponse;
}
