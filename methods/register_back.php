<?php
    include '../functions/db_methods.php';
    $cfg = include('../cfg/cfg.php');
    error_reporting(0);
    session_start();
    $conn = DbConn($cfg["servername"],$cfg["username"],$cfg["password"],$cfg["db_name"]);

    if($_SESSION["is_auth"]){
        header('Location: http://alex-mihai.ro/index.html');
        exit(0);
    }

    $date = array('response' => 0,'mesaj' => 'A aparut o eroare');

    if(isset($_POST["register_username"]) and isset($_POST["register_parola"]) and isset($_POST["register_nume"]) and isset($_POST["register_prenume"]) and preg_match("^[a-zA-Z0-9]{3,20}$^",$_POST['register_username']) and preg_match("^[a-zA-Z0-9]{3,20}$^",$_POST['register_parola']) and preg_match("^[a-zA-Z0-9]{3,20}$^",$_POST['register_nume']) and preg_match("^[a-zA-Z0-9]{3,20}$^",$_POST['register_prenume'])){
        
        //SETEZ TOATE DATELE USERULUI IN ALTE VARIABILE
        $username = $_POST["register_username"];$password=password_hash($_POST["register_parola"],PASSWORD_DEFAULT);$first_name=$_POST["register_nume"];$last_name=$_POST["register_prenume"];
        
        //VERIFIC DACA NU CUMVA EXISTA DEJA ACEST USERNAME ( ESTE FOLOSIT )
        $exista_user = DbAlreadyExist($conn,$username);
        if($exista_user !== true){

            //ADAUG USERUL IN BAZA DE DATE
            $id = DbAddUser($conn,$username,$password,$first_name,$last_name);
            
            $date["response"] = 1;
        }else{  
            $date["mesaj"] = "Acest username este deja folosit";
        }
    }else{
        $date["mesaj"] = "Completeaza toate campurile cu caractere si cifre ( minim 4 maxim 20 )";
    }
    echo json_encode($date,JSON_FORCE_OBJECT);
    $conn = DbClose($conn);
?>  