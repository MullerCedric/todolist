<?php
namespace Controllers;

class Task extends Controller
{
    public $modelTask = null;

    public function __construct() {
        $this->modelTask = new \Models\Task();
    }



    public function index(): array
    {
        $this->checkLogin();

        $tasks = $this->modelTask->getTasks( $_SESSION['user']->id );
        $view = 'views/tasksIndex.php';

        return compact( 'view', 'tasks' );
    }

    public function create()
    {
        $this->checkLogin();

        $description = $this->modelTask->checkDesc( $_POST['description'] );
        if ( !$description ) {
            header( 'Location: '.HARDCODED_URL.'errors/error_main.php' );
            exit;
        }
        $this->modelTask->addTask( $description, $_SESSION['user']->id );

        header( 'Location: ' . HARDCODED_URL );
        exit;
    }

    public function delete()
    {
        $this->checkLogin();

        if ( !$this->modelTask->checkId( $_POST['id'] ) ) {
            header( 'Location: '.HARDCODED_URL.'errors/error_main.php' );
            exit;
        }
        $this->modelTask->deleteTask( $_POST['id'] );

        header( 'Location: ' . HARDCODED_URL );
        exit;
    }

    public function getUpdate()
    {
        $this->checkLogin();

        if (  !$this->modelTask->checkId( $_POST['id'] ) ) {
            header( 'Location: '.HARDCODED_URL.'errors/error_main.php' );
            exit;
        }
        $tasks = $this->modelTask->getTasks( $_SESSION['user']->id );
        $view = 'views/tasksIndex.php';
        $tasks = $this->modelTask->getUpdateForm( $_POST['id'], $tasks );

        return compact( 'view', 'tasks' );
    }

    public function postUpdate() {
        $this->checkLogin();

        $description = $this->modelTask->checkDesc( $_POST['description'] );
        if ( !$this->modelTask->checkId( $_POST['id'] ) ) {
            header( 'Location: '.HARDCODED_URL.'errors/error_main.php' );
            exit;
        }

        $checked = isset( $_POST['is_done'] ) ? 1 : 0;
        $this->modelTask->updateTask( $_POST['id'], $description, $checked );

        header( 'Location: ' . HARDCODED_URL );
        exit;
    }
}