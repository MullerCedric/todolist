<?php
namespace Controllers;

class Auth
{
    public $ModelAuth = null;
    public function __construct() {
        $this->ModelAuth = new \Models\Auth();
    }

    public function getLogin(): array
    {
        return ['view' => 'views/getLogin.php'];
    }

    public function getLogout()
    {
        $_SESSION = array();
        if ( ini_get('session.use_cookies') ) {
            $params = session_get_cookie_params();
            setcookie( session_name(), '', 1,
                $params['path'], $params['domain'],
                $params['secure'], $params['httponly']
            );
        }
        session_destroy();
        header( 'Location: ' . HARDCODED_URL );
        exit;
    }

    public function postLogin(): void
    {
        $_SESSION['user'] = null;
        $email = $_POST['email'];
        echo $password = sha1( $_POST['password'] );
        $user = $this->ModelAuth->checkUser( $email, $password );
        if ( !$user ) {
            header( 'Location: ' . HARDCODED_URL );
            exit;
        }
        $_SESSION['user'] = $user;
        header( 'Location: ' . HARDCODED_URL . 'index.php?a=index&r=task' );
        exit;
    }
}