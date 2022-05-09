<?php
    error_reporting(0);
    session_start();
    if(!$_SESSION["is_auth"]){
        header('Location: http://alex-mihai.ro/login.php');
    }
?>

<html>
    <head>
        <link rel="icon" type="image/png" href="poze/hammer.png" />
        <title>Mesterii Manole | Cauta un meserias</title>
        <!-- JQUERY -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


        <script src="https://kit.fontawesome.com/f1ead0569a.js" crossorigin="anonymous"></script>


        <!-- Un fel de cfg -->
        <script src="cfg/cfg.js" type="text/javascript"></script>

        <!-- W3.CSS -->
        <link rel="stylesheet" href="css/w3.css">

        <!-- IZITOAST -->
        <link rel="stylesheet" href="css/iziToast.min.css">
        <script src="js/iziToast.min.js" type="text/javascript"></script>

        <!-- SOURCE SITE -->
        <link rel="stylesheet" href="css/search.css">
    </head>
    <body>
        <div id="main" class="sectiune">
            <div class="w3-bar w3-container">
                <a href="index.html" class="w3-bar-item w3-button w3-round w3-margin-top w3-margin-bottom w3-animate-top" style="background-color:#122620 ;color:white;">Home</a>
                <!-- <a href="#" class="w3-bar-item w3-button w3-round w3-margin-top w3-margin-bottom w3-margin-left w3-animate-top"  style="background-color:#122620 ;color:white;">Echipa</a> -->
                <?php
                    if($_SESSION["is_auth"]){
                ?>
                    <a href="methods/logout.php" class="w3-bar-item w3-button w3-round w3-right w3-margin-top w3-margin-bottom w3-animate-right" style="background-color:#B68D40 ;color:white;">Log-out</a>
                <?php
                    }else{
                ?>
                    <a href="login.php" class="w3-bar-item w3-button w3-round w3-right w3-margin-top w3-margin-bottom" style="background-color:#B68D40 ;color:white;">Log-in</a>
                <?php
                    }
                ?>
            </div>
            <div v-if="actiune == 'select'">
                <div class="w3-container w3-margin-top" v-if="selected == -1 && loading == false">
                    <div class="w3-row">
                        <a v-for="(data,index) in judete" href="#" @click="load_anunturi(index)" class="w3-col s12 m6 l3 w3-padding w3-animate-bottom" style="max-height: 100px;">
                            <div class="w3-card-4 button_select" style="background-image: url('poze/bg_judet.png');">
                                <div class="w3-container w3-margin">
                                    <div class="w3-col m3 l3 s3" >
                                        <h1>{{data.auto}}</h1>
                                    </div>
                                    <div class="w3-col m9 l9 s9" style="margin:auto;" style="position: fixed;">
                                        <p>Judet <br>{{data.nume}}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="w3-container w3-margin-top" v-if="selected > -1 && loading == false">
                    <div class="w3-row w3-margin-bottom">
                        <button class="w3-button w3-red w3-round" @click="selected = -1;mesteri = []">Inapoi</button>
                        <?php
                        if($_SESSION["tip"] == 'intreprindere'){
                        ?> 
                            <button class="w3-button w3-round" style="background-color:rgb(244, 235, 208)" @click="tip_cont('intreprindere')">Anunturi ramase : nelimitat (cont de intreprindere)</button>
                        <?php
                        }else{
                        ?>  
                            <button class="w3-button w3-round" style="background-color:rgb(244, 235, 208)" @click="tip_cont('normal')">Anunturi ramase : <?php echo 1-$_SESSION["ann_added"];?></button>
                        <?php
                        }   
                        ?>
                    </div>
                    <ul class="w3-ul w3-card-4 w3-margin-bottom tts:down w3-animate-left" style="width:100%;" aria-label="Click !" v-for="(data,index) in mesteri">
                        <template v-if="'<?php echo $_SESSION['grad']; ?>' == 'admin' || '<?php echo $_SESSION['user_id'];?>' == data.added_by">
                            <li class="w3-bar per_judet">
                                <div class="w3-bar-item">
                                    <button class="w3-button w3-red w3-small w3-round w3-animate-left" v-if="'<?php echo $_SESSION['grad']; ?>' == 'admin'" @click = "delete_anunt_a(data.id,index)">Sterge anunt ADMIN</button>
                                    <button class="w3-button w3-red w3-small w3-round w3-animate-left" v-if="'<?php echo $_SESSION['user_id'];?>' == data.added_by" @click = "delete_anunt(data.id,index)">Sterge anunt</button>
                                </div>    
                            </li>
                        </template>
                        <li class="w3-bar per_judet">
                            <img src="poze/drill.png" class="w3-bar-item" style="width:85px">
                            <div class="w3-bar-item">
                                <span class="w3-large">Nume : {{data.nume}} {{data.prenume}}</span>
                                <br>
                                Stele : <span style="color:orange" class="fa fa-star" v-for="n in parseInt(data.rev_rate)"></span><span style="color:grey" class="fa fa-star" v-for="n in 5-parseInt(data.rev_rate)"></span></span>
                                <!-- Stele : <span style="color:orange" class="fa fa-star" v-for="n in parseInt(data.rep)"></span><span style="color:grey" class="fa fa-star" v-for="n in 5-parseInt(data.rep)"></span> -->
                            </div>    
                        </li>
                        <li class="w3-bar per_judet">
                            <div class="w3-bar-item">
                                <!-- <span >4/5 <i style="color:orange" class="fas fa-star"></i></span> -->
                                <a href="#" class="w3-tag buton_telefon">{{data.telefon}}</a>
                            </div>    
                            <div class="w3-bar-item">
                                <template v-for="(mes,index) in data.meserie"><span class="w3-tag" style="background-color:#F4EBD0;color:black;border-radius:3px;">{{mes}}</span>&nbsp</template>
                            </div>
                            <div class="w3-bar-item w3-right">
                                <button class="w3-button w3-small w3-round" style="background-color: rgb(182, 141, 64); color: white;" @click = "open_revs(data)" :disabled="data.rev_rate == 0">Vezi reviewuri ({{data.rev_list.length}})</button>
                                <button class="w3-button w3-green w3-small w3-round" @click = "rev_for=data.added_by;modal ='add_rev'">Adauga review</button>
                            </div>
                        </li>
                    </ul>
                    <?php
                        if($_SESSION["is_auth"]){
                    ?>
                    <div style="bottom:10px;position: fixed;width:100%">
                        <div class="w3-col s1 l1 m1">
                            <div class="w3-button w3-xlarge" @click="modal = 'anunt'" style="background-color:#122620;border-radius : 50%;color:white;">+</div>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                    <template v-if="modal == 'add_rev'">
                        <div class="w3-modal" style="display:block;">
                            <div class="w3-modal-content w3-card-4">
                                <div class="w3-bar">
                                    <div href="#" class="w3-bar-item" style="display:right">
                                        <button class="w3-button w3-red w3-round" @click="modal = false">&times</button>
                                    </div>
                                    <form id="rev_form" name="rev_form" class="w3-container">
                                        <br>
                                        <div class="w3-row w3-padding">
                                            <div class="w3-col w3-hide-medium w3-hide-small" style="width:50px">
                                                <i class="w3-xxlarge fa fa-comments"></i>
                                            </div>
                                            <div class="w3-rest">
                                                <input class="w3-input w3-border w3-white" name="rev_parere" id="rev_parere" type="text" placeholder="Parerea ta" required>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="w3-row w3-padding">
                                            <div class="w3-rest">
                                                <template v-if="star_given == -1">
                                                    <span style="color:grey" class="fa fa-star w3-large" v-for="n in 5" @click="star_given = n"></span>
                                                </template>
                                                <template v-if="star_given > 0">
                                                    <span style="color:orange" class="fa fa-star w3-large" v-for="w in parseInt(star_given)" @click="star_given = w"></span><span style="color:grey" class="fa fa-star" v-for="j in 5-parseInt(star_given)" @click="star_given += j"></span></span>
                                                </template>
                                            </div>
                                        </div>
                                    </form>
                                    <br>
                                    <div class="w3-row w3-padding">
                                        <button type="button" @click="add_review()" class="w3-round w3-button w3-green w3-block">Adauga review</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template v-if="modal == 'anunt'">
                        <div class="w3-modal" style="display:block;">
                            <div class="w3-modal-content w3-card-4">
                                <div class="w3-bar">
                                    <div href="#" class="w3-bar-item" style="display:right">
                                        <button class="w3-button w3-red w3-round" @click="modal = false">&times</button>
                                    </div>
                                    <form id="anunt_form" name="anunt_form" class="w3-container">
                                        <br>
                                        <div class="w3-row w3-padding">
                                            <div class="w3-col w3-hide-medium w3-hide-small" style="width:50px">
                                                <i class="w3-xxlarge fa fa-user"></i>
                                            </div>
                                            <div class="w3-rest">
                                                <input class="w3-input w3-border w3-white" name="anunt_nume" id="anunt_nume" type="text" placeholder="Nume" required>
                                            </div>
                                        </div>
                                        <div class="w3-row w3-padding">
                                            <div class="w3-col w3-hide-medium w3-hide-small" style="width:50px">
                                                <i class="w3-xxlarge fa fa-user"></i>
                                            </div>
                                            <div class="w3-rest">
                                                <input class="w3-input w3-border w3-white" name="anunt_prenume" id="anunt_prenume" type="text" placeholder="Prenume" required>
                                            </div>
                                        </div>
                                        <div class="w3-row w3-padding">
                                            <div class="w3-col w3-hide-medium w3-hide-small" style="width:50px">
                                                <i class="w3-xxlarge fas fa-phone"></i>
                                            </div>
                                            <div class="w3-rest">
                                                <input class="w3-input w3-border w3-white" name="anunt_telefon" id="anunt_telefon" type="number" placeholder="Telefon" required>
                                                <!-- <input type="checkbox" checked /> -->
                                            </div>
                                        </div>
                                        <div class="w3-row w3-padding">
                                            <template v-for="(meserie,index) in meserii">
                                                <input class="w3-check" type="checkbox" @click="selected_for_add[meserie] = !selected_for_add[meserie]">
                                                <label>{{meserie}}</label>
                                                &nbsp
                                            </template>
                                        </div>
                                    </form>
                                    <br>
                                    <div class="w3-row w3-padding">
                                        <button type="button" @click="register_anunt()" class="w3-round w3-button w3-block" style="background-color:#B68D40">Adauga anunt</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template v-if="modal=='revs'">
                        <div class="w3-modal" style="display:block;">
                            <div class="w3-modal-content w3-card-4">
                                <div class="w3-bar">
                                    <div href="#" class="w3-bar-item" style="display:right">
                                        <button class="w3-button w3-red w3-round w3-animate-left" @click="modal = false;rev_page = 1">&times</button>
                                        <button class="w3-button w3-green w3-round w3-animate-top" v-if="rev_page > 1" @click="rev_page = rev_page - 1">Prev page</button>
                                        <button class="w3-button w3-green w3-round w3-animate-top" v-if="rev_page*3 < rev_list.length"@click="rev_page = rev_page + 1">Next page</button>
                                    </div>
                                    <div class="w3-container">
                                        <br>
                                        <ul class="w3-ul w3-card-4 w3-margin-bottom tts:down" style="width:100%;" v-for="(value,index) in rev_list">
                                            <li v-if="index+1 > (rev_page-1) * 3 && index+1 <= rev_page*3"class="w3-bar per_judet">
                                                <img src="poze/star.png" class="w3-bar-item" style="width:85px">
                                                <div class="w3-bar-item">
                                                    <span class="w3-large">Stele : <span style="color:orange" class="fa fa-star" v-for="n in parseInt(value.stele)"></span><span style="color:grey" class="fa fa-star" v-for="n in 5-parseInt(value.stele)"></span></span>
                                                    <br>
                                                    <span class="w3-large">Mesaj : {{value.mesaj}}</span>
                                                </div>   
                                                <?php
                                                    if($_SESSION["grad"] == 'admin'){
                                                ?>
                                                    <div class="w3-bar-item w3-right">
                                                        <button class="w3-button w3-red w3-round w3-right w3-animate-right" @click="delete_rev_a(value.id)">Sterge review</button>
                                                    </div> 
                                                <?php
                                                    }
                                                ?>
                                            </li>
                                        </ul>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
            <div class="w3-container w3-container-display" v-if="loading == true">
                    <div class="w3-display-middle">
                        <div id="preload">
                            <div class="sk-folding-cube">
                                <div class="sk-cube1 sk-cube"></div>
                                <div class="sk-cube2 sk-cube"></div>
                                <div class="sk-cube4 sk-cube"></div>
                                <div class="sk-cube3 sk-cube"></div>
                            </div> 
                        </div>
                    </div>
                </div>
            <input type="hidden" id="crsf" name="crsf" value="<?php echo $_SESSION['token']; ?>">
        </div>
        <script src="js/vue.min.js"></script>
        <script src="js/search.js"></script>
    </body>
</html>