<?php
    error_reporting(0);
    include "../functions/db_methods.php";
    $cfg = include('../cfg/cfg.php');
    session_start();

    if(!$_SESSION["is_auth"]) header('Location: http://alex-mihai.ro/login.php');
    if($_SESSION["token"] !== $_POST["crsf"]) header('Location: http://alex-mihai.ro/methods/logout.php');


    $conn = DbConn($cfg["servername"],$cfg["username"],$cfg["password"],$cfg["db_name"]);

    $action = $_POST["action"];

    if($action == 'add_rev'){
        $resp = array('response' => 0,'mesaj' => 'A aparut o eroare');
        if(isset($_POST["stele"]) and preg_match("^[1-5]{1,1}$^",$_POST["stele"])){
            if(isset($_POST["parere"]) and preg_match("^[A-Za-z0-9]{1,150}$^",$_POST["parere"])){
                if(isset($_POST["pentru"]) and preg_match("^[0-9]{1,10}$^",$_POST["pentru"])){
                    if(added_rew($conn,$_SESSION["user_id"],$_POST["pentru"])){
                        if($_POST["pentru"] == $_SESSION["user_id"]){
                            $resp["mesaj"] = 'Nu iti poti adauga singur un review :(';
                        }else{
                            if(add_rev($conn,$_POST["pentru"],$_SESSION["user_id"],$_POST["stele"],$_POST["parere"])){
                                $resp["mesaj"] = "Review adaugat cu succes !";
                                $resp["response"] = 1;
                            }else{
                                $resp["mesaj"] = "Intampinam probleme cu baza de date , te rog sa revii mai tarziu !";
                            }
                        }
                    }else{
                        $resp["mesaj"] = "Ai adaugat deja un review acestei persoane !";
                    }
                }
            }else{
                $resp["mesaj"] = "Caractere invalide sau numar de caracter depasit.\nLimita caractere : 150\nCaractere permise : A-Z";
            }
        }else{
            $resp['mesaj'] = 'A aparut o problema la numarul de stele oferit';
        }
        
        echo json_encode($resp);
    }elseif($action == 'add_anunt'){
        $resp = array('response' => 0,'mesaj' => 'A aparut o eroare');
        if(isset($_POST["nume"]) and preg_match("^[A-Za-z]{1,20}$^",$_POST["nume"])){
            if(isset($_POST["prenume"]) and preg_match("^[A-Za-z]{1,20}$^",$_POST["prenume"])){
                if(isset($_POST["telefon"]) and preg_match("^[0-9]{10}$^",$_POST["telefon"])){
                    if(isset($_POST["auto_judet"]) and preg_match("^[A-Z]{1,2}$^",$_POST["auto_judet"])){
                        $cfg_m = include('../cfg/meserii.php');
                        $l = true;
                        foreach ($_POST["profesii"] as $key => $value) {
                            $k = false;
                            foreach ($cfg_m as $key_p => $value_p) {
                                if($value == $value_p){
                                    $k = true;
                                }
                            }
                            if($k == false){
                                $l = false;
                            }
                        }
                        
                        if($l){
                            add_anunt($conn,$_SESSION["user_id"],json_encode($_POST["profesii"]),$_POST["telefon"],$_POST["auto_judet"],$_POST["nume"],$_POST["prenume"]);
                            $resp['response'] = 1;
                            $resp['mesaj'] = 'Ai adaugat anuntul cu succes !';
                            $_SESSION["ann_added"] = count(added_ann($conn,$_SESSION["user_id"]));
                        }else{
                           
                            $resp["mesaj"] = "Una dintre meseriile alese de tine nu functioneaza , te rog incearca din nou !";
                        }
                        
                    }else{
                        $resp["mesaj"] = "Judetul tau are o problema in acest moment , incearca mai tarziu te rog !";
                    }
                }else{
                    $resp["mesaj"] = "Sunt permise doar numere de telefon Romanesti !\nExemplu numar de telefon : 0711111122";
                }
            }else{
                $resp["mesaj"] = "Prenumele introdus de tine este prea lung sau contine caractere nepermise !\nCaractere permise: A-Z,a-z\nLimita caractere : 20";
            }
        }else{
            $resp["mesaj"] = "Numele introdus de tine este prea lung sau contine caractere nepermise !\nCaractere permise: A-Z,a-z\nLimita caractere : 20";
        }
        
        echo json_encode($resp);
    }elseif($action == 'delete_anunt'){
        
        $resp = array('response' => 0,'mesaj' => 'A aparut o eroare !');
        if(isset($_POST["id_anunt"]) and preg_match("^[0-9]{1,10}$^",$_POST["id_anunt"]) and own_ann($conn,$_POST["id_anunt"],$_SESSION["user_id"])){
            delete_anunt($conn,$_POST["id_anunt"]);
            $resp['response'] = 1;
            $resp['mesaj'] = 'Anunt sters cu succes !';
            $_SESSION["ann_added"] = count(added_ann($conn,$_SESSION["user_id"]));
        }
        echo json_encode($resp);
        
    }elseif($action == 'delete_anunt_a' and $_SESSION["grad"] == 'admin'){
        
        delete_anunt($conn,$_POST["id_anunt"]);
        $resp = array('response' => 1,'mesaj' => 'Anunt sters cu succes !');
        
        echo json_encode($resp);
    }elseif($action == 'delete_rev_a' and $_SESSION["grad"] == 'admin'){
        
        delete_review($conn,$_POST["id_rev"]);
        $resp = array('response' => 1,'mesaj' => 'Review sters cu succes !');
        echo json_encode($resp);
    }
    $conn = DbClose($conn);
?>
