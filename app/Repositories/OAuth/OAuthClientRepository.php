<?php

namespace App\Repositories\OAuth;

use App\Models\OAuth\OAuthClient;
use Recca0120\Repository\EloquentRepository;
use App\Repositories\Contracts\OAuth\OAuthClientRepository as OAuthClientRepositoryContract;

class OAuthClientRepository extends EloquentRepository implements OAuthClientRepositoryContract
{
    /** @var  OAuthClient */
    protected $model;

    public function __construct(OAuthClient $model)
    {
        parent::__construct($model);
    }
}

