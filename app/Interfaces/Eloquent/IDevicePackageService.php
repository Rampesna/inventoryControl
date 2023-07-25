<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

interface IDevicePackageService extends IEloquentService
{
    /**
     * @param int $pageIndex
     * @param int $pageSize
     * @param string|null $keyword
     *
     * @return ServiceResponse
     */
    public function index(
        int    $pageIndex,
        int    $pageSize,
        string $keyword = null
    ): ServiceResponse;

    /**
     * @param int $id
     *
     * @return ServiceResponse
     */
    public function getDevices(
        int $id
    ): ServiceResponse;

    /**
     * @param int $devicePackageId
     * @param array $deviceIds
     *
     * @return ServiceResponse
     */
    public function setDevices(
        int   $devicePackageId,
        array $deviceIds
    ): ServiceResponse;

    /**
     * @param int $userId
     * @param int $devicePackageId
     * @param int $employeeId
     *
     * @return ServiceResponse
     */
    public function updateEmployee(
        int $userId,
        int $devicePackageId,
        int $employeeId
    ): ServiceResponse;

    /**
     * @param string $name
     *
     * @return ServiceResponse
     */
    public function create(
        string $name
    ): ServiceResponse;

    /**
     * @param int $id
     * @param string $name
     *
     * @return ServiceResponse
     */
    public function update(
        int    $id,
        string $name
    ): ServiceResponse;
}
