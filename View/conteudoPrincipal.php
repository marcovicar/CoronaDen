<!-- ======= Hero Section ======= -->
<section id="hero">
  <div class="hero-container">
    <h3>Seja bem vindo ao <strong>CoronaDen</strong></h3>
    <h1>Ajude a combater a COVID-19</h1>
    <h2>Este é um site para realizar denúncias anônimas e ajudar alertar moradores locais</h2>
    <div class="btn-get-started scrollto">
      <div class="btnPesquisar">
        <input type="text" id="buscarDenuncia" name="buscar" placeholder="Buscar denúncia"><input type="submit" id="btnBusca" value="Buscar">
      </div>


    </div><!-- End sidebar search formn-->
  </div>
</section><!-- End Hero -->

<!-- API COVID-19 DF -->
<section class="api">
  <div class="container">
    <div class="card text-white bg-danger mb-3">
      <div class="card-header"><b>🚨 Atualização de casos COVID-19 DF 🚨</b></div>
      <div class="card-body">
        <p class="card-text"><b>Cidade:</b> <?= $casosDF->uid ?></p>
        <p class="card-text"><b>UF:</b> <?= $casosDF->uf ?></p>
        <p class="card-text"><b>Estado:</b> <?= $casosDF->state ?></p>
        <p class="card-text"><b>✅ Casos:</b> <?= $casosDF->cases ?></p>
        <p class="card-text"><b>💀 Mortes:</b> <?= $casosDF->deaths ?></p>
        <p class="card-text"><b>🕐 Atualizado:</b> <?= $casosDF->datetime ?></p>
        <p><i>Fontes: CSSEGISandData, Ministério da Saúde e Coronavírus Brasil</i></p>
      </div>
    </div>
  </div>
</section>



<!-- ======= About Section ======= -->
<section id="about" class="about">
  <div class="container">

    <div class="section-title">
      <h2>Sobre nós</h2>
      <h3>Saiba de onde surgiu <span>esta ideia</span></h3>
      <p>Este site foi criado por 4 universitários da UDF como desenvolvimento de seu TCC.</p>
    </div>

    <div class="row content">
      <div class="col-lg-6">
        <p>
          Este foi um projeto idealizado para um TCC por um grupo de <a href="#team">universitários</a> com a visão de ajudar a denúnciar anônimamente as aglomerações ocorridas mostrando no mapa a localização e ajudando usuários a evitar esta área.
        </p>

      </div>
      <div class="col-lg-6 pt-4 pt-lg-0">
        <p>
          Esta ideia foi formada com base no cenário mundial na qual estamos inseridos, em uma pandemia global sem data de fim; para ajudar de alguma forma, tivemos esta ideia em concordância do <a href="#team">grupo</a> para colocar em prática.
        </p>
      </div>
    </div>

  </div>
</section><!-- End About Section -->

<!-- SINTOMAS -->
<section id="info" class="info">
  <div class="container">

    <div class="section-title">
      <h2>Sintomas</h2>
      <h3>Veja quais são os <span>sintomas da COVID-19</span></h3>
    </div>
    <ul class="info-list">
      <img id="imgSintomas" src="assets\img\sintomas.png" alt="sintomas do coronavírus" />
    </ul>
  </div>
</section>

<!-- ======= SAIBA COMO SE PREVINIR Section ======= -->
<section id="info" class="info">
  <div class="container">

    <div class="section-title">
      <h2>Saiba como se previnir</h2>
      <h3>Meios de prevenção contra a <span>COVID-19</span></h3>
    </div>

    <ul class="info-list">

      <li>
        <a data-toggle="collapse" class="" href="#info1">Use álcool em gel-70 <i class="icofont-simple-up"></i></a>
        <div id="info1" class="collapse show" data-parent=".info-list">
          <p>
            O álcool à 70% é classificado como desinfetante de nível intermediário e tem sido utilizado, nos serviços de saúde, na desinfecção de mobiliários e equipamentos, termômetros, estetoscópios, ampolas e frascos de medicamentos, fibra óptica de endoscópios, dentre outros.
            Desde o início da pandemia pelo coronavírus, as Agências de Saúde em todo o mundo têm recomendado o seu uso para desinfecção de todas as superfícies inertes nos estabelecimentos comerciais, locais de trabalho e nas residencias, que possam estar contaminadas pelo vírus.
          </p>
        </div>
      </li>

      <li>
        <a data-toggle="collapse" href="#info2" class="collapsed">Use máscara, salve vidas <i class="icofont-simple-up"></i></a>
        <div id="info2" class="collapse" data-parent=".info-list">
          <p>
            O uso da máscara se popularizou na rotina de milhares de pessoas em todo o país, como medida de segurança para conter o avanço do coronavírus. A máscara cria uma barreira física que impede a proliferação do vírus, ajudando a reduzir o número de pessoas infectadas.
          </p>
        </div>
      </li>

      <li>
        <a data-toggle="collapse" href="#info3" class="collapsed">Não fique em ambientes fechados e com muitas pessoas <i class="icofont-simple-up"></i></a>
        <div id="info3" class="collapse" data-parent=".info-list">
          <p>
            A cada vez que alguém respira, fala, canta, tosse ou espirra, forma-se uma pequena nuvem de gás a partir do ar exalado. Ela carrega as gotículas — que podem estar repletas de cópias do Sars-CoV-2 — em uma velocidade mais rápida do que o fluxo de ar do ambiente. Se há pouca ventilação e muita aglomeração, o alcance dessa nuvem tende a se amplificar. No caso de um espirro, por exemplo, ela chegaria a até oito metros em segundos.
          </p>
        </div>
      </li>

      <li>
        <a data-toggle="collapse" href="#info4" class="collapsed">Não toque nos olhos, no nariz ou na boca. <i class="icofont-simple-up"></i></a>
        <div id="info4" class="collapse" data-parent=".info-list">
          <p>
            Você pode passar a mão em uma superfice contaminada e levar ao rosto, facilitando assim a contaminação.
          </p>
        </div>
      </li>

      <li>
        <a data-toggle="collapse" href="#info5" class="collapsed">Cubra seu nariz e boca com o braço dobrado ou um lenço ao tossir ou expirar. <i class="icofont-simple-up"></i></a>
        <div id="info5" class="collapse" data-parent=".info-list">
          <p>
            A Organização Mundial da Saúde (OMS) reconheceu na última terça-feira (7/7) que existe a possibilidade de o coronavírus ser transmitido não apenas por gotículas expelidas por tosse e espirros, mas por partículas microscópicas liberadas por meio da respiração e da fala que ficam em suspensão no ar.
          </p>
        </div>
      </li>

      <li>
        <a data-toggle="collapse" href="#info6" class="collapsed">Lave as mãos com frequência. <i class="icofont-simple-up"></i></a>
        <div id="info6" class="collapse" data-parent=".info-list">
          <p>
            Estudos da OMS mostraram que, ao lavar as mãos adequadamente com água e sabonete, podemos reduzir em 50% as doenças relacionadas ao estômago, e as doenças respiratórias incluindo a COVID-19 - como o resfriado e a gripe comum - em um terço.
          </p>
        </div>
      </li>

    </ul>

  </div>
</section><!-- End F.A.Q Section -->

<!-- SOLICITANDO A VIEW infosHospitais PARA INCLUIR NESSA VIEW -->
<?php
require_once("View/infosHospitais.php");
?>
<!-- FIM -->

<!-- TIME -->
<!-- ======= Team Section ======= -->
<section id="team" class="team">
  <div class="container">

    <div class="section-title">
      <h2>Time</h2>
      <h3>Nosso time dos <span>sonhos</span></h3>
      <p>Aqui você encontrará as redes sociais dos desenvolvedores.</p>
    </div>

    <div class="row">

      <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
        <div class="member">
          <div class="member-img">
            <img src="assets/img/team/team1.jpeg" class="img-fluid" alt="">
            <div class="social">
              <a href="https://www.facebook.com/rafael.leandro.583671" target="_blank"><i class="icofont-facebook"></i></a>
              <a href="https://www.instagram.com/faelll_s/?hl=pt-br" target="_blank"><i class="icofont-instagram"></i></a>
              <a href="https://www.linkedin.com/in/rafael-leandro-677a891b5" target="_blank"><i class="icofont-linkedin"></i></a>
            </div>
          </div>
          <div class="member-info">
            <h4>Rafael Leandro</h4>
            <span>Analista de Requisitos</span>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
        <div class="member">
          <div class="member-img">
            <img src="assets/img/team/team4.jpeg" class="img-fluid" alt="">
            <div class="social">
              <a href="https://www.facebook.com/marcosvictor.araujoramos" target="_blank"><i class="icofont-facebook"></i></a>
              <a href="https://www.instagram.com/marcovicar/?hl=pt-br" target="_blank"><i class="icofont-instagram"></i></a>
              <a href="https://www.linkedin.com/in/marcos-victor-ara%C3%BAjo-ramos-79ba49182/" target="_blank"><i class="icofont-linkedin"></i></a>
            </div>
          </div>
          <div class="member-info">
            <h4>Marcos Victor</h4>
            <span>Desenvolvedor FrondEnd</span>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
        <div class="member">
          <div class="member-img">
            <img src="assets/img/team/team3.jpeg" class="img-fluid" alt="">
            <div class="social">
              <a href="https://www.linkedin.com/in/fabio-marras-1911511b9/" target="_blank"><i class="icofont-linkedin"></i></a>
            </div>
          </div>
          <div class="member-info">
            <h4>Fabio Marras</h4>
            <span>Analista de Requisitos</span>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
        <div class="member">
          <div class="member-img">
            <img src="assets/img/team/team2.jpeg" class="img-fluid" alt="">
            <div class="social">
              <a href="https://www.instagram.com/vinicius_s_coelho/" target="_blank"><i class="icofont-instagram"></i></a>
              <a href="https://www.linkedin.com/in/vin%C3%ADcius-da-silva-co%C3%AAlho-143b7a173/" target="_blank"><i class="icofont-linkedin"></i></a>
            </div>
          </div>
          <div class="member-info">
            <h4>Vinicius Coelho</h4>
            <span>Desenvolvedor BackEnd</span>
          </div>
        </div>
      </div>

    </div>

  </div>
</section><!-- End Team Section --><!-- FIM TIME -->
</main><!-- End #main -->