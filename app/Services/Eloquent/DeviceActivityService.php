<?php

namespace App\Services\Eloquent;

use App\Core\ServiceResponse;
use App\Interfaces\Eloquent\IDeviceActivityService;
use App\Models\Eloquent\DeviceActivity;

class DeviceActivityService implements IDeviceActivityService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'All device activities',
            200,
            DeviceActivity::all()
        );
    }

    /**
     * @param int $id
     *
     * @return \App\Core\ServiceResponse
     */
    public function getById(
        int $id
    ): ServiceResponse
    {
        $deviceActivity = DeviceActivity::find($id);
        if ($deviceActivity) {
            return new ServiceResponse(
                true,
                'Device activity',
                200,
                $deviceActivity
            );
        } else {
            return new ServiceResponse(
                false,
                'Device activity not found',
                404,
                null
            );
        }
    }

    /**
     * @param int $deviceId
     *
     * @return \App\Core\ServiceResponse
     */
    public function getByDeviceId(
        int $deviceId
    ): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'Device activities by device id',
            200,
            DeviceActivity::with([
                'user',
                'type',
                'device',
                'relation'
            ])->where('device_id', $deviceId)->get()
        );
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
        $deviceActivity = $this->getById($id);
        if ($deviceActivity->isSuccess()) {
            return new ServiceResponse(
                true,
                'Device activity deleted',
                200,
                $deviceActivity->getData()->delete()
            );
        } else {
            return $deviceActivity;
        }
    }
}
