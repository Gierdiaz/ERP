<?php

namespace App\Http\Controllers;

use App\Http\Requests\Employee\{EmployeeStoreFormRequest, EmployeeUpdateFormRequest};
use App\Http\Resources\EmployeeResource;
use App\Interfaces\EmployeeInterface;

class EmployeeController extends Controller
{
    protected $employeeRepository;

    public function __construct(EmployeeInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function index()
    {
        $employee = $this->employeeRepository->getAllEmployees();

        return EmployeeResource::collection($employee);
    }

    public function show($id)
    {
        $employee = $this->employeeRepository->getByEmployees($id);

        if(!$employee) {
            return response()->json(['error' => 'Employee do not found'], 404);
        }

        return EmployeeResource::make($employee);
    }

    public function store(EmployeeStoreFormRequest $request)
    {
        $validate = $request->validated();

        $employee = $this->employeeRepository->createEmployees($validate);

        return EmployeeResource::make($employee);
    }

    public function update(EmployeeUpdateFormRequest $request, $id)
    {
        $validate = $request->validated();

        $employee = $this->employeeRepository->getByEmployees($id);

        $update = $this->employeeRepository->updateEmployees($employee, $validate);

        return response()->json(['message' => 'Employee update successfully', 'data' => $update], 200);

    }

    public function destroy($id)
    {
        $employee = $this->employeeRepository->getAllEmployees($id);

        $this->employeeRepository->deleteEmployees($employee);

        return response()->json(['message' => 'Employee delete successfully', 'data' => $employee], 200);
    }
}
