<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use App\Common\Routing\Controller;
use App\Common\Exceptions\FatalErrorException;

class TaskController extends Controller
{

    protected TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * @return JsonResponse
     */
    public function index()
    {
        $tasks = $this->taskService->getAllTasks();

        return $this->response($tasks->toArray());
    }

    public function completedTasks()
    {
        $completedTasks = $this->taskService->getCompletedTasks();

        return $this->response($completedTasks->toArray());
    }

    public function incompletedTasks()
    {
        $incompletedTasks = $this->taskService->getIncompletedTasks();

        return $this->response($incompletedTasks->toArray());
    }

    public function show($id)
    {
        $task = $this->taskService->getTaskById($id);

        return $this->response($task->toArray());
    }
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws FatalErrorException
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'priority' => 'required',
            'scheduled_date' => 'required'
        ]);

        $response = $this->taskService->createTask($request);

        return $this->response($response->toArray());
    }

    public function checkComplete(Request $request,$id)
    {
        $task = $this->taskService->checkComplete($id);

        return $this->response($task->toArray());
    }

    public function update(Request $request, $id)
    {
        $task = $this->taskService->updateTask($request,$id);

        return $this->response($task->toArray());
    }

    /**
     * @param $ids
     */
    public function destroy($id)
    {
        $task = $this->taskService->deleteTask($id);

        return $this->response([$task]);
    }
}
