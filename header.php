<?php
    error_reporting(0); //Desabilita alertas de erros de execução
    session_start(); //Inicia sessão

    //Configura o fuso horário para América/São Paulo
    date_default_timezone_set('America/Sao_Paulo');

        //Verifica se há sessão ativa
    if(isset($_SESSION['logado']) && $_SESSION['logado'] === true){
        //Armazena em variáveis PHP os dados das variáveis de Sessão 
        $idUsuario    = $_SESSION['idUsuario'];
        $nomeUsuario  = $_SESSION['nomeUsuario'];
        $emailUsuario = $_SESSION['emailUsuario'];
        $telefoneUsuario = $_SESSION['telefoneUsuario'];
        $nivelUsuario = $_SESSION['nivelUsuario'];

        $nomeCompleto = explode(' ', $nomeUsuario); //Usa a função explode para fragmentar o nome do usuário
        $primeiroNome = $nomeCompleto[0]; //Armazena na primeira posição do array o primeiro fragmento do nome
    }

?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>ReservAÍ</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/reservai.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Simple line icons-->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.5.5/css/simple-line-icons.min.css" rel="stylesheet" />
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

        <style>
            .poppins-extrabold-italic {
                font-family: "Poppins", sans-serif;
                font-weight: 800;
                font-style: normal; 
            }
        </style>
    </head>
    <body id="page-top">
        
        <!-- Navigation-->
<a class="menu-toggle rounded" href="#"><i class="fas fa-bars"></i></a>

<nav id="sidebar-wrapper">
    <ul class="sidebar-nav">
        <li class="sidebar-brand"><a href="index.php" title="Ir a página inicial">ReservAÍ</a></li>

        <?php
            //Verifica se há sessão ativa
            if(isset($_SESSION['logado']) && $_SESSION['logado'] === true){
                if($nivelUsuario == 'administrador'){
                    echo "
                       <li class='sidebar-nav-item'>
                            <a href='#perfil.php'>
                                Olá, $primeiroNome! 
                            </a>
                        </li>

                        <li class='sidebar-nav-item'>
                            <a href='minhasReservas.php'>Minhas reservas</a>
                        </li>

                        <li class='sidebar-nav-item'>
                            <a href='quadras.php'>Quadras</a>
                        </li>


                        <li class='sidebar-nav-item'>
                            <a href='formQuadras.php'>Cadastrar Quadras</a>
                        </li>

                        <li class='sidebar-nav-item'>
                            <a href='logout.php'>Sair</a>
                        </li>

                    ";
                }
                else{
                    echo "
                       <li class='sidebar-nav-item'>
                            <a href='#perfil.php'>
                                Olá, $primeiroNome!
                            </a>
                        </li>

                        <li class='sidebar-nav-item'>
                            <a href='minhasReservas.php'>Minhas reservas</a>
                        </li>

                        <li class='sidebar-nav-item'>
                            <a href='quadras.php'>Quadras</a>
                        </li>


                        <li class='sidebar-nav-item'>
                            <a href='logout.php'>Sair</a>
                        </li>

                    ";
                }
            }
            else{
                echo "
                    <li class='sidebar-nav-item'>
                        <a href='formLogin.php' title='Volte ao jogo!'>Login</a>
                    </li>

                    <li class='sidebar-nav-item'>
                        <a href='quadras.php'>Quadras</a>
                    </li>
            ";
            }   
        ?>

    </ul>
</nav>
        <!-- Header-->
        <!-- Cabeçalho -->
        <header class="py-2" id="menu" style="background-color: #1a2e17;">
            <div class="container px-4 px-lg-5 my-3">
                <div class="text-center text-white">
                    <img src="assets/img/reservai_logo2.png" style="width: 150px" class="pb-2">
                    <p class="lead fw-normal text-white mb-0 audiowide-regular">Conectando você ao esporte.</p>
                </div>
            </div>
        </header>

        <img src="assets/img/logoIF.png"
         alt=""
         class="logo-fundo">
        <!-- About-->
        <section class="content-section bg-light" id="about">
            <div class="container px-4 px-lg-5 text-center">