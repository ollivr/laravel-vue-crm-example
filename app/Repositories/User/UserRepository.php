<?php

namespace App\Repositories\User;

use App\Models\User;
use Recca0120\Repository\EloquentRepository;
use App\Repositories\Contracts\User\UserRepository as UserRepositoryContract;

class UserRepository extends EloquentRepository implements UserRepositoryContract
{
    /** @var  User */
    protected $model;

    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}

