var app = new Vue({
    el: '#main',
    data: {
        login:true,
    },
    methods: {
        click_login(){
            var date = $("#login_form").serializeArray();
            console.log(date);
            $.ajax({
                type:"POST",
                crossOrigin: true,
                url:get_domeniu() + "/methods/login_back.php",
                data:{
                    'login_username' : date[0].value,
                    'login_password' : date[1].value
                },
                success:function (data)
                {
                    data = JSON.parse(data);
                    if(data.response == 1){
                        window.location.href = "index.html";
                    }else{
                        iziToast.error({
                            timeout:2000,
                            transitionIn: 'flipInX',
                            transitionOut: 'flipOutX',
                            color:"white",
                            closeOnClick:true,
                            backgroundColor:'#122620',
                            iconColor: '#B68D40',
                            theme:'dark',
                            position:"bottomCenter",
                            progressBarColor:'#B68D40',
                            message: data.mesaj,
                        });
                    }
                }
            })
        },
        click_register(){
            var date = $("#register_form").serializeArray();
            $.ajax({
                type:"POST",
                crossOrigin: true,
                url:get_domeniu() + "/methods/register_back.php",
                data:{
                    'register_username' : date[0].value,
                    'register_parola' : date[1].value,
                    'register_nume' : date[2].value,
                    'register_prenume' : date[3].value
                },
                success:function (data)
                {
                    if(data != "" && data != " "){
                        data = JSON.parse(data);
                        if(data.response == 1){
                            iziToast.warning({
                                timeout:2000,
                                transitionIn: 'flipInX',
                                transitionOut: 'flipOutX',
                                color:"white",
                                closeOnClick:true,
                                backgroundColor:'#122620',
                                icon:'fas fa-check-circle',
                                iconColor: '#B68D40',
                                theme:'dark',
                                position:"bottomCenter",
                                progressBarColor:'#B68D40',
                                message: 'Te-ai inregistrat cu success, acum te poti loga',
                            });
                            app.login = true;
                        }else{
                            iziToast.error({
                                timeout:2500,
                                transitionIn: 'flipInX',
                                transitionOut: 'flipOutX',
                                color:"white",
                                closeOnClick:true,
                                backgroundColor:'#122620',
                                iconColor: '#B68D40',
                                theme:'dark',
                                position:"bottomCenter",
                                progressBarColor:'#B68D40',
                                message: data.mesaj,
                            });
                        }
                    }else{
                        iziToast.warning({
                            timeout:2000,
                            transitionIn: 'flipInX',
                            transitionOut: 'flipOutX',
                            color:"white",
                            closeOnClick:true,
                            backgroundColor:'#122620',
                            icon:'fas fa-check-circle',
                            iconColor: '#B68D40',
                            theme:'dark',
                            position:"bottomCenter",
                            progressBarColor:'#B68D40',
                            message: 'Te-ai inregistrat cu success, acum te poti loga',
                        });
                        app.login = true;
                    }
                }
            })
        }
    }
})
