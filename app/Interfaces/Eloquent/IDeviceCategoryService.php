<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

interface IDeviceCategoryService extends IEloquentService
{
    /**
     * @param string $name
     * @param string $icon
     *
     * @return \App\Core\ServiceResponse
     */
    public function create(
        string $name,
        string $icon
    ): ServiceResponse;

    /**
     * @param int $id
     * @param string $name
     * @param string $icon
     *
     * @return \App\Core\ServiceResponse
     */
    public function update(
        int    $id,
        string $name,
        string $icon
    ): ServiceResponse;
}
