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
        if($allTasks = $this->taskRepository->all(['user'])) {
            return response()->json(['message' => 'All Tasks', 'data' => $allTasks->toArray(),  'success' => true], config('constants.HTTP_CODE_OK'));
        }

        return response()->json(['message' => 'Failed to fetch all.', 'success' => false], config('constants.HTTP_CODE_INTERNAL_SERVER_ERROR'));
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

        if ($newTask) {
            return response()->json(['message' => 'Successfully saved!', 'data' => $newTask->toArray(), 'success' => true], config('constants.HTTP_CODE_OK'));
        }
        
        return response()->json(['message' => 'Failed to save.', 'success' => false], config('constants.HTTP_CODE_BAD_REQUEST'));        
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        if($task) {
            return response()->json(['message' => 'Task', 'data'=> $task->toArray(), 'success' => true], config('constants.HTTP_CODE_OK'));
        }

        return response()->json(['message' => 'Failed to fetch.', 'success' => false], config('constants.HTTP_CODE_NOT_FOUND'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task = $this->taskRepository->update($task, $request->request->all());

        if ($task) {
            return response()->json(['message' => 'Successfully updated!', 'data' => $task->toArray(), 'success' => true], config('constants.HTTP_CODE_OK'));
        }

        return response()->json(['message' => 'Failed to update.', 'success' => false], config('constants.HTTP_CODE_BAD_REQUEST'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if($this->taskRepository->delete($task)) {
            return response()->json(['message' => 'Deleted', 'success' => true], config('constants.HTTP_CODE_OK'));    
        }

        return response()->json(['message' => 'Failed to update.', 'success' => false], config('constants.HTTP_CODE_NOT_FOUND'));
    }
}
