<?php

namespace App\Interfaces;

use App\Models\Employee;

interface EmployeeInterface
{
    public function getAllEmployees();

    public function getByEmployees($id): Employee;

    public function createEmployees(array $data): Employee;

    public function updateEmployees(Employee $employee, array $data): Employee;

    public function deleteEmployees(Employee $employee);
}
