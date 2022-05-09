<?php
    session_start();

    unset($_SESSION["user_id"]);
    unset($_SESSION["username"]);
    unset($_SESSION["nume"]);
    unset($_SESSION["prenume"]);
    unset($_SESSION["grad"]);
    $_SESSION["is_auth"] = false;
    header('Location: ../index.html');
?>