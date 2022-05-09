<?php
    //functie pentru a ma conecta la baza de date
    function DbConn($servername,$username,$password,$db_name)
    {
        $conn = new PDO("mysql:host=$servername;dbname=$db_name", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    }

    //functie pentru a da drop la conexiunea de la baza de date
    function DbClose($conn)
    {
        $conn = null;
        return $conn;
    }

    function get_anunturi($conn,$auto_judet){
        $stmt = $conn->prepare('SELECT * FROM anunturi WHERE auto_judet = :auto_judet');
        $stmt->execute(['auto_judet' => $auto_judet]);
        $date = $stmt->fetchAll();
        return $date;
        $stmt->close;
    }

    function get_revs($conn,$id_to_get){
        $stmt = $conn->prepare('SELECT * FROM review WHERE pentru = :id_to');
        $stmt->execute(['id_to' => $id_to_get]);
        $date = $stmt->fetchAll();
        return $date;
        $stmt->close;
    }

    function add_rev($conn,$id_to,$id_from,$stele,$parere){
        $stmt = $conn->prepare("INSERT INTO review(de_la,mesaj,stele,pentru) VALUES(:de_la,:mesaj,:stele,:pentru)");
        if($stmt->execute(['de_la'=>$id_from,'mesaj'=>$parere,'stele'=>$stele,'pentru'=>$id_to])){
            return true;
        }else{
            return false;
        }
        $stmt->close;
    }

    function add_anunt($conn,$added_by,$meserie,$telefon,$auto_judet,$nume,$prenume){
        $stmt = $conn->prepare("INSERT INTO anunturi(added_by,meserie,telefon,auto_judet,nume,prenume) VALUES(:added_by,:meserie,:telefon,:auto_judet,:nume,:prenume)");
        if($stmt->execute(['added_by'=>$added_by,'meserie'=>$meserie,'telefon'=>$telefon,'auto_judet'=>$auto_judet,'nume'=>$nume,'prenume'=>$prenume])){
            return true;
        }else{
            return false;
        }
        $stmt->close;
    }
    function added_ann($conn,$by){
        $stmt = $conn->prepare('SELECT * FROM anunturi WHERE added_by = :by');
        $stmt->execute(['by' => $by]);
        $date = $stmt->fetchAll();
        return $date;
        $stmt->close;
    }
    function added_rew($conn,$from,$to){
        $stmt = $conn->prepare('SELECT * FROM review WHERE de_la = :de_la AND pentru = :pentru');
        $stmt->execute(['de_la' => $from,'pentru' => $to]);
        $date = $stmt->fetchAll();
        if(count($date) == 0){
            return true;
        }else{
            return false;
        }
        $stmt->close;
    }
    function own_ann($conn,$id_a,$id_p){
        $stmt = $conn->prepare('SELECT * FROM anunturi WHERE added_by = :id_p AND id = :id_a');
        $stmt->execute(['id_p' => $id_p,'id_a'=>$id_a]);
        $date = $stmt->fetchAll();
        if(count($date) == 0){
            return false;
        }else{
            return true;
        }
        $stmt->close;
    }
    function delete_anunt($conn,$a_id)
    {
        $stmt = $conn->prepare('DELETE FROM anunturi WHERE id = :a_id');
        $stmt->execute(['a_id' => $a_id]);
        $stmt->close;
    }

    function delete_review($conn,$r_id)
    {
        $stmt = $conn->prepare('DELETE FROM review WHERE id = :r_id');
        $stmt->execute(['r_id' => $r_id]);
        $stmt->close;
    }

    function DbReqUser($conn,$username)
    {
        $stmt = $conn->prepare('SELECT * FROM conturi WHERE username = :username');
        $stmt->execute(['username'=>$username]);
        $date = $stmt->fetch(PDO::FETCH_ASSOC);
        return $date;
        $stmt->close;
    }

    function DbAlreadyExist($conn,$username)
    {
        $exists = $conn->query('SELECT * FROM conturi WHERE username = "'.$username.'"')->fetchColumn();
        if($exists){
            return true;
        }else{
            return false;
        }
    }

    function DbAddUser($conn,$username,$password,$first_name,$last_name)
    {
        $stmt = $conn->prepare("INSERT INTO conturi(username,password,nume,prenume) VALUES(:username,:password,:nume,:prenume)");
        $stmt->execute(['username'=>$username,'password'=>$password,'nume'=>$first_name,'prenume'=>$last_name]);
        $date = $stmt->lastInsertId();
        return $date;
        $stmt->close;
    }
?>