<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

interface IDeviceStatusService extends IEloquentService
{
    /**
     * @param string $name
     * @param string $color
     *
     * @return \App\Core\ServiceResponse
     */
    public function create(
        string $name,
        string $color
    ): ServiceResponse;

    /**
     * @param int $id
     * @param string $name
     * @param string $color
     *
     * @return ServiceResponse
     */
    public function update(
        int    $id,
        string $name,
        string $color
    ): ServiceResponse;
}
