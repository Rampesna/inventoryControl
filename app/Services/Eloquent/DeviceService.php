<?php

namespace App\Services\Eloquent;

use App\Core\ServiceResponse;
use App\Interfaces\Eloquent\IDeviceService;
use App\Models\Eloquent\Device;
use App\Models\Eloquent\DeviceActivity;
use App\Models\Eloquent\Employee;

class DeviceService implements IDeviceService
{
    /**
     * @return \App\Core\ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'All devices',
            200,
            Device::all()
        );
    }

    public function getById(
        int $id
    ): ServiceResponse
    {
        $device = Device::find($id);
        if ($device) {
            return new ServiceResponse(
                true,
                'Device',
                200,
                $device
            );
        } else {
            return new ServiceResponse(
                false,
                'Device not found',
                404,
                null
            );
        }
    }

    public function delete(
        int $id
    ): ServiceResponse
    {
        $device = $this->getById($id);
        if ($device->isSuccess()) {
            $device->getData()->delete();
            return new ServiceResponse(
                true,
                'Device deleted',
                200,
                null
            );
        } else {
            return $device;
        }
    }

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
    ): ServiceResponse
    {
        $devices = Device::with([
            'category',
            'status',
            'employee',
            'package'
        ])->orderBy('id', 'desc');

        if ($keyword) {
            $devices->where(function ($devices) use ($keyword) {
                $devices->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('brand', 'like', '%' . $keyword . '%')
                    ->orWhere('model', 'like', '%' . $keyword . '%')
                    ->orWhere('serial_number', 'like', '%' . $keyword . '%')
                    ->orWhere('ip_address', 'like', '%' . $keyword . '%');
            });
        }

        if ($categoryIds && count($categoryIds) > 0) {
            $devices->whereIn('category_id', $categoryIds);
        }

        if ($statusIds && count($statusIds) > 0) {
            $devices->whereIn('status_id', $statusIds);
        }

        return new ServiceResponse(
            true,
            'Devices',
            200,
            [
                'totalCount' => $devices->count(),
                'pageIndex' => $pageIndex,
                'pageSize' => $pageSize,
                'devices' => $devices->skip($pageSize * $pageIndex)
                    ->take($pageSize)
                    ->get()
            ]
        );
    }

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
    ): ServiceResponse
    {
        $devices = Device::with([
            'company',
            'category',
            'status',
            'employee',
            'package'
        ])->orderBy('id', 'desc')->where('employee_id', $employeeId);

        if ($keyword) {
            $devices->where(function ($devices) use ($keyword) {
                $devices->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('brand', 'like', '%' . $keyword . '%')
                    ->orWhere('model', 'like', '%' . $keyword . '%')
                    ->orWhere('serial_number', 'like', '%' . $keyword . '%')
                    ->orWhere('ip_address', 'like', '%' . $keyword . '%');
            });
        }

        if ($categoryIds && count($categoryIds) > 0) {
            $devices->whereIn('category_id', $categoryIds);
        }

        if ($statusIds && count($statusIds) > 0) {
            $devices->whereIn('status_id', $statusIds);
        }

        return new ServiceResponse(
            true,
            'Devices',
            200,
            [
                'totalCount' => $devices->count(),
                'pageIndex' => $pageIndex,
                'pageSize' => $pageSize,
                'devices' => $devices->skip($pageSize * $pageIndex)
                    ->take($pageSize)
                    ->get()
            ]
        );
    }

    /**
     * @param array $ids
     *
     * @return \App\Core\ServiceResponse
     */
    public function getByIds(
        array $ids
    ): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'Devices',
            200,
            Device::whereIn('id', $ids)->get()
        );
    }

    /**
     * @param int $packageId
     *
     * @return \App\Core\ServiceResponse
     */
    public function getByPackageId(
        int $packageId
    ): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'Devices',
            200,
            Device::where('package_id', $packageId)->get()
        );
    }

    /**
     * @param int $employeeId
     *
     * @return \App\Core\ServiceResponse
     */
    public function getByEmployeeId(
        int $employeeId
    ): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'Devices',
            200,
            Device::where('employee_id', $employeeId)->get()
        );
    }

    /**
     * @param array $ids
     * @param int|null $packageId
     *
     * @return \App\Core\ServiceResponse
     */
    public function updatePackageIdByIds(
        array    $ids,
        int|null $packageId = null
    ): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'Devices',
            200,
            Device::whereIn('id', $ids)->update(['package_id' => $packageId])
        );
    }

    /**
     * @param array $ids
     * @param int|null $employeeId
     *
     * @return \App\Core\ServiceResponse
     */
    public function updateEmployeeIdByIds(
        array    $ids,
        int|null $employeeId = null
    ): ServiceResponse
    {
        foreach ($ids as $id) {
            $device = $this->getById($id);
            if ($device->isSuccess()) {
                if ($device->getData()->employee_id != $employeeId) {

                }
            }
        }
        return new ServiceResponse(
            true,
            'Devices',
            200,
            Device::whereIn('id', $ids)->update(['employee_id' => $employeeId])
        );
    }

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
    ): ServiceResponse
    {
        $device = new Device;
        $device->category_id = $categoryId;
        $device->status_id = $statusId;
        $device->employee_id = $employeeId;
        $device->name = $name;
        $device->brand = $brand;
        $device->model = $model;
        $device->serial_number = $serialNumber;
        $device->ip_address = $ipAddress;
        $device->save();

        return new ServiceResponse(
            true,
            'Device created',
            201,
            $device
        );
    }

    /**
     * @param int $userId
     * @param int $id
     * @param int $companyId
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
    ): ServiceResponse
    {
        $device = $this->getById($id);
        if ($device->isSuccess()) {
            if ($device->getData()->employee_id) {
                if ($employeeId) {
                    if ($device->getData()->employee_id != $employeeId) {
                        $deviceActivity = new DeviceActivity;
                        $deviceActivity->user_id = $userId;
                        $deviceActivity->device_id = $id;
                        $deviceActivity->activity_type_id = 2;
                        $deviceActivity->relation_id = $device->getData()->employee_id;
                        $deviceActivity->relation_type = Employee::class;
                        $deviceActivity->datetime = now();
                        $deviceActivity->description = 'Device unassigned from employee';
                        $deviceActivity->save();

                        $deviceActivity = new DeviceActivity;
                        $deviceActivity->user_id = $userId;
                        $deviceActivity->device_id = $id;
                        $deviceActivity->activity_type_id = 1;
                        $deviceActivity->relation_id = $employeeId;
                        $deviceActivity->relation_type = Employee::class;
                        $deviceActivity->datetime = now();
                        $deviceActivity->description = 'Device assigned to employee';
                        $deviceActivity->save();
                    }
                } else {
                    $deviceActivity = new DeviceActivity;
                    $deviceActivity->user_id = $userId;
                    $deviceActivity->device_id = $id;
                    $deviceActivity->activity_type_id = 2;
                    $deviceActivity->relation_id = $device->getData()->employee_id;
                    $deviceActivity->relation_type = Employee::class;
                    $deviceActivity->datetime = now();
                    $deviceActivity->description = 'Device unassigned from employee';
                    $deviceActivity->save();
                }
            }
            $device->getData()->category_id = $categoryId;
            $device->getData()->status_id = $statusId;
            $device->getData()->employee_id = $employeeId;
            $device->getData()->name = $name;
            $device->getData()->brand = $brand;
            $device->getData()->model = $model;
            $device->getData()->serial_number = $serialNumber;
            $device->getData()->ip_address = $ipAddress;
            $device->getData()->save();

            return new ServiceResponse(
                true,
                'Device updated',
                200,
                $device->getData()
            );
        } else {
            return $device;
        }
    }
}
