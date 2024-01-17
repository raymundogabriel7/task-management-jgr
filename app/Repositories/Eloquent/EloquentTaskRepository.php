<?php

namespace App\Repositories\Eloquent;

use App\Models\Task;
use App\Repositories\EloquentBaseRepository;
use App\Repositories\Interfaces\TaskRepositoryInterface;

class EloquentTaskRepository extends EloquentBaseRepository implements TaskRepositoryInterface {
    
    public function __construct(Task $task)
    {
        parent::__construct($task);
    }
}