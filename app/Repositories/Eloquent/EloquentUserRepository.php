<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\EloquentBaseRepository;
use App\Repositories\Interfaces\UserRepositoryInterface;

class EloquentUserRepository extends EloquentBaseRepository implements UserRepositoryInterface {

    public function __construct(User $user)
    {
        parent::__construct($user);
    }
}