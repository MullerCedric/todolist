<?php

namespace Controllers;


class Controller
{
    protected function checkLogin()
    {
        if ( isset( $_SESSION['user'] ) ) {
            return true;
        } else {
            header( 'Location: ' . HARDCODED_URL );
            exit;
        }
    }
}