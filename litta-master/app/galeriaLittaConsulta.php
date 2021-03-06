<?php
session_start();
?>
<?php if(!empty($_SESSION['idConsulta'])){ ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Consulta Galeria</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link href="./public/open-iconic/font/css/open-iconic-bootstrap.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="./public/css/galeria.css">
  <!-- Link Swiper's CSS -->
  <link rel="stylesheet" href="./public/css/swiper.css">

  <!-- Demo styles -->
  <style>
    body {
      background: #fff;
      font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
      font-size: 14px;
      color:#000;
      overflow:hidden;
    }
    .swiper-pagination-bullet:focus{
        outline:none; 
    }
    #closeBt{
      display:none;
    }

    .swiper-slide-active #closeBt{
         display: block;
    }
        
    .swiper-container {
      width: 100%;
      padding-top: 26vh;
      padding-bottom: 50px;    
    }
    .swiper-slide {
      background-position: center;
      background-size: cover;
      opacity: 0.3;
      width: 300px;
      height: 300px;
    }
    .swiper-slide-active{
          opacity: 1 !important;
        }

        ::-webkit-input-placeholder {
          position:relative;
          color: white;  
          text-align:center;
          top:45%;
        }
        
        textarea:-moz-placeholder { /* Firefox 18- */
          position:absolute;
          color: white;  
          text-align:center;
          top:45%;
          line-height: 250px;
        }
        
        textarea::-moz-placeholder {  /* Firefox 19+ */
          position:absolute;
          color: white;  
          text-align:center;
          top:45%;
          line-height: 250px;

        }
        
        :-ms-input-placeholder {  
          position:relative;
          color: white;  
          text-align:center;
          top:45%;
        }

        input:-moz-placeholder{
          position:relative;
          color: white;  
          text-align:center;
          top:45%;
        }

        textarea:-moz-placeholder {
          position:relative;
          color: white;  
          text-align:center;
          top:45%;
        }
     
    @media only screen and (max-width: 760px) {

      .swiper-slide {
          opacity: 0;
          transition: opacity; 
          transition-timing-function: ease-in;
          transition-duration: .5s !important; 
        }

        .swiper-slide-active {
          opacity: 1;
          transition: opacity; 
          transition-timing-function: ease-in;
          transition-duration: .5s !important; 
        }

        .containerGeral{
          width:100vw;
          height:90vh;
        }
        body {
        position:fixed;
      }
    }

  </style>
</head>
<body onload="startRestart()" >
<nav id="navTest" class="navbar navbar-expand-md bg-white navbar-light fixed-top mb-5 ">

    <a class="navbar-brand" href="index" id="logoLitta">LITTA</a>

    <button id="toggleBt"  class="navbar-toggler" data-toggle="modal" data-target="#myModal">
    <div class="toggle">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>   
    </button>

    <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">

            <a  href="work" >
                <span class="option align-baseline" id="option1"> WORK <span>
            </a>
            <br>
            <br>
            <a href="#notJump">
                <span class="option align-baseline" id="option2"> QUIZ <span>
            </a>
            <br>
            <br>
            <a href="perfilConsulta">
                <span class="option align-baseline" id="option3"> VOLTAR <span>
            </a>
    </ul>

    </div>

    <div class="modal  fade" id="myModal" >

        <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content d-block text-centered" style="border:none !important">
                <ul class="navbar-nav ">
                    <a  href="work" >
                        <span class="modalOption"> WORK <span>
                    </a>
                    <a  href="index" >
                        <span class="modalOption"> QUIZ <span>
                    </a>
                    <a  href="perfilConsulta" >
                        <span class="modalOption"> VOLTAR <span>
                    </a>
                </ul>
        </div>
        </div>
    </div>   

</nav>

  <!-- Swiper -->
  <div class="containerGeral" >



    <div class="swiper-container"  >
            <div class="centered mt-n5">
              <div class="row" id="cabecalhoRow"style="margin-bottom:70px;margin-top:-70px">

                <a href="galeriaConsulta">
                  <span class="option" id="option4"><?php echo $_SESSION['nomeConsulta']?><span>
                </a>

                <span class="option" id="separator"> I <span>

                <a href="galeriaLittaConsulta">
                  <span class="option active"  id="option5"> LITTA <span>
                </a>
              </div>
            </div>
      <div class="swiper-wrapper">
      <?php
        session_start();
        include_once("./dataBaseManager/conexao.php");
        $idConsulta = $_SESSION['idConsulta'];
        $sql = "SELECT * FROM galeria WHERE idUsuario = $idConsulta AND deletada = '0' AND indicacao='1' ORDER BY id DESC";
        $result = mysqli_query($conn, $sql);
        $cont = 0;
        if (mysqli_query($conn, $sql)) {
          while($row = mysqli_fetch_assoc($result)) { 
            $endereco = $row["endereco"]; $idImage = $row["id"];$indicacao = $row["indicacao"];$dataCriacao = $row["dataCriacao"];   
            $sqlLegenda = "SELECT * FROM legendas WHERE idImagem = $idImage ORDER BY id ASC";
            ?>
          
          <div class="swiper-slide" style="background-image:url(<?php echo $endereco ?>);background-size:100% 100%">

            <form method="POST" onsubmit="return confirm('A imagem ser?? deletada, tem certeza?');" action="./dataBaseManager/deletaImagem.php" > 
                  <input name="idImage" style="display:none" value="<?php echo $idImage ?>"></input>
                  <button type="submit" id="closeBt"><span class="oi oi-x" style="filter: invert(1) sepia(0) saturate(1) hue-rotate(0deg) brightness(1.5);"></span></button>
                </form>
                <?php
              			$ano = substr($dataCriacao, 0, 4);
                    $mes = substr($dataCriacao, 5, 2);
                    $dia = substr($dataCriacao, 8, 2);
                    $hora = substr($dataCriacao, 11, 2);
                    $minuto = substr($dataCriacao, 14, 2);
                    $segundo = substr($dataCriacao, 17, 2);
                    $dataCriacao = "$dia/$mes/$ano   $hora:$minuto:$segundo"; ?>
              <br><span style="bottom: 40px!important;position: relative;font-family:bigJohn;font-weight:bold;background-color:white;z-index:3">Criada em: <strong style="letter-spacing:2px"> <?php echo $dataCriacao ?> </strong> </span>
              <div class="inside">
                      <textarea name="legenda" class="legenda" placeholder="Ainda n??o h?? coment??rios" id="textoLegenda" readonly  
                      <?php $resultLegenda = mysqli_query($conn, $sqlLegenda);
                        if (mysqli_query($conn, $sqlLegenda)) { ?>><?php 
                          while($row = mysqli_fetch_assoc($resultLegenda)) {
                            $idUsuario = $row["idUsuario"]; $usuario = $row["usuario"];  $legenda = $row["texto"]; $feitaEm = $row["feitaEm"]; 
                            $ano = substr($feitaEm, 0, 4);
                            $mes = substr($feitaEm, 5, 2);
                            $dia = substr($feitaEm, 8, 2);
                            $hora = substr($feitaEm, 11, 2);
                            $minuto = substr($feitaEm, 14, 2);
                            $segundo = substr($feitaEm, 17, 2);
                            $feitaEm = "$dia/$mes/$ano   $hora:$minuto:$segundo"; 
                            echo $usuario.' - '.$legenda. "\n".'[ '.$feitaEm.' ]'. "\n" ;} } ?></textarea>
                    <form method="POST" class="formulario" onsubmit="insereLegenda(event , <?php echo $cont ?>)" action="./dataBaseManager/alteraLegenda.php" > 
                      <input name="idImage" style="display:none" value="<?php echo $idImage ?>"></input>
                      <input placeholder = "Adicione um coment??rio" name="texto" class="comentario" id="comentario" autocomplete="off" required></input>
                      <button type="submit" class="legendaBt" id="legendaBt" onclick=""><span class="oi oi-chevron-right" style="margin-left:2px"></span></button>
                    </form>
                </div>
                
            </div>
            <?php
              $cont++;
              } 
            }else {
              echo "mysqli_error($conn)";
            }?>
            
          </div>
      <div class="swiper-pagination"style="z-index:10;filter: invert(0.4) sepia(0) saturate(1) hue-rotate(0deg) brightness(0.1)"></div>
    </div>

    <div class="container-fluid" id="botoes">
      <button id="photoEdit" onclick="document.getElementById('arquivo').click()">Adicionar Imagem<img src="./public/open-iconic/svg/plus.svg" class="icon" alt="pencil" style="margin-bottom:3px" ></button>
      <form action="./galeriaDeletada">
        <button type="submit" id="deletadas">Deletadas</button>
      </form>
    </div>

    <div id="spinner" class="text-center" style="display:none">
      <div class="spinner-border text-dark" role="status">
        <span class="sr-only">Loading...</span>
      </div>
  </div>

    <form method="post" onsubmit="carregando();" enctype="multipart/form-data" action="./dataBaseManager/recebeUploadAmostra.php" style="display:none" > 
      <input id="arquivo" name="arquivo[]" onchange="document.getElementById('salvar').click()" multiple="multiple" accept='image/*' type="file" />
      <br/>
      <input type="submit" id="salvar" value="Salvar"/>
    </form>

  </div>
  <!-- Swiper JS -->
  <script src="./public/css/swiper.js"></script>
  <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

  <!-- Initialize Swiper -->
  <script>
    var swiper = new Swiper('.swiper-container', {
      effect: 'coverflow',
      speed: 700,
      updateOnWindowResize: false,
      direction: 'horizontal',
      touchRatio: 0.35,
      touchReleaseOnEdges: true,
      centeredSlides: true,
      slidesPerView: getNumber(),
      coverflowEffect: {
        rotate: 50,
        stretch: 0,
        depth: 100,
        modifier: getModifier(),
        slideShadows : false,
      },
      pagination: {
        el: '.swiper-pagination',
        clickable	: true,
      },
      on: {
        resize: function () {
          swiper.changeDirection(getDirection());
          
        }
      },
        on: {
          imagesReady:function () {
            swiper.changeDirection(getDirection());
          }
        }
    });

    function getDirection() {
      var windowWidth = window.innerWidth;
      var direction = ( (window.innerWidth / window.innerHeight ) <= 1 ? 'vertical' : 'horizontal' );
      return direction;
    }
    function getNumber() {
      var windowWidth = window.innerWidth;
      var number = window.innerWidth <= 760 ? 'auto' : 4;
      return number;
    }

    function getModifier() {
      var windowWidth = window.innerWidth;
      var number = window.innerWidth <= 760 ? 0 : 1;
      return number;
    }

    function reload() {
      console.log("reloading...");
      return location.reload();
    }

    function carregando() {
      document.getElementById("photoEdit").style.display = "none";
      document.getElementById("spinner").style.display = "block";
    }
    var text = document.getElementsByClassName('legenda');
    var botao = document.getElementsByClassName('legendaBt');
    var formularios = document.getElementsByClassName('formulario');
    var comentarios = document.getElementsByClassName('comentario');

     function insereLegenda(e,cont){
      botao[cont].disabled = true;
      var form = document.querySelector('form');
      e.preventDefault(); // <--- isto p??ra o envio da form
      var url = form.action;
      var formData = new FormData(formularios[cont]); // <--- os dados da form
      console.log(form);
      var xhttp;
      xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        // document.getElementById("txtHint").innerHTML = this.responseText;
        text[cont].value += this.responseText;
        text[cont].scrollTop = text[cont].scrollHeight;
        }
      };
      xhttp.open("POST", "./dataBaseManager/alteraLegenda.php", true);
      xhttp.send(formData);
      comentarios[cont].value = "";
      botao[cont].disabled = false;

    }

    $(document).ready(function(){
            $('.toggle').click(function(){
              $('.toggle').toggleClass('active');
              $('.navbar-brand').toggleClass('active');
              $('.navbar').toggleClass('active');
            });
            $('.modal').click(function(){
              $('.toggle').toggleClass('active');
              $('.navbar-brand').toggleClass('active');
              $('.navbar').toggleClass('active');
            });
            $('.suboption').click(function(){
              $('.suboption').removeClass('active');
              $(this).addClass('active');
            });
            window.addEventListener("orientationchange", function() {
              reload();
            });
        });
  </script>
</body>
</html>
<?php }else{
	$_SESSION['msgErro'] = "Fa??a login para continuar";
	header("Location: ./login");	
}?>