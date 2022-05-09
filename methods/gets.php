<?php
    error_reporting(0);
    include "../functions/db_methods.php";
    $cfg = include('../cfg/cfg.php');
    session_start();

    if(!$_SESSION["is_auth"]) header('Location: http://alex-mihai.ro/login.php');
    if($_SESSION["token"] !== $_POST["crsf"]) header('Location: http://alex-mihai.ro/methods/logout.php');

    $conn = DbConn($cfg["servername"],$cfg["username"],$cfg["password"],$cfg["db_name"]);

    $action = $_POST["action"];
    if($action == 'meserii'){
        echo json_encode($cfg["meserii"]);
    }elseif($action == 'mesteri_jud'){
        $anunturi = [];
        if(isset($_POST["auto_judet"]) and preg_match("^[A-Z]{1,2}$^",$_POST["auto_judet"])){
            $anunturi = get_anunturi($conn,$_POST["auto_judet"]);
        }
        echo json_encode($anunturi);
    }elseif($action == "get_revs"){
        $reviewuri = [];
        if(isset($_POST["mester_id"]) and preg_match("^[0-9]{1,10}$^",$_POST["mester_id"])){
            $reviewuri = get_revs($conn,$_POST["mester_id"]);
        }
        echo json_encode($reviewuri);
    }

    DbClose($conn);
?>