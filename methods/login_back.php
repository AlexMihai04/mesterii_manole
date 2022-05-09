<?php
    include '../functions/db_methods.php';
    include '../functions/utils.php';
    $cfg = include('../cfg/cfg.php');
    error_reporting(0);
    session_start();
    $conn = DbConn($cfg["servername"],$cfg["username"],$cfg["password"],$cfg["db_name"]);

    if($_SESSION["is_auth"]){
        header('Location: https://alex-mihai.ro/index.html');
    }
    $date = array('response' => 0,'mesaj' => 'A aparut o eroare');
    //VERIFICAM DACA AM PRIMIT SI USERNAME SI PAROLA
    if(isset($_POST["login_username"]) and isset($_POST["login_password"]) and preg_match("^[a-zA-Z0-9]{4,16}$^",$_POST['login_password']) and preg_match("^[a-zA-Z0-9]{4,16}$^",$_POST['login_username'])){

        //VARIABILE PENTRU USERNAME SI PAROLA
        $l_user = $_POST["login_username"];
        $l_password = $_POST["login_password"];

        $date_user = DbReqUser($conn,$l_user);
        if(password_verify($l_password,$date_user["password"])){
            $_SESSION["user_id"] = $date_user["user_id"];
            $_SESSION["username"] = $date_user["username"];
            $_SESSION["nume"] = $date_user["nume"];
            $_SESSION["prenume"] = $date_user["prenume"];
            $_SESSION["grad"] = $date_user["grad"];
            $_SESSION["is_auth"] = true;
            $_SESSION["token"] = get_token();
            $_SESSION["ann_added"] = count(added_ann($conn,$_SESSION["user_id"]));
            $_SESSION["tip"] = $date_user["tip"];
            $date["response"] = 1;
        }else{
            $date["mesaj"] = "Username sau parola gresite";
            $_SESSION["login_error"] = "Username sau parola gresite";
        }
    }else{
        $date["mesaj"] = "Caractere invalide";
        $_SESSION["login_error"] = "Caractere invalide";
    }
    echo json_encode($date,JSON_FORCE_OBJECT);
    $conn = DbClose($conn);
?>  