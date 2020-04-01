<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddTaskRequest;
use App\Models\Tasks;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    private $model;
    private $employeeID;
    private $idRole;
    private $querydID;
    public function __construct()
    {
        $this->model = new Tasks();

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
        // $niz = ['emp' => $this->employeeID];
        try {
            $tasks = $this->model->getTasks($employeeID, $idRole, $done);
            return response($tasks, 200);
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
            return response($tasks, 200);
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
            if ($isUpdated) {
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
