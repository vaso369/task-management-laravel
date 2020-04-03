<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddTaskRequest;
use App\Models\Tasks;
use App\Models\UserActivity;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    private $model;
    public function __construct()
    {
        $this->model = new Tasks();
        $this->activity = new UserActivity();

    }
    public function getAllTasks(Request $request)
    {
        $employeeID = $request->input('idEmployee');
        $idRole = $request->input('idRole');

        try {
            $tasks = $this->model->getTasks($employeeID, $idRole);
            return response($tasks, 200);
        } catch (\PDOException $ex) {
            return response(['message' => $ex->getMessage()], 500);
        }
    }
    public function getProgressTasks(Request $request)
    {
        $employeeID = $request->input('idEmployee');
        $idRole = $request->input('idRole');

        $done = 0;
        try {
            $tasks = $this->model->getTasks($employeeID, $idRole, $done);
            $ip = request()->ip();
            $dateTime = date("Y-m-d H:i:s");
            $activity = "Getting progress tasks";
            $method = request()->getMethod();
            $isInserted = $this->activity->insert($employeeID, $ip, $dateTime, $activity, $method);
            if ($isInserted) {
                return response($tasks, 200);
            }

        } catch (\PDOException $ex) {
            return response(['message' => $ex->getMessage()], 500);
        }
    }
    public function getDoneTasks(Request $request)
    {
        $employeeID = $request->input('idEmployee');
        $idRole = $request->input('idRole');
        $done = 1;
        try {
            $tasks = $this->model->getTasks($employeeID, $idRole, $done);
            $ip = request()->ip();
            $dateTime = date("Y-m-d H:i:s");
            $activity = "Getting done tasks";
            $method = request()->getMethod();
            $isInserted = $this->activity->insert($employeeID, $ip, $dateTime, $activity, $method);
            if ($isInserted) {
                return response($tasks, 200);
            }

        } catch (\PDOException $ex) {
            return response(['message' => $ex->getMessage()], 500);
        }
    }
    public function getTasksBySearch(Request $request)
    {
        $employeeID = $request->input('idBoss');
        $idRole = $request->input('idRole');
        $done = $request->input('done');
        $searchValue = $request->input('searchValue');
        try {
            $tasks = $this->model->getTasksBySearch($employeeID, $idRole, $done, $searchValue);
            $ip = request()->ip();
            $dateTime = date("Y-m-d H:i:s");
            $activity = "Searching tasks";
            $method = request()->getMethod();
            $isInserted = $this->activity->insert($employeeID, $ip, $dateTime, $activity, $method);
            if ($isInserted) {
                return response($tasks, 200);
            }

        } catch (\PDOException $ex) {
            return response(['message' => $ex->getMessage()], 500);
        }
    }
    public function updateTask(Request $request)
    {
        $idTask = $request->input('idTask');
        $employeeID = $request->input('idEmployee');

        try {
            $isUpdated = $this->model->updateTask($employeeID, $idTask);
            $ip = request()->ip();
            $dateTime = date("Y-m-d H:i:s");
            $activity = "Progress task finished";
            $method = request()->getMethod();
            $isInserted = $this->activity->insert($employeeID, $ip, $dateTime, $activity, $method);
            if ($isUpdated && $isInserted) {
                return response(["message" => "Task updated!"], 204);
            }

        } catch (\PDOException $ex) {
            return response(['message' => $ex->getMessage()], 500);
        }
    }
    public function addTask(AddTaskRequest $request)
    {
        if (isset($errors)) {
            return response(['error' => $errors], 404);
        }

        $idEmployee = $request->input('idEmployee');
        $idBoss = $request->input('idBoss');
        $taskName = $request->input('taskName');
        $description = $request->input('description');
        $idSend = $request->input('idSend');
        $date = $request->input('date');
        $priority = $request->input('priority');
        try {
            $isInserted = $this->model->addTask($idEmployee, $idBoss, $taskName, $description, $idSend, $date, $priority);
            if ($isInserted) {
                return response(["message" => "Task added!"], 201);
            }

        } catch (\PDOException $ex) {
            return response(['message' => $ex->getMessage()], 500);
        }

    }
}
