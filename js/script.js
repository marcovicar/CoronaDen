$(document).ready(function() {

    $("#btnBusca").click(function() {
        var termo = $("#buscarDenuncia").val();

        if (termo.length >= 3) {
            document.location.href = "?pagina=geral&termo=" + termo;
        } else {
            alert("Informe pelo menos três(3) caracteres");
        }
    });
});