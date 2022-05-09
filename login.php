<?php
    error_reporting(0);
    session_start();
    if($_SESSION["is_auth"]){
        header('Location: http://alex-mihai.ro/index.html');
        die();
    }

?>

<html>
    <head>
        <link rel="icon" type="image/png" href="poze/hammer.png" />
        <title>Mesterii Manole | Login</title>
        <!-- JQUERY -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <script src="https://kit.fontawesome.com/f1ead0569a.js" crossorigin="anonymous"></script>

        <!-- W3.CSS -->
        <link rel="stylesheet" href="css/w3.css">

        <!-- Un fel de cfg -->
        <script src="cfg/cfg.js" type="text/javascript"></script>

        <!-- IZITOAST -->
        <link rel="stylesheet" href="css/iziToast.min.css">
        <script src="http://alex-mihai.ro/js/iziToast.min.js" type="text/javascript"></script>


        <!-- SOURCE SITE -->
        <link rel="stylesheet" href="css/style.css">
        <script src="http://alex-mihai.ro/js/script_main.js"></script>
    </head>
    <body>
        <div id="main" class="sectiune sectiune_home">
            <div class="w3-bar w3-container">
                <a href="index.html" class="w3-bar-item w3-button w3-round w3-margin-top w3-margin-bottom" style="background-color:#122620 ;color:white;">Home</a>
            </div>
            <div class="w3-container-display">
                <div class="w3-display-middle" style="width: 100% !important;">
                    <div class="w3-row">
                        <div class="w3-col s5 m4 l3" style="margin-left:10%;">
                            <center>
                                <div class="w3-card-4" v-if="login == true">
                                    <div class="w3-bar">
                                        <div href="#" class="w3-bar-item" style="width:50%;background-color:#F4EBD0;border-bottom:2px solid black;" @click="login=true"><h4>Login</h4></div>
                                        <a class="w3-bar-item w3-button" style="width:50%;" @click="login=false"><h4>Register</h4></a>
                                    </div>
                                    <br>
                                    <form id="login_form" name="login_form" class="w3-container">
                                        <div class="w3-row w3-padding">
                                            <div class="w3-col w3-hide-medium w3-hide-small" style="width:50px">
                                                <i class="w3-xxlarge fa fa-user"></i>
                                            </div>
                                            <div class="w3-rest">
                                                <input class="w3-input w3-border w3-white" name="login_username" id="login_username" type="text" placeholder="Username" required>
                                            </div>
                                        </div>
                                        <div class="w3-row w3-padding">
                                            <div class="w3-col w3-hide-medium w3-hide-small" style="width:50px">
                                                <i class="w3-xxlarge fas fa-key"></i>
                                            </div>
                                            <div class="w3-rest">
                                                <input class="w3-input w3-border w3-white" name="login_password" id="login_password" type="password" placeholder="Parola" required>
                                            </div>
                                        </div>
                                    </form>
                                    <br>
                                    <div class="w3-row w3-padding">
                                        <button type="button" @click="click_login()" class="w3-button w3-block" style="background-color:#B68D40">Login</button>
                                    </div>
                                </div>
                                <div class="w3-card-4 w3-round" v-if="login == false">
                                    <div class="w3-bar">
                                        <a href="#" class="w3-bar-item w3-button" style="width:50%;" @click="login=true"><h4>Login</h4></a>
                                        <div class="w3-bar-item" style="width:50%;background-color:#F4EBD0;border-bottom:2px solid black;"><h4>Register</h4></div>
                                    </div>
                                    <br>
                                    <form id="register_form" name="register_form" class="w3-container">
                                        <div class="w3-row w3-padding">
                                            <div class="w3-col w3-hide-medium w3-hide-small" style="width:50px">
                                                <i class="w3-xxlarge fa fa-user"></i>
                                            </div>
                                            <div class="w3-rest">
                                                <input class="w3-input w3-border w3-white" name="register_username" id="register_username" type="text" placeholder="Username" required>
                                            </div>
                                        </div>
                                        <div class="w3-row w3-padding">
                                            <div class="w3-col w3-hide-medium w3-hide-small" style="width:50px">
                                                <i class="w3-xxlarge fas fa-key"></i>
                                            </div>
                                            <div class="w3-rest">
                                                <input class="w3-input w3-border w3-white" name="register_parola" id="register_parola" type="password" placeholder="Parola" required>
                                            </div>
                                        </div>
                                        <div class="w3-row w3-padding">
                                            <div class="w3-col w3-hide-medium w3-hide-small" style="width:50px">
                                            <i class="w3-xxlarge fas fa-newspaper"></i>
                                            </div>
                                            <div class="w3-rest">
                                                <input class="w3-input w3-border w3-white" name="register_nume" id="register_nume" type="text" placeholder="Nume" required>
                                            </div>
                                        </div>
                                        <div class="w3-row w3-padding">
                                            <div class="w3-col w3-hide-medium w3-hide-small" style="width:50px">
                                            <i class="w3-xxlarge fas fa-newspaper"></i>
                                            </div>
                                            <div class="w3-rest">
                                                <input class="w3-input w3-border w3-white" name="register_prenume" id="register_prenume" type="text" placeholder="Prenume" required>
                                            </div>
                                        </div>
                                    </form>
                                    <br>
                                    <div class="w3-row w3-padding">
                                        <button type="button" @click="click_register()" class="w3-button w3-block" style="background-color:#B68D40">Register</button>
                                    </div>
                                </div>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="w3-container" style="background-color: transparent;bottom:10px;position: fixed;width:100%">
            <center><div class="w3-button w3-round" style="font-weight: bold;background-color: #F4EBD0;">Created by Udrescu Alexandru</div></center>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
        <script src="js/login_register.js"></script>
    </body>
</html>