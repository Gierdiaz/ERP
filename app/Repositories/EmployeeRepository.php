<?php

namespace App\Repositories;

use App\Interfaces\EmployeeInterface;
use App\Models\Employee;

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
    
}