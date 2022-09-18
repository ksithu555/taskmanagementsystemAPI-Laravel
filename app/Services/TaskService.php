<?php

namespace App\Services;

use App\Common\Exceptions\FatalErrorException;
use App\Repositories\Task\TaskRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\ErrorHandler\Error\FatalError;

class TaskService
{
    protected TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function getCompletedTasks()
    {
        return $this->taskRepository->all(['completed_status'=> 1]);
    }

    public function getIncompletedTasks()
    {
        return $this->taskRepository->all(['completed_status'=> 0]);
    }

    public function createTask($request)
    {
        $request = $request->only('title', 'priority', 'scheduled_date');

        $input['title'] = $request['title'];

        $input['priority'] = $request['priority'];

        $input['scheduled_date'] = $request['scheduled_date'];

        try {

            DB::beginTransaction();

            $task = $this->taskRepository->insert($input);

            DB::commit();

        } catch (Exception $exception) {

            DB::rollBack();

            throw new \App\Common\Exceptions\FatalErrorException($exception->getMessage());

        }

        return $task;
    }

    public function checkComplete($id)
    {
        $task = $this->taskRepository->getDataById($id);

        $input['completed_status'] = 1;

        $input['completed_date'] = Carbon::now()->toDateString();

        $this->taskRepository->update($input, $id);

        return $this->taskRepository->getDataById($id);

    }

    public function getTaskById($id)
    {
        return $this->taskRepository->getDataById($id);
    }

    public function updateTask($request, $id)
    {
        $input = [];
        if (isset($request->title)) {
            $input['title'] = $request->title;
        }

        if(isset($request->priority)) {
            $input['priority'] = $request->priority;
        }

        if(isset($request->scheduled_date)) {
            $input['scheduled_date'] = $request->scheduled_date;
        }

        try {

            DB::beginTransaction();

            $this->taskRepository->update($input, $id);

            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();

            throw new \App\Common\Exceptions\FatalErrorException($exception);
        }

        return $this->taskRepository->getDataById($id);
    }

    public function deleteTask($id)
    {
        return $this->taskRepository->destroy($id);
    }

    public function getAllTasks()
    {
        return $this->taskRepository->all();
    }
}
