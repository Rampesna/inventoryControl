<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

interface IDeviceService extends IEloquentService
{
    /**
     * @param int $pageIndex
     * @param int $pageSize
     * @param string $keyword
     * @param array|null $categoryIds
     * @param array|null $statusIds
     *
     * @return \App\Core\ServiceResponse
     */
    public function index(
        int    $pageIndex = 0,
        int    $pageSize = 10,
        string $keyword = null,
        array  $categoryIds = null,
        array  $statusIds = null
    ): ServiceResponse;

    /**
     * @param int $employeeId
     * @param int $pageIndex
     * @param int $pageSize
     * @param string $keyword
     * @param array|null $categoryIds
     * @param array|null $statusIds
     *
     * @return \App\Core\ServiceResponse
     */
    public function paginateByEmployeeId(
        int    $employeeId,
        int    $pageIndex = 0,
        int    $pageSize = 10,
        string $keyword = null,
        array  $categoryIds = null,
        array  $statusIds = null
    ): ServiceResponse;

    /**
     * @param array $ids
     *
     * @return \App\Core\ServiceResponse
     */
    public function getByIds(
        array $ids
    ): ServiceResponse;

    /**
     * @param int $packageId
     *
     * @return \App\Core\ServiceResponse
     */
    public function getByPackageId(
        int $packageId
    ): ServiceResponse;

    /**
     * @param int $employeeId
     *
     * @return \App\Core\ServiceResponse
     */
    public function getByEmployeeId(
        int $employeeId
    ): ServiceResponse;

    /**
     * @param array $ids
     * @param int|null $packageId
     *
     * @return \App\Core\ServiceResponse
     */
    public function updatePackageIdByIds(
        array    $ids,
        int|null $packageId = null
    ): ServiceResponse;

    /**
     * @param array $ids
     * @param int|null $employeeId
     *
     * @return \App\Core\ServiceResponse
     */
    public function updateEmployeeIdByIds(
        array    $ids,
        int|null $employeeId = null
    ): ServiceResponse;

    /**
     * @param int $categoryId
     * @param int $statusId
     * @param int|null $employeeId
     * @param string|null $name
     * @param string|null $brand
     * @param string|null $model
     * @param string|null $serialNumber
     * @param string|null $ipAddress
     *
     * @return \App\Core\ServiceResponse
     */
    public function create(
        int    $categoryId,
        int    $statusId,
        int    $employeeId = null,
        string $name = null,
        string $brand = null,
        string $model = null,
        string $serialNumber = null,
        string $ipAddress = null
    ): ServiceResponse;

    /**
     * @param int $userId
     * @param int $id
     * @param int $categoryId
     * @param int $statusId
     * @param int|null $employeeId
     * @param string|null $name
     * @param string|null $brand
     * @param string|null $model
     * @param string|null $serialNumber
     * @param string|null $ipAddress
     *
     * @return ServiceResponse
     */
    public function update(
        int    $userId,
        int    $id,
        int    $categoryId,
        int    $statusId,
        int    $employeeId = null,
        string $name = null,
        string $brand = null,
        string $model = null,
        string $serialNumber = null,
        string $ipAddress = null
    ): ServiceResponse;
}
