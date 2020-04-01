<?php

namespace App\Models;

class Tasks
{
    public function getTasks($employeeID, $idRole, $done = null)
    {
        if ($idRole == 1) {
            $queryID = "t.idBoss";
        } else {
            $queryID = "t.idEmployee";
        }
        if ($done === null) {
            $doneOperator = "<>";
        } else {
            $doneOperator = "=";
        }

        return \DB::table("tasks AS t")
            ->join("users AS u", "t.idEmployee", "=", "u.id")
            ->select("t.*", "u.first_name AS emp_first_name", "u.last_name AS emp_last_name", "u.imagePath", "u.imagePathNew")
            ->where([
                [$queryID, '=', $employeeID],
                ['t.done', $doneOperator, $done],
            ])

            ->get();
    }
    public function updateTask($employeeID, $idTask)
    {

        return \DB::table("tasks")
            ->where([
                ['idEmployee', '=', $employeeID],
                ['idTask', '=', $idTask],
            ])
            ->update(['done' => 1]);
    }
    public function addTask($idEmployee, $idBoss, $taskName, $description, $idSend, $date, $priority)
    {
        return \DB::table('tasks')->insert(
            ['idEmployee' => $idEmployee, 'idBoss' => $idBoss, 'uniqueId' => $idSend, 'task_name' => $taskName, 'description' => $description, 'date' => $date, 'priority' => $priority, 'done' => 0]
        );
    }

}
