<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

interface IEmployeeService extends IEloquentService
{
    /**
     * @return \App\Core\ServiceResponse
     */
    public function getAllWithDevices(): ServiceResponse;

    /**
     * @param int $id
     *
     * @return \App\Core\ServiceResponse
     */
    public function getByIdWithDevices(
        int $id
    ): ServiceResponse;

    /**
     * @param int $otsId
     * @param string $name
     * @param string $email
     * @param string|null $password
     *
     * @return \App\Core\ServiceResponse
     */
    public function create(
        int     $otsId,
        string  $name,
        string  $email,
        ?string $password
    ): ServiceResponse;

    /**
     * @param int $userId
     * @param int $employeeId
     * @param array $deviceIds
     *
     * @return \App\Core\ServiceResponse
     */
    public function setDevices(
        int   $userId,
        int   $employeeId,
        array $deviceIds
    ): ServiceResponse;

    /**
     * @param int $userId
     * @param int $employeeId
     * @param array $deviceIds
     *
     * @return \App\Core\ServiceResponse
     */
    public function removeDevices(
        int   $userId,
        int   $employeeId,
        array $deviceIds
    ): ServiceResponse;

    /**
     * @param int $otsId
     *
     * @return \App\Core\ServiceResponse
     */
    public function deleteByOtsId(
        int $otsId
    ): ServiceResponse;

    /**
     * @param int $otsId
     *
     * @return \App\Core\ServiceResponse
     */
    public function reActivateByOtsId(
        int $otsId
    ): ServiceResponse;
}
