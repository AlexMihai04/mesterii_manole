var app = new Vue({
    el: '#main',
    data: {
        mesteri:[],
        judete: [{"auto":"AB","nume":"Alba"},{"auto":"AR","nume":"Arad"},{"auto":"AG","nume":"Arges"},{"auto":"BC","nume":"Bacau"},{"auto":"BH","nume":"Bihor"},{"auto":"BN","nume":"Bistrita-Nasaud"},{"auto":"BT","nume":"Botosani"},{"auto":"BR","nume":"Braila"},{"auto":"BV","nume":"Brasov"},{"auto":"B","nume":"Bucuresti"},{"auto":"BZ","nume":"Buzau"},{"auto":"CL","nume":"Calarasi"},{"auto":"CS","nume":"Caras-Severin"},{"auto":"CJ","nume":"Cluj"},{"auto":"CT","nume":"Constanta"},{"auto":"CV","nume":"Covasna"},{"auto":"DB","nume":"Dambovita"},{"auto":"DJ","nume":"Dolj"},{"auto":"GL","nume":"Galati"},{"auto":"GR","nume":"Giurgiu"},{"auto":"GJ","nume":"Gorj"},{"auto":"HR","nume":"Harghita"},{"auto":"HD","nume":"Hunedoara"},{"auto":"IL","nume":"Ialomita"},{"auto":"IS","nume":"Iasi"},{"auto":"IF","nume":"Ilfov"},{"auto":"MM","nume":"Maramures"},{"auto":"MH","nume":"Mehedinti"},{"auto":"MS","nume":"Mures"},{"auto":"NT","nume":"Neamt"},{"auto":"OT","nume":"Olt"},{"auto":"PH","nume":"Prahova"},{"auto":"SJ","nume":"Salaj"},{"auto":"SM","nume":"Satu Mare"},{"auto":"SB","nume":"Sibiu"},{"auto":"SV","nume":"Suceava"},{"auto":"TR","nume":"Teleorman"},{"auto":"TM","nume":"Timis"},{"auto":"TL","nume":"Tulcea"},{"auto":"VL","nume":"Valcea"},{"auto":"VS","nume":"Vaslui"},{"auto":"VN","nume":"Vrancea"}],
        selected : -1,
        actiune : 'select',
        reviewuri:[],
        om_selected:-1,
        modal:false,
        meserii : [],
        selected_for_add:[],
        rev_page :1,
        rev_list : [],
        loading : false,
        rev_for:-1,
        star_given : -1
    },
    methods: {
        load_anunturi(index){
            this.loading = true;
            this.selected = index;
            $.ajax({
                type:"POST",
                crossOrigin: true,
                url:get_domeniu() + "/methods/gets.php",
                data:{
                    'crsf':$('#crsf').val(),
                    'action':'mesteri_jud',
                    'auto_judet' : app.judete[index].auto
                },
                success:function (data)
                {
                    app.mesteri=JSON.parse(data);
                    if(app.mesteri.length == 0){
                        setTimeout(() => {
                            app.loading = false;
                        }, 500); 
                    }else{
                        for(var i = 0;i<app.mesteri.length;i++){
                            app.mesteri[i].meserie = JSON.parse(app.mesteri[i].meserie);
                            if(i == app.mesteri.length - 1){
                                app.load_rev(i,true);
                            }else{
                                app.load_rev(i,false);
                            }
                        }
                    }
                }
            })
        },
        load_rev(i,nd){
            $.ajax({
                type:"POST",
                crossOrigin: true,
                url:get_domeniu() + "/methods/gets.php",
                data:{
                    'crsf':$('#crsf').val(),
                    'action':'get_revs',
                    'mester_id' : app.mesteri[i].added_by
                },
                success:function (data)
                {
                    app.mesteri[i].rev_list = JSON.parse(data);
                    if(app.mesteri[i].rev_list.length > 0){
                        app.rev_list = app.mesteri[i].rev_list;
                        var sum = 0;
                        for(var j = 0;j<app.mesteri[i].rev_list.length;j++){
                            sum+=parseInt(app.mesteri[i].rev_list[j].stele);
                        }
                        app.mesteri[i].rev_rate = Math.round(sum/app.mesteri[i].rev_list.length);
                    }else{
                        app.mesteri[i].rev_rate = 0;
                    }
                    if(nd == true){
                        setTimeout(() => {
                            app.loading = false;
                        }, 500);
                    }
                }
            })
        },
        tip_cont(tip){
            if(tip == 'intreprindere'){
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
                    message: "Ai anunturi nelimitate ! Detii un cont de intreprindere !"
                });
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
                    message: "Intreprinderile beneficiaza de anunturi nelimitate !\nDaca detii o intreprindere si iti dorest sa ai anunturi nelimitate , ne poti contacta pe email-ul : udrescualexandrumihai@gmail.com"
                });

            }
        },
        delete_anunt(id_anunt,index){
            $.ajax({
                type:"POST",
                crossOrigin: true,
                url:get_domeniu() + "/methods/posts.php",
                data:{
                    'crsf':$('#crsf').val(),
                    'action':'delete_anunt',
                    'id_anunt':id_anunt
                },
                success:function (data)
                {
                    data=  JSON.parse(data);
                    if(data.response == 0){
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
                            message: data.mesaj
                        });
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
                            message: data.mesaj
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 300);
                    }
                }
            })
        },
        delete_anunt_a(id_anunt,index){
            $.ajax({
                type:"POST",
                crossOrigin: true,
                url:get_domeniu() + "/methods/posts.php",
                data:{
                    'crsf':$('#crsf').val(),
                    'action':'delete_anunt_a',
                    'id_anunt':id_anunt
                },
                success:function (data)
                {
                    data=  JSON.parse(data);
                    if(data.response == 0){
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
                            message: data.mesaj
                        });
                    }else{
                        app.mesteri.splice(index.index);
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
                            message: data.mesaj
                        });
                    }
                }
            })
        },
        delete_rev_a(id_rev){
            console.log(id_rev);
            $.ajax({
                type:"POST",
                crossOrigin: true,
                url:get_domeniu() + "/methods/posts.php",
                data:{
                    'crsf':$('#crsf').val(),
                    'action':'delete_rev_a',
                    'id_rev':id_rev
                },
                success:function (data)
                {
                    data=  JSON.parse(data);
                    if(data.response == 0){
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
                            message: data.mesaj
                        });
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
                            message: data.mesaj
                        });
                    }
                }
            })
        },
        register_anunt(){
            if(app.calculate_selected()){
                var form_d = $("#anunt_form").serializeArray();
                var meserii = [];
                for(const meserie in this.selected_for_add){
                    if(this.selected_for_add[meserie]){
                        meserii.push(meserie);
                    }
                }
                $.ajax({
                    type:"POST",
                    crossOrigin: true,
                    url:get_domeniu() + "/methods/posts.php",
                    data:{
                        'crsf':$('#crsf').val(),
                        'action':'add_anunt',
                        'nume':form_d[0].value,
                        'prenume':form_d[1].value,
                        'telefon' : form_d[2].value,
                        'profesii': meserii,
                        'auto_judet':app.judete[app.selected].auto
                    },
                    success:function (data)
                    {
                        data=  JSON.parse(data);
                        if(data.response == 0){
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
                                message: data.mesaj
                            });
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
                                message: data.mesaj
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 500);
                        }
                    }
                })
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
                    message: "Trebuie sa alegi minim o meserie !"
                });
            }
        },
        calculate_selected(){
            var a = false;
            for(const meserie in this.selected_for_add){
                if(this.selected_for_add[meserie]){
                    a = true;
                    break;
                }
            }
            return a;
        },
        open_revs(data){
            app.rev_list = data.rev_list;
            app.modal = 'revs';
        },
        add_review(){
            var form_d = $("#rev_form").serializeArray();
            if(this.star_given == -1){
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
                    message: "Trebuie sa oferi un numar de stele !"
                });
            }else if(form_d[0].value == '' || form_d[0].value == ' ' || !form_d[0].value){
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
                    message: "Trebuie sa iti pui parerea !"
                });
            }else{
                $.ajax({
                    type:"POST",
                    crossOrigin: true,
                    url:get_domeniu() + "/methods/posts.php",
                    data:{
                        'crsf':$('#crsf').val(),
                        'action':'add_rev',
                        'stele':app.star_given,
                        'pentru':app.rev_for,
                        'parere' : form_d[0].value
                    },
                    success:function (data)
                    {
                        data=  JSON.parse(data);
                        if(data.response == 0){
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
                                message: data.mesaj
                            });
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
                                message: data.mesaj
                            });
                        }
                    }
                })
            }
        }
    }
})



$( document ).ready(function() {
    $.ajax({
        type:"POST",
        crossOrigin: true,
        url:get_domeniu() + "/methods/gets.php",
        data:{
            'crsf':$('#crsf').val(),
            'action':'meserii'
        },
        success:function (data)
        {
            app.meserii = JSON.parse(data);
        }
    })
});