<?php
namespace Models;

class Task extends Model
{
    public function getTasks( string $userId )
    {
        $pdo = $this->connectDB();
        if ( $pdo ) {
            try {
                $pdoSt =
                    $pdo->prepare('
                      SELECT tasks.id as taskID, tasks.description, tasks.is_done FROM todochecker.tasks
                      JOIN task_user ON tasks.id = task_user.task_id
                      JOIN users ON task_user.user_id = users.id
                      WHERE users.id = :userId
                ');
                $pdoSt->execute([
                    ':userId' => $userId,
                ]);
                $tasks = $pdoSt->fetchAll();
                foreach ( $tasks as $task ) {
                    $task->editable = 0;
                }
                return $tasks;
            } catch ( \PDOException $exception ) {
                return null;
            }
        }
        return null;
    }
    public function addTask( string $description, int $userId )
    {
        $pdo = $this->connectDB();
        if ( $pdo ) {
            try {
                $pdoSt =
                    $pdo->prepare(
                        'INSERT INTO tasks(`description`) VALUES(:description)'
                    );
                $pdoSt->execute([
                    ':description' => $description
                ]);
                $taskId = $pdo->lastInsertId();
                $sql = sprintf(
                    'INSERT INTO task_user( task_id, user_id ) VALUES( \'%s\', \'%s\'  )',
                    $taskId,
                    $userId
                );
                $pdo->exec($sql);

                return true;
            } catch ( \PDOException $exception ) {
                return false;
            }
        }
        return false;
    }
    public function checkDesc( $description ) {
        $description = trim( $description );
        if ( strlen( $description ) > 1 ) {
            return $description;
        }

        return false;
    }
    public function checkId( $id ) {
        return ctype_digit( $id );
    }
    public function deleteTask( int $taskId ) {
        $pdo = $this->connectDB();
        if ( $pdo ) {
            try {
                $sql = sprintf(
                    'DELETE FROM tasks WHERE id = \'%s\'',
                    $taskId
                );
                $pdo->exec( $sql );
                $sql = sprintf(
                    'DELETE FROM task_user WHERE task_id = \'%s\'',
                    $taskId
                );
                $pdo->exec( $sql );

                return true;
            } catch ( \PDOException $exception ) {
                return false;
            }
        }
        return false;
    }
    public function getUpdateForm( $id, $tasks ) {
        foreach ( $tasks as $task ) {
            if ( $task->taskID == $id ) {
                $task->editable = 1;
            }
        }
        return $tasks;
    }
    public function updateTask( $id, $desc, $is_done ) {
        $pdo = $this->connectDB();
        if ( $pdo ) {
            if( $desc ) {
                $sql = 'UPDATE tasks SET description = :description, is_done = :is_done WHERE id = :id';
                $execArray = [
                    'description' => $desc,
                    'is_done' => $is_done,
                    'id' => $id
                ];
            } else {
                $sql = 'UPDATE tasks SET is_done = :is_done WHERE id = :id';
                $execArray = [
                    'is_done' => $is_done,
                    'id' => $id
                ];
            }
            try {
                $pdoSt =
                    $pdo->prepare( $sql );
                $pdoSt->execute( $execArray );
                return true;

            } catch ( \PDOException $exception ) {
                echo $exception;
                return false;
            }
        }
        return false;
    }
}