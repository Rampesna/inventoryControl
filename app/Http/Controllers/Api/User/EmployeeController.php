<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Http\Requests\Api\User\EmployeeController\CreateRequest;
use App\Http\Requests\Api\User\EmployeeController\GetAllRequest;
use App\Http\Requests\Api\User\EmployeeController\GetAllWithDevicesRequest;
use App\Http\Requests\Api\User\EmployeeController\GetByIdRequest;
use App\Http\Requests\Api\User\EmployeeController\SetDevicesRequest;
use App\Interfaces\Eloquent\IEmployeeService;
use App\Traits\Response;

class EmployeeController extends Controller
{
    use Response;

    /**
     * @var $employeeService
     */
    private $employeeService;

    /**
     * @var $jobDepartmentService
     */
    public function __construct(IEmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    /**
     * @param GetAllRequest $request
     */
    public function getAll(GetAllRequest $request)
    {
        $getAllWorkersResponse = $this->employeeService->getAll();
        if ($getAllWorkersResponse->isSuccess()) {
            return $this->success(
                $getAllWorkersResponse->getMessage(),
                $getAllWorkersResponse->getData(),
                $getAllWorkersResponse->getStatusCode()
            );
        } else {
            return $this->error(
                $getAllWorkersResponse->getMessage(),
                $getAllWorkersResponse->getStatusCode()
            );
        }
    }

    /**
     * @param GetAllWithDevicesRequest $request
     */
    public function getAllWithDevices(GetAllWithDevicesRequest $request)
    {
        $getAllWorkersResponse = $this->employeeService->getAllWithDevices();
        if ($getAllWorkersResponse->isSuccess()) {
            return $this->success(
                $getAllWorkersResponse->getMessage(),
                $getAllWorkersResponse->getData(),
                $getAllWorkersResponse->getStatusCode()
            );
        } else {
            return $this->error(
                $getAllWorkersResponse->getMessage(),
                $getAllWorkersResponse->getStatusCode()
            );
        }
    }

    /**
     * @param GetByIdRequest $request
     */
    public function getById(GetByIdRequest $request)
    {
        $getByIdResponse = $this->employeeService->getById($request->id);
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
        $createResponse = $this->employeeService->create(
            $request->otsId,
            $request->name,
            $request->email,
            $request->password
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
     * @param SetDevicesRequest $request
     */
    public function setDevices(SetDevicesRequest $request)
    {
        $createResponse = $this->employeeService->setDevices(
            $request->user()->id,
            $request->employeeId,
            $request->deviceIds
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
}
