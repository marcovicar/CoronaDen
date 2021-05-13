<?php
session_start();

require_once("Controller/DenunciaController.php");
require_once("Model/ViewModel/DenunciaConsulta.php");

$urlDF = "https://covid19-brazil-api.now.sh/api/report/v1/brazil/uf/df";

$casosDF = json_decode(file_get_contents($urlDF));

$denunciaController = new DenunciaController();

$listaUltimasDenunciasLateral = $denunciaController->RetornarUltimasDenuncias(5);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>CoronaDen - Index</title>
  <meta content="" name="descriptison">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="img/logoCovid.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- JS -->
  <script src="js/script.js" type="text/javascript"></script>

  <script src="js/jquery-3.1.1.min.js" type="text/javascript"></script>
  <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  <link href="css/style.css" rel="stylesheet" type="text/css">


  <!-- =======================================================
  * Template Name: Tempo - v2.1.0
  * Template URL: https://bootstrapmade.com/tempo-free-onepage-bootstrap-theme/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center">

      <h1><a href="index.php?pagina=conteudo"><img id="logoCoronaDen" src="img/LogoPrincipal.png" /></a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.php" class="logo mr-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li class="active"><a href="index.php?pagina=conteudo">Home</a></li>
          <li><a href="?pagina=denuncia">Denúncias</a></li>
          <li><a href="?pagina=localizacao">Localizações</a></li>
          <?php
          if (!isset($_SESSION["idusuario"])) {
          ?>
            <li><a href="?pagina=entrar">Entrar</a></li>
            <li><a href="?pagina=usuario">Cadastrar</a></li>
          <?php
          }
          ?>
          <?php
          if (isset($_SESSION["idusuario"])) {
          ?>
            <li><a href="?pagina=contato">Contato</a></li>
            <li id="usuarioNome">Olá, <?= ($_SESSION["nome"]); ?></li>
            <li><a href="?pagina=painel">Painel</a></li>
            <li><a href="logout.php" id="logout">Sair</a></li>
          <?php
          }
          ?>

        </ul>
      </nav><!-- .nav-menu -->

    </div>
  </header><!-- End Header -->



  <main id="main">

    <?php
    require_once("Util/RequestPageSite.php");
    ?>


    <br />
    <br />
    <br />
    <br />
    <br />
    <!-- ======= Footer ======= -->
    <footer id="footer">

      <div class="footer-top">
        <div class="container">
          <div class="row">

            <div class="col-lg-3 col-md-6 footer-contact">
              <h3>CoronaDen</h3>
              <p><b>TeleCovid: </b>Pessoas que querem sanar dúvidas e procurar orientações sobre a COVID-19, podem ligar nos telefones: <b>190, 193 e 199</b>.</p>
            </div>

            <div class="col-lg-2 col-md-6 footer-links">
              <h4>Links Úteis</h4>
              <ul>
                <li><i class="bx bx-chevron-right"></i> <a href="?pagina=conteudo">Home</a></li>
                <li><i class="bx bx-chevron-right"></i> <a href="?pagina=denuncia">Denúncias</a></li>
                <li><i class="bx bx-chevron-right"></i> <a href="?pagina=termodeuso">Termos de Uso</a></li>
                <li><i class="bx bx-chevron-right"></i> <a href="?pagina=politicas">Politica de Privacidade</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <div class="container d-md-flex py-4">

        <div class="mr-md-auto text-center text-md-left">
          <div class="copyright">
            &copy; Copyright <strong><span>CoronaDen</span></strong>. Todos os direitos reservados
          </div>
          <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/tempo-free-onepage-bootstrap-theme/ -->
            <p><b>USE MÁSCARA, SALVE VIDAS!</b></p>
            <p><b>E-MAIL PARA CONTATO: <span style="color: #e43c5c;"><a href="mailto:covid192020projeto@gmail.com">covid192020projeto@gmail.com</a></span></b></p>
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
          </div>
        </div>
        <div class="social-links text-center text-md-right pt-3 pt-md-0">
          <a href="https://twitter.com/CORONADEN1" target="_blank" class="twitter"><i class="bx bxl-twitter"></i></a>
          <a href="https://www.instagram.com/coronaden_/?hl=pt-br" target="_blank" class="instagram"><i class="bx bxl-instagram"></i></a>
        </div>
      </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top"><i class="ri-arrow-up-line"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/jquery.easing/jquery.easing.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/venobox/venobox.min.js"></script>
    <script src="assets/vendor/owl.carousel/owl.carousel.min.js"></script>

    <!-- SCRIPT LOGOUT -->

    <script>
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

      $(function() {
        $('a#logout').click(function() {
          if (confirm('Você tem certeza que deseja sair?')) {
            return true;
          }

          return false;
        });
      });
    </script>

    <!-- FIM SCRIPT LOGOUT -->

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>