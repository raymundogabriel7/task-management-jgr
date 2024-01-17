<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;

class TaskController extends Controller
{
    /**
     * @var TaskRepositoryInterface
     */
    private $taskRepository;
    
    /**
     * Class constructor
     * 
     * @param TaskRepositoryInterface $taskRepository
     */
    public function __construct(TaskRepositoryInterface $taskRepository) 
    {
        $this->taskRepository = $taskRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if($allTasks = $this->taskRepository->all()) {
            return response()->json(['message' => 'All Tasks', 'data' => $allTasks->toArray()], config('constants.HTTP_CODE_OK'));
        }

        return response()->json(['message' => 'Failed to fetch all.'], config('constants.HTTP_CODE_INTERNAL_SERVER_ERROR'));
    }

    /**
     * Authenticate username and password.
     *
     * @param StoreTaskRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTaskRequest $request)
    {
        $newTask = $this->taskRepository->save($request->request->all());

        if (!$newTask) {
            return response()->json(['message' => 'Failed to save.'], config('constants.HTTP_CODE_BAD_REQUEST'));
        }
        
        return response()->json(['message' => 'Success', 'data' => $newTask->toArray()], config('constants.HTTP_CODE_OK'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        if($showTask = $this->taskRepository->findOne($task)) {
            return response()->json(['message' => 'Task', 'data', $showTask->toArray()], config('constants.HTTP_CODE_OK'));
        }

        return response()->json(['message' => 'Failed to fetch.'], config('constants.HTTP_CODE_NOT_FOUND'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task = $this->taskRepository->update($task, $request->request->all());

        if (!$task) {
            return response()->json(['message' => 'Failed to update.'], config('constants.HTTP_CODE_BAD_REQUEST'));
        }
        
        return response()->json(['message' => 'Success', 'data' => $task->toArray()], config('constants.HTTP_CODE_OK'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if(!$this->taskRepository->delete($task)) {
            return response()->json(['message' => 'Failed to update.'], config('constants.HTTP_CODE_NOT_FOUND'));
        }

        return response()->json(['message' => 'Deleted'], config('constants.HTTP_CODE_OK'));
    }
}
