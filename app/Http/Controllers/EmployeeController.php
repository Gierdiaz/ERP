<?php

namespace App\Http\Controllers;

use App\Http\Requests\Employee\EmployeeStoreFormRequest;
use App\Http\Resources\EmployeeResource;
use App\Interfaces\EmployeeInterface;
use App\Models\Employee;
use Illuminate\Http\Request;

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

    public function store(EmployeeStoreFormRequest $request)
    {
        $validate = $request->validated();

        $employee = $this->employeeRepository->createEmployees($validate);
    }

    public function show(Employee $employee)
    {
        //
    }

    public function update(Request $request, Employee $employee)
    {
        //
    }

    public function destroy(Employee $employee)
    {
        //
    }
}
