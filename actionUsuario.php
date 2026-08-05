<?php include "header.php" ?>

    <?php
        //Verifica se o método de envio das informações do form é "POST"
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            //Cria variáveis para armazenar as informações recebidas do array $_POST
            $fotoUsuario = $nomeUsuario = $dataNascimentoUsuario = $cidadeUsuario = $emailUsuario = $senhaUsuario = $confirmarSenhaUsuario = "";

            //Variável booleana para controle de erros de preenchimento
            $erroPreenchimento = false;

            //Validação do campo nomeUsuario
            //Utiliza a função empty() para verificar se o campo está vazio
            if(empty($_POST["nomeUsuario"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>NOME</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                //Se o $_POST["nomeUsuario"] não estiver vazio, é filtrado e armazenado na variável PHP
                $nomeUsuario = filtrar_entrada($_POST["nomeUsuario"]);

                //Utiliza a função preg_match() para verificar se há apenas letras no nome
                if(!preg_match('/^[\p{L} ]+$/u', $nomeUsuario)){
                    echo "<div class='alert alert-warning text-center'>O campo <strong>NOME</strong> deve conter apenas letras!</div>";
                    $erroPreenchimento = true;
                }
            }

            //Validação do campo dataNascimentoUsuario
            //Utiliza a função empty() para verificar se o campo está vazio
            if(empty($_POST["dataNascimentoUsuario"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>DATA DE NASCIMENTO</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                //Se o $_POST["dataNascimentoUsuario"] não estiver vazio, é filtrado e armazenado na variável PHP
                $dataNascimentoUsuario = filtrar_entrada($_POST["dataNascimentoUsuario"]);

                //Utiliza a função strlen() para verificar o comprimento da string $dataNascimentoUsuario (string length)
                if(strlen($dataNascimentoUsuario) == 10){
                    //Aplicar a função substr() para gerar substrings e armazenar dia, mês e ano de nascimento
                    $diaNascimentoUsuario = substr($dataNascimentoUsuario, 8, 2);
                    $mesNascimentoUsuario = substr($dataNascimentoUsuario, 5, 2);
                    $anoNascimentoUsuario = substr($dataNascimentoUsuario, 0, 4);
                }
                else{
                    echo "<div class='alert alert-warning text-center'><strong>DATA</strong> inválida!</div>";
                    $erroPreenchimento = true;
                }
            }

                    //Validação do campo telefoneUsuario
        //Utiliza a função empty() para verificar se o campo está vazio
        if (empty($_POST["telefoneUsuario"])) {
            echo "<div class='alert alert-warning text-center'>O campo <strong>TELEFONE</strong> é obrigatório!</div>";
            $erroPreenchimento = true;
        } else {
            //Se o $_POST["telefoneUsuario"] não estiver vazio, é filtrado e armazenado na variável PHP
            $telefoneUsuario = filtrar_entrada($_POST["telefoneUsuario"]);

            //Verifica se contém exatamente 11 dígitos
            if (!preg_match('/^\d{11}$/', $telefoneUsuario)) {
                echo "<div class='alert alert-warning text-center'>O campo <strong>TELEFONE</strong> deve conter exatamente 11 números (DDD + telefone).</div>";
                $erroPreenchimento = true;
            }
        }

                      //Validação do campo emailUsuario
            //Utiliza a função empty() para verificar se o campo está vazio
            if(empty($_POST["emailUsuario"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>EMAIL</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                //Se o $_POST["emailUsuario"] não estiver vazio, é filtrado e armazenado na variável PHP
                $emailUsuario = filtrar_entrada($_POST["emailUsuario"]);
            }

            //Validação do campo senhaUsuario
            //Utiliza a função empty() para verificar se o campo está vazio
            if(empty($_POST["senhaUsuario"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>SENHA</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                //Se o $_POST["senhaUsuario"] não estiver vazio, é filtrado e armazenado na variável PHP
                //Usa a função md5() para criptografar a senha do usuário
                $senhaUsuario = md5(filtrar_entrada($_POST["senhaUsuario"]));
            }

            //Validação do campo confirmarSenhaUsuario
            //Utiliza a função empty() para verificar se o campo está vazio
            if(empty($_POST["confirmarSenhaUsuario"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>CONFIRMAR SENHA</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                //Se o $_POST["confirmarSenhaUsuario"] não estiver vazio, é filtrado e armazenado na variável PHP
                $confirmarSenhaUsuario = md5(filtrar_entrada($_POST["confirmarSenhaUsuario"]));

                //Compara se as senhas são diferentes
                if($senhaUsuario != $confirmarSenhaUsuario){
                    echo "<div class='alert alert-warning text-center'>As <strong>SENHAS</strong> informadas não são iguais!</div>";
                    $erroPreenchimento = true;
                }
            }

             //Verifica se não há erro de preenchimento
            if(!$erroPreenchimento){

                //Cria uma variável para armazenar a QUERY que realiza a inserção de dados na tabela Usuarios
                $inserirUsuario = "INSERT INTO usuarios (nomeUsuario, dataNascimentoUsuario, telefoneUsuario, emailUsuario, senhaUsuario) VALUES ('$nomeUsuario', '$dataNascimentoUsuario', '$telefoneUsuario', '$emailUsuario', '$senhaUsuario')";

                //Inclui o arquivo de conexão com o Banco de Dados
                include "conexaoBD.php";

                
                //Usa a função mysqli_query() para executar a QUERY no Banco de Dados
                //Se conseguir, exibe alerta de sucesso e tabela com os dados informados
                if(mysqli_query($conn, $inserirUsuario)){

                    echo "<div class='alert alert-success text-center'>O cadastro do <strong>USUÁRIO</strong> foi efetuado com sucesso!</div>";
                    echo "
                            <table class='table'>
                                <tr>
                                    <th>NOME</th>
                                    <td>$nomeUsuario</td>
                                </tr>
                                <tr>
                                    <th>DATA DE NASCIMENTO</th>
                                    <td>$diaNascimentoUsuario/$mesNascimentoUsuario/$anoNascimentoUsuario</td>
                                </tr>
                                <tr>
                                    <th>TELEFONE</th>
                                    <td>$telefoneUsuario</td>
                                </tr>
                                <tr>
                                    <th>EMAIL</th>
                                    <td>$emailUsuario</td>
                                </tr>
                                <tr>
                                    <th>SENHA</th>
                                    <td>$senhaUsuario</td>
                                </tr>
                                <tr>
                                    <th>CONFIRMAR SENHA</th>
                                    <td>$confirmarSenhaUsuario</td>
                                </tr>
                            </table>
                        </div>
                    ";
                }
                else{
                    echo "<div class='alert alert-danger text-center'>Erro ao tentar cadastrar <strong>USUÁRIO</strong> no banco de dados!</div>";
                }
            }

        }
        else{
            //Usa a função header() para redirecionar o usuário para o formUsuario.php
            header("location:formUsuario.php");
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

    <?php include "footer.php" ?>