<?php include "header.php"?>

    <?php
        //Verifica se o método de envio das informações do form é "POST"
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            //Cria variáveis para armazenar as informações recebidas do array $_POST
            $fotoQuadra = $nomeQuadra = $esportes = $localizacao = $horarioAbertura = $horarioFechamento = "";

            //Variável booleana para controle de erros de preenchimento
            $erroPreenchimento = false;

            //Validação do campo nomeQuadra
            //Utiliza a função empty() para verificar se o campo está vazio
            if(empty($_POST["nomeQuadra"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>NOME</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            } else{
                //Se o $_POST["nomeQuadra"] não estiver vazio, é filtrado e armazenado na variável PHP
                $nomeQuadra = filtrar_entrada($_POST["nomeQuadra"]);

                //Utiliza a função preg_match() para verificar se há apenas letras no nome
                if(!preg_match('/^[\p{L} ]+$/u', $nomeQuadra)){
                    echo "<div class='alert alert-warning text-center'>O campo <strong>NOME</strong> deve conter apenas letras!</div>";
                    $erroPreenchimento = true;
                }
            }

            //Validação do campo esportes
            //Utiliza a função empty() para verificar se o campo está vazio
            if(empty($_POST["esportes"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>ESPORTES</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                //Se o $_POST["esportes"] não estiver vazio, é filtrado e armazenado na variável PHP
                $esportes = filtrar_entrada($_POST["esportes"]);
            }

            //Validação do campo localizacao
            //Utiliza a função empty() para verificar se o campo está vazio
            if(empty($_POST["localizacao"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>LOCALIZAÇÃO</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                //Se o $_POST["localizacao"] não estiver vazio, é filtrado e armazenado na variável PHP
                $localizacao = filtrar_entrada($_POST["localizacao"]);
            }

            //Validação do campo horarioAbertura
            //Utiliza a função empty() para verificar se o campo está vazio
            if(empty($_POST["horarioAbertura"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>HORÁRIO ABERTURA</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                //Se o $_POST["horarioAbertura"] não estiver vazio, é filtrado e armazenado na variável PHP
                $horarioAbertura = filtrar_entrada($_POST["horarioAbertura"]);
            }

            //Validação do campo horarioFechamento
            //Utiliza a função empty() para verificar se o campo está vazio
            if(empty($_POST["horarioFechamento"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>HORÁRIO FECHAMENTO</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                //Se o $_POST["horarioFechamento"] não estiver vazio, é filtrado e armazenado na variável PHP
                $horarioFechamento = filtrar_entrada($_POST["horarioFechamento"]);
            }

            //Início da validação do campo fotoQuadra
            $diretorio    = "assets/img/"; //Define para qual diretório as imagens serão movidas
            $fotoQuadra  = $diretorio . basename($_FILES['fotoQuadra']['name']); //Montar o nome a ser salvo no BD (asset/img/paulinho.jpg)
            $tipoDaImagem = strtolower(pathinfo($fotoQuadra, PATHINFO_EXTENSION)); //Pega a extensão da imagem convertida em letras minúsculas
            $erroUpload   = false; //Variável para controle de erros no upload da foto

            //Verifica se o tamanho do arquivo é diferente de ZERO
            if($_FILES['fotoQuadra']['size'] != 0){
                //Inicia a validação do arquivo fotoQuadra

                //Verifica se o tamanho da foto é maior do que 5 MegaBytes (MB) (5000000 bytes)
                if($_FILES['fotoQuadra']['size'] > 5000000){
                    echo "<div class='alert alert-warning text-center'>A <strong>FOTO</strong> deve ser menor do que 5MB!</div>";
                    $erroUpload = true;
                }

                //Verifica se a foto está nos formatos jpg, jpeg, png ou webp
                if($tipoDaImagem != "jpg" && $tipoDaImagem != "jpeg" && $tipoDaImagem != "png" && $tipoDaImagem != "webp"){
                    echo "<div class='alert alert-warning text-center'>A <strong>FOTO</strong> deve estar nos formatos JPG, JPEG, PNG ou WEBP!</div>";
                    $erroUpload = true;
                }

                //Verifica se a foto foi movida para o diretório (assets/img/), utilizando a função move_uploaded_file()
                if(!move_uploaded_file($_FILES["fotoQuadra"]["tmp_name"], $fotoQuadra)){
                    echo "<div class='alert alert-danger text-center'>Erro ao tentar mover a foto para o diretório <strong>$diretorio</strong>!</div>";
                    $erroUpload = true;
                }
            }
            else{
                echo "<div class='alert alert-warning text-center'>A <strong>FOTO</strong> é obrigatória!</div>";
                $erroUpload = true;
            }

            //Verifica se não há erro de preenchimento
            if(!$erroPreenchimento && !$erroUpload){

            $inserirQuadra = "INSERT INTO quadras (fotoQuadra, nomeQuadra, esportes, localizacao, horarioAbertura, horarioFechamento) VALUES ('$fotoQuadra', '$nomeQuadra', '$esportes', '$localizacao', '$horarioAbertura', '$horarioFechamento')";
            include "conexaoBD.php";

                //Usa a função mysqli_query() para executar a QUERY no Banco de Dados
                //Se conseguir, exibe alerta de sucesso e tabela com os dados informados
                if(mysqli_query($conn, $inserirQuadra)){

                    echo "<div class='alert alert-success text-center'>O cadastro do <strong>USUÁRIO</strong> foi efetuado com sucesso!</div>";
                    echo "
                        <div class='container mb-3 mt-3'>
                            <div class='container mb-3 mt-3 text-center'>
                                <img src='$fotoQuadra' title='Foto de $nomeQuadra' style='width:150px' class='img-thumbnail'>
                            </div>
                            <table class='table'>
                                <tr>
                                    <th>NOME QUADRA</th>
                                    <td>$nomeQuadra</td>
                                </tr>
                                <tr>
                                    <th>ESPORTES</th>
                                    <td>$esportes</td>
                                </tr>
                                <tr>
                                    <th>LOCALIZAÇÃO</th>
                                    <td>$localizacao</td>
                                </tr>
                                <tr>
                                    <th>HORÁRIO ABERTURA</th>
                                    <td>$horarioAbertura</td>
                                </tr>
                                <tr>
                                    <th>HORÁRIO FECHAMENTO</th>
                                    <td>$horarioFechamento</td>
                                </tr>
                            </table>
                        </div>
                    ";
                }
                else{
                    echo "<div class='alert alert-danger text-center'>Erro ao tentar cadastrar <strong>QUADRA</strong> no banco de dados!</div>";
                }
            }

        }
        else{
            //Usa a função header() para redirecionar o usuário para o formUsuario.php
            header("location:formQuadra.php");
        }

        //Função para filtrar entrada de dados e evitar SQL Injection
        function filtrar_entrada($dado){
            $dado = trim($dado); //Remove espaços desnecessários
            $dado = stripslashes($dado); //Remove barras invertidas
            $dado = htmlspecialchars($dado); //Converte caracteres especiais em entidades HTML

            //Após o dado passar pelos filtros, é retornado
            return($dado);
        }
    ?>

 

<?php include "footer.php"?>