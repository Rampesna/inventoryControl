<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Http\Requests\Api\User\DeviceActivityController\GetByDeviceIdRequest;
use App\Interfaces\Eloquent\IDeviceActivityService;
use App\Traits\Response;

class DeviceActivityController extends Controller
{
    use Response;

    /**
     * @var $deviceActivityService
     */
    private $deviceActivityService;

    /**
     * @param IDeviceActivityService $deviceActivityService
     */
    public function __construct(IDeviceActivityService $deviceActivityService)
    {
        $this->deviceActivityService = $deviceActivityService;
    }

    /**
     * @param GetByDeviceIdRequest $request
     */
    public function getByDeviceId(GetByDeviceIdRequest $request)
    {
        $getByDeviceIdResponse = $this->deviceActivityService->getByDeviceId(
            $request->deviceId
        );
        if ($getByDeviceIdResponse->isSuccess()) {
            return $this->success(
                $getByDeviceIdResponse->getMessage(),
                $getByDeviceIdResponse->getData(),
                $getByDeviceIdResponse->getStatusCode()
            );
        } else {
            return $this->error(
                $getByDeviceIdResponse->getMessage(),
                $getByDeviceIdResponse->getStatusCode()
            );
        }
    }
}
