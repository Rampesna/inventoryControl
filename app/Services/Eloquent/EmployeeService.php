<?php

namespace App\Services\Eloquent;

use App\Core\ServiceResponse;
use App\Interfaces\Eloquent\IEmployeeService;
use App\Models\Eloquent\Device;
use App\Models\Eloquent\DeviceActivity;
use App\Models\Eloquent\Employee;

class EmployeeService implements IEmployeeService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'All employees',
            200,
            Employee::orderBy('name')->get()
        );
    }

    /**
     * @return ServiceResponse
     */
    public function getById(
        int $id
    ): ServiceResponse
    {
        $employee = Employee::find($id);
        if ($employee) {
            return new ServiceResponse(
                true,
                'Employee',
                200,
                $employee
            );
        } else {
            return new ServiceResponse(
                false,
                'Employee not found',
                404,
                null
            );
        }
    }

    /**
     * @return ServiceResponse
     */
    public function delete(
        int $id
    ): ServiceResponse
    {
        $employee = $this->getById($id);
        if ($employee->isSuccess()) {
            return new ServiceResponse(
                true,
                'Employee',
                200,
                $employee->getData()->delete()
            );
        } else {
            return $employee;
        }
    }

    /**
     * @return ServiceResponse
     */
    public function deleteByOtsId(
        int $otsId
    ): ServiceResponse
    {
        $employee = Employee::where('ots_id', $otsId)->first();
        if ($employee) {
            $employee->leave = 1;
            $employee->save();

            return new ServiceResponse(
                true,
                'Employee left',
                200,
                $employee->delete()
            );
        } else {
            return new ServiceResponse(
                false,
                'Employee not found',
                404,
                null
            );
        }
    }

    /**
     * @return ServiceResponse
     */
    public function reActivateByOtsId(
        int $otsId
    ): ServiceResponse
    {
        $employee = Employee::where('ots_id', $otsId)->first();
        if ($employee) {
            $employee->leave = 0;
            $employee->save();

            return new ServiceResponse(
                true,
                'Employee left',
                200,
                $employee->delete()
            );
        } else {
            return new ServiceResponse(
                false,
                'Employee not found',
                404,
                null
            );
        }
    }

    /**
     * @return ServiceResponse
     */
    public function getAllWithDevices(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'All employees',
            200,
            Employee::with([
                'devices'
            ])->orderBy('name')->get()
        );
    }

    /**
     * @param int $id
     *
     * @return \App\Core\ServiceResponse
     */
    public function getByIdWithDevices(
        int $id
    ): ServiceResponse
    {
        $employee = Employee::with([
            'devices' => function ($query) {
                $query->with([
                    'category',
                    'status',
                    'package'
                ]);
            }
        ])->find($id);
        if ($employee) {
            return new ServiceResponse(
                true,
                'Employee',
                200,
                $employee
            );
        } else {
            return new ServiceResponse(
                false,
                'Employee not found',
                404,
                null
            );
        }
    }

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
    ): ServiceResponse
    {
        $employee = new Employee();
        $employee->ots_id = $otsId;
        $employee->name = $name;
        $employee->email = $email;
        $employee->password = bcrypt($password);
        $employee->save();

        return new ServiceResponse(
            true,
            'Employee created',
            201,
            $employee
        );
    }

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
    ): ServiceResponse
    {
        $employee = $this->getById($employeeId);
        if ($employee->isSuccess()) {
            foreach ($deviceIds as $deviceId) {
                $device = Device::find($deviceId);
                if ($device) {
                    if ($device->employee_id) {
                        $deviceActivity = new DeviceActivity;
                        $deviceActivity->user_id = $userId;
                        $deviceActivity->device_id = $deviceId;
                        $deviceActivity->activity_type_id = 2;
                        $deviceActivity->relation_id = $device->employee_id;
                        $deviceActivity->relation_type = Employee::class;
                        $deviceActivity->datetime = now();
                        $deviceActivity->description = 'Device unassigned from employee';
                        $deviceActivity->save();
                    }

                    $device->employee_id = $employeeId;
                    $device->save();

                    $deviceActivity = new DeviceActivity;
                    $deviceActivity->user_id = $userId;
                    $deviceActivity->device_id = $deviceId;
                    $deviceActivity->activity_type_id = 1;
                    $deviceActivity->relation_id = $employeeId;
                    $deviceActivity->relation_type = Employee::class;
                    $deviceActivity->datetime = now();
                    $deviceActivity->description = 'Device assigned to employee';
                    $deviceActivity->save();
                }
            }

            return new ServiceResponse(
                true,
                'Devices assigned to employee',
                200,
                null
            );
        } else {
            return $employee;
        }
    }

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
    ): ServiceResponse
    {
        $employee = $this->getById($employeeId);
        if ($employee->isSuccess()) {
            foreach ($deviceIds as $deviceId) {
                $device = Device::find($deviceId);
                if ($device) {
                    $device->employee_id = null;
                    $device->save();

                    $deviceActivity = new DeviceActivity;
                    $deviceActivity->user_id = $userId;
                    $deviceActivity->device_id = $deviceId;
                    $deviceActivity->activity_type_id = 2;
                    $deviceActivity->relation_id = $employeeId;
                    $deviceActivity->relation_type = Employee::class;
                    $deviceActivity->datetime = now();
                    $deviceActivity->description = 'Device unassigned from employee';
                    $deviceActivity->save();
                }
            }

            return new ServiceResponse(
                true,
                'Devices unassigned from employee',
                200,
                null
            );
        } else {
            return $employee;
        }
    }
}
