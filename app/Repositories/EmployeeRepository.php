<?php

namespace App\Repositories;

use App\Interfaces\EmployeeInterface;
use App\Models\Employee;
use Illuminate\Support\Collection;
use phpDocumentor\Reflection\Types\Void_;

class EmployeeRepository implements EmployeeInterface
{
    protected $model;

    public function __construct(Employee $employee)
    {  
        $this->model = $employee;        
    }

    public function getAllEmployees()
    {
        return $this->model->orderBy('created_at', 'desc')->paginate(10);
    }

    public function getByEmployees($id): Employee
    {
        return $this->model->findOrFail($id);
    }

    public function createEmployees(array $data): Employee
    {
        return $this->model->create($data);
    }


    public function updateEmployees(Employee $employee, array $data): Employee
    {
       $employee->update($data);

       return $employee;
    }

    public function deleteEmployees(Employee $employee)
    {
        $employee->delete();
    }
}