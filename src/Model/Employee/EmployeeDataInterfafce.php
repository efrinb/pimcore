<?php

namespace App\Model\Employee;

interface EmployeeDataInterfafce
{
    public function getEmployeeName(): ?string;
    public function getEmployeeEmail(): ?string;
}
