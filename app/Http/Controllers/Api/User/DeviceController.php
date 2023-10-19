<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Http\Requests\Api\User\DeviceController\CreateRequest;
use App\Http\Requests\Api\User\DeviceController\DeleteRequest;
use App\Http\Requests\Api\User\DeviceController\IndexRequest;
use App\Http\Requests\Api\User\DeviceController\GetByIdRequest;
use App\Http\Requests\Api\User\DeviceController\PaginateByEmployeeIdRequest;
use App\Http\Requests\Api\User\DeviceController\UpdateRequest;
use App\Interfaces\Eloquent\IDeviceService;
use App\Traits\Response;

class DeviceController extends Controller
{
    use Response;

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
     * @param IndexRequest $request
     */
    public function index(IndexRequest $request)
    {
        $getByCompanyIdsResponse = $this->deviceService->index(
            $request->pageIndex,
            $request->pageSize,
            $request->keyword,
            $request->categoryIds,
            $request->statusIds
        );
        if ($getByCompanyIdsResponse->isSuccess()) {
            return $this->success(
                $getByCompanyIdsResponse->getMessage(),
                $getByCompanyIdsResponse->getData(),
                $getByCompanyIdsResponse->getStatusCode()
            );
        } else {
            return $this->error(
                $getByCompanyIdsResponse->getMessage(),
                $getByCompanyIdsResponse->getStatusCode()
            );
        }
    }

    /**
     * @param PaginateByEmployeeIdRequest $request
     */
    public function paginateByEmployeeId(PaginateByEmployeeIdRequest $request)
    {
        $getByCompanyIdsResponse = $this->deviceService->paginateByEmployeeId(
            $request->employeeId,
            $request->pageIndex,
            $request->pageSize,
            $request->keyword,
            $request->categoryIds,
            $request->statusIds
        );
        if ($getByCompanyIdsResponse->isSuccess()) {
            return $this->success(
                $getByCompanyIdsResponse->getMessage(),
                $getByCompanyIdsResponse->getData(),
                $getByCompanyIdsResponse->getStatusCode()
            );
        } else {
            return $this->error(
                $getByCompanyIdsResponse->getMessage(),
                $getByCompanyIdsResponse->getStatusCode()
            );
        }
    }

    /**
     * @param GetByIdRequest $request
     */
    public function getById(GetByIdRequest $request)
    {
        $getByIdResponse = $this->deviceService->getById(
            $request->id
        );
        if ($getByIdResponse->isSuccess()) {
            return $this->success(
                $getByIdResponse->getMessage(),
                $getByIdResponse->getData(),
                $getByIdResponse->getStatusCode()
            );
        } else {
            return $this->error(
                $getByIdResponse->getMessage(),
                $getByIdResponse->getStatusCode()
            );
        }
    }

    /**
     * @param CreateRequest $request
     */
    public function create(CreateRequest $request)
    {
        $createResponse = $this->deviceService->create(
            $request->categoryId,
            $request->statusId,
            $request->packageId,
            $request->employeeId,
            $request->name,
            $request->brand,
            $request->model,
            $request->serialNumber,
            $request->ipAddress,
            $request->description
        );
        if ($createResponse->isSuccess()) {
            return $this->success(
                $createResponse->getMessage(),
                $createResponse->getData(),
                $createResponse->getStatusCode()
            );
        } else {
            return $this->error(
                $createResponse->getMessage(),
                $createResponse->getStatusCode()
            );
        }
    }

    /**
     * @param UpdateRequest $request
     */
    public function update(UpdateRequest $request)
    {
        $updateResponse = $this->deviceService->update(
            $request->user()->id,
            $request->id,
            $request->categoryId,
            $request->statusId,
            $request->packageId,
            $request->employeeId,
            $request->name,
            $request->brand,
            $request->model,
            $request->serialNumber,
            $request->ipAddress,
            $request->description
        );
        if ($updateResponse->isSuccess()) {
            return $this->success(
                $updateResponse->getMessage(),
                $updateResponse->getData(),
                $updateResponse->getStatusCode()
            );
        } else {
            return $this->error(
                $updateResponse->getMessage(),
                $updateResponse->getStatusCode()
            );
        }
    }

    /**
     * @param DeleteRequest $request
     */
    public function delete(DeleteRequest $request)
    {
        $deleteResponse = $this->deviceService->delete(
            $request->id
        );
        if ($deleteResponse->isSuccess()) {
            return $this->success(
                $deleteResponse->getMessage(),
                $deleteResponse->getData(),
                $deleteResponse->getStatusCode()
            );
        } else {
            return $this->error(
                $deleteResponse->getMessage(),
                $deleteResponse->getStatusCode()
            );
        }
    }
}
