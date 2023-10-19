<?php

namespace App\Services\Eloquent;

use App\Core\ServiceResponse;
use App\Interfaces\Eloquent\IDevicePackageService;
use App\Interfaces\Eloquent\IDeviceService;
use App\Models\Eloquent\DeviceActivity;
use App\Models\Eloquent\DevicePackage;
use App\Models\Eloquent\Employee;

class DevicePackageService implements IDevicePackageService
{
    /**
     * @var $deviceService
     */
    private $deviceService;

    /**
     * @param IDeviceService $deviceService
     */
    public function __construct(IDeviceService $deviceService)
    {
        $this->deviceService = $deviceService;
    }

    /**
     * @return \App\Core\ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'All device categories',
            200,
            DevicePackage::all()
        );
    }

    /**
     * @param int $id
     *
     * @return ServiceResponse
     */
    public function getById(
        int $id
    ): ServiceResponse
    {
        $devicePackage = DevicePackage::find($id);
        if ($devicePackage) {
            return new ServiceResponse(
                true,
                'Device package',
                200,
                $devicePackage
            );
        } else {
            return new ServiceResponse(
                false,
                'Device package not found',
                404,
                null
            );
        }
    }

    /**
     * @param int $pageIndex
     * @param int $pageSize
     * @param string|null $keyword
     *
     * @return \App\Core\ServiceResponse
     */
    public function index(
        int    $pageIndex,
        int    $pageSize,
        string $keyword = null
    ): ServiceResponse
    {
        $devicePackages = DevicePackage::with([]);

        if ($keyword) {
            $devicePackages->where('name', 'like', '%' . $keyword . '%');
        }

        return new ServiceResponse(
            true,
            'All device packages',
            200,
            [
                'totalCount' => $devicePackages->count(),
                'pageIndex' => $pageIndex,
                'pageSize' => $pageSize,
                'devicePackages' => $pageSize == -1 ? $devicePackages->get() : $devicePackages->skip($pageSize * $pageIndex)
                    ->take($pageSize)
                    ->get()
            ]
        );
    }

    /**
     * @param int $id
     *
     * @return \App\Core\ServiceResponse
     */
    public function getDevices(
        int $id
    ): ServiceResponse
    {
        $devicePackage = $this->getById($id);
        if ($devicePackage->isSuccess()) {
            return new ServiceResponse(
                true,
                'Device package devices',
                200,
                $devicePackage->getData()->devices
            );
        } else {
            return $devicePackage;
        }
    }

    /**
     * @param int $devicePackageId
     * @param array $deviceIds
     *
     * @return ServiceResponse
     */
    public function setDevices(
        int   $devicePackageId,
        array $deviceIds
    ): ServiceResponse
    {
        $getByPackageIdResponse = $this->deviceService->getByPackageId($devicePackageId);
        if ($getByPackageIdResponse->isSuccess()) {
            $updatePackageIdByIdsResponse = $this->deviceService->updatePackageIdByIds(
                $getByPackageIdResponse->getData()->pluck('id')->toArray(),
                null
            );
            if ($updatePackageIdByIdsResponse->isSuccess()) {
                $getByIdsResponse = $this->deviceService->getByIds($deviceIds);
                if ($getByIdsResponse) {
                    $updatePackageIdByIdsResponse = $this->deviceService->updatePackageIdByIds(
                        $getByIdsResponse->getData()->pluck('id')->toArray(),
                        $devicePackageId
                    );
                    if ($updatePackageIdByIdsResponse->isSuccess()) {
                        return new ServiceResponse(
                            true,
                            'Device package devices updated',
                            200,
                            null
                        );
                    } else {
                        return $updatePackageIdByIdsResponse;
                    }
                } else {
                    return $getByIdsResponse;
                }
            } else {
                return $updatePackageIdByIdsResponse;
            }
        } else {
            return $getByPackageIdResponse;
        }
    }

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
    ): ServiceResponse
    {
        $devicesByPackageId = $this->deviceService->getByPackageId($devicePackageId);

        if (!$devicesByPackageId->isSuccess()) {
            return $devicesByPackageId;
        }

        foreach ($devicesByPackageId->getData() as $device) {
            if ($device->employee_id) {
                if ($device->employee_id != $employeeId) {
                    $deviceActivity = new DeviceActivity;
                    $deviceActivity->user_id = $userId;
                    $deviceActivity->device_id = $device->id;
                    $deviceActivity->activity_type_id = 2;
                    $deviceActivity->relation_id = $device->employee_id;
                    $deviceActivity->relation_type = Employee::class;
                    $deviceActivity->datetime = now();
                    $deviceActivity->description = 'Device unassigned from employee';
                    $deviceActivity->save();

                    $deviceActivity = new DeviceActivity;
                    $deviceActivity->user_id = $userId;
                    $deviceActivity->device_id = $device->id;
                    $deviceActivity->activity_type_id = 1;
                    $deviceActivity->relation_id = $employeeId;
                    $deviceActivity->relation_type = Employee::class;
                    $deviceActivity->datetime = now();
                    $deviceActivity->description = 'Device assigned to employee';
                    $deviceActivity->save();

                    $device->employee_id = $employeeId;
                    $device->save();
                }
            } else {
                $deviceActivity = new DeviceActivity;
                $deviceActivity->user_id = $userId;
                $deviceActivity->device_id = $device->id;
                $deviceActivity->activity_type_id = 1;
                $deviceActivity->relation_id = $employeeId;
                $deviceActivity->relation_type = Employee::class;
                $deviceActivity->datetime = now();
                $deviceActivity->description = 'Device assigned to employee';
                $deviceActivity->save();

                $device->employee_id = $employeeId;
                $device->save();
            }
        }

        return new ServiceResponse(
            true,
            'Device package employee updated',
            200,
            null
        );
    }

    /**
     * @param int $companyId
     * @param string $name
     *
     * @return ServiceResponse
     */
    public function create(
        string $name
    ): ServiceResponse
    {
        $checkDevice = DevicePackage::where('name', $name)->first();
        if ($checkDevice) {
            return new ServiceResponse(
                false,
                'Device package already exists',
                409,
                null
            );
        }

        $devicePackage = new DevicePackage;
        $devicePackage->name = $name;
        $devicePackage->save();

        return new ServiceResponse(
            true,
            'Device package created',
            201,
            $devicePackage
        );
    }

    /**
     * @param int $id
     * @param string $name
     *
     * @return ServiceResponse
     */
    public function update(
        int    $id,
        string $name
    ): ServiceResponse
    {
        $devicePackage = $this->getById($id);
        if ($devicePackage->isSuccess()) {
            $checkDeviceName = DevicePackage::where('name', $name)->where('id', '!=', $id)->first();
            if ($checkDeviceName) {
                return new ServiceResponse(
                    false,
                    'Device package already exists',
                    409,
                    null
                );
            }

            $devicePackage->getData()->name = $name;
            $devicePackage->getData()->save();

            return new ServiceResponse(
                true,
                'Device package updated',
                200,
                $devicePackage->getData()
            );
        } else {
            return $devicePackage;
        }
    }

    /**
     * @param int $id
     *
     * @return ServiceResponse
     */
    public function delete(
        int $id
    ): ServiceResponse
    {
        $devicePackage = $this->getById($id);
        if ($devicePackage->isSuccess()) {
            return new ServiceResponse(
                true,
                'Device package deleted',
                200,
                $devicePackage->getData()->delete()
            );
        } else {
            return $devicePackage;
        }
    }

}
