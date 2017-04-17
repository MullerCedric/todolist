<?php
namespace Controllers;

class Task
{
    public $ModelTask = null;
    public $Model = null;
    public function __construct() {
        $this->ModelTask = new \Models\Task();
        $this->Model = new \Models\model();
    }

    public function checkLogin()
    {
        if (isset($_SESSION['user'])) {
            return true;
        } else {
            header('Location: ' . HARDCODED_URL);
            exit;
        }
    }

    public function index(): array
    {
        $this->checkLogin();

        $tasks = $this->ModelTask->getTasks($_SESSION['user']->id);
        $view = 'views/tasksIndex.php';

        return compact('view', 'tasks');
    }

    public function create()
    {
        $this->checkLogin();

        $description = $this->ModelTask->checkDesc( $_POST['description'] );
        if ( !$description ) {
            header('Location: '.HARDCODED_URL.'errors/error_main.php');
            exit;
        }
        $this->ModelTask->addTask($description, $_SESSION['user']->id);

        header('Location: ' . HARDCODED_URL);
        exit;
    }

    public function delete()
    {
        $this->checkLogin();

        $taskId = $this->ModelTask->checkId( $_POST['id'] );
        if ( !$taskId ) {
            header('Location: '.HARDCODED_URL.'errors/error_main.php');
            exit;
        }
        $this->ModelTask->deleteTask( $_POST['id'] );

        header('Location: ' . HARDCODED_URL);
        exit;
    }

    public function getUpdate()
    {
        $this->checkLogin();

        $taskId = $this->ModelTask->checkId( $_GET['id'] );
        if ( !$taskId ) {
            header('Location: '.HARDCODED_URL.'errors/error_main.php');
            exit;
        }
        $tasks = $this->ModelTask->getTasks($_SESSION['user']->id);
        $view = 'views/tasksIndex.php';
        $tasks = $this->ModelTask->getUpdateForm( $taskId, $tasks );

        return compact('view', 'tasks');
    }

    public function postUpdate() {
        $this->checkLogin();

        $taskId = $this->ModelTask->checkId( $_POST['id'] );
        $description = $this->ModelTask->checkDesc( $_POST['description'] );
        if ( !$taskId ) {
            header('Location: '.HARDCODED_URL.'errors/error_main.php');
            exit;
        }

        $checked = isset( $_POST['is_done'] ) ? 1 : 0;
        $this->ModelTask->updateTask( $taskId, $description, $checked );

        header('Location: ' . HARDCODED_URL);
        exit;
    }
}