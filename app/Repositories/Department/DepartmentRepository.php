<?php

namespace App\Repositories\Department;

use App\Models\Department;
use Recca0120\Repository\EloquentRepository;
use App\Repositories\Contracts\Department\DepartmentRepository as DepartmentRepositoryContract;

class DepartmentRepository extends EloquentRepository implements DepartmentRepositoryContract
{
    /** @var  Department */
    protected $model;

    public function __construct(Department $model)
    {
        parent::__construct($model);
    }
}

