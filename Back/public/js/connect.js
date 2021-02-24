$(document).ready(function(){
    email();
    password();

/*    $("#login").click(function(e){
        e.preventDefault();
        email();
        password();

        $.post(
            'data/data_processing.php',
            {
                email : $("#email").val(),
                password : $("#password").val() // Il faut crypte le mot de passe
            },
            function(data){
                let berror = 0;
                if(data == 'incorrect'){
                    $('#alert').html('<p class="alert alert-danger" role="alert">Identifiant ou mot de passe incorrect !</p>');
                    berror = 1;
                }
                if(data == 'format'){
                    $('#alert').html('<p class="alert alert-danger" role="alert">Format de l\'email invalide.</p>');
                    berror = 1;
                }
                if (berror == 0) {
                    $( "#sub" ).submit();
                }
            },
            'text'
        );
    });*/

});

function email() {
    $("#email").keyup(function (e) {
        let email = $("#email").val();
        if (email == "") {
            $("#email").css("border", "1px solid #E00000");
            $("#mail").addClass("text-danger mt-1 mb-3").text('Le champ ne peut pas être vide');
        } else {
            $("#mail").text(' ');
            $("#email").css("border", "1px solid #ced4da");
        }
    });
}
function password() {
    $("#password").keyup(function (e) {
        let pass = $("#password").val();
        if (pass == "") {
            $("#password").css("border", "1px solid #E00000");
            $("#pass").addClass("text-danger mt-1 mb-3").text('Le champ ne peut pas être vide');
        } else {
            $("#pass").text(' ');
            $("#password").css("border", "1px solid #ced4da");
        }
    });
}