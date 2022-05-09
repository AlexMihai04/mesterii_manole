$( document ).ready(function() {
    $("#footer").hide();
    $("#main").hide();
    $("#main").fadeIn(1000);
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
        message: 'Selecteaza un judet',
    });
    setTimeout(() => {
        $("#footer").fadeIn(400);
    }, 2150);
});