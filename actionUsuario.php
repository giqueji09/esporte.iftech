<?php include "header.php" ?>

    <?php
        //Verifica se o método de envio das informações do form é "POST"
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            //Cria variáveis para armazenar as informações recebidas do array $_POST
            // Adicionado $cpfUsuario na inicialização das variáveis
            $fotoUsuario = $nomeUsuario = $cpfUsuario = $dataNascimentoUsuario = $cidadeUsuario = $emailUsuario = $senhaUsuario = $confirmarSenhaUsuario = "";

            //Variável booleana para controle de erros de preenchimento
            $erroPreenchimento = false;

            //Validação do campo nomeUsuario
            if(empty($_POST["nomeUsuario"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>NOME</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                $nomeUsuario = filtrar_entrada($_POST["nomeUsuario"]);

                if(!preg_match('/^[\p{L} ]+$/u', $nomeUsuario)){
                    echo "<div class='alert alert-warning text-center'>O campo <strong>NOME</strong> deve conter apenas letras!</div>";
                    $erroPreenchimento = true;
                }
            }

            // NOVA VALIDAÇÃO: campo cpfUsuario
            if(empty($_POST["cpfUsuario"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>CPF</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                $cpfUsuario = filtrar_entrada($_POST["cpfUsuario"]);

                // O JavaScript removeu a máscara, então esperamos exatamente 11 números
                if(!preg_match('/^\d{11}$/', $cpfUsuario)){
                    echo "<div class='alert alert-warning text-center'>O campo <strong>CPF</strong> deve conter exatamente 11 números válidos!</div>";
                    $erroPreenchimento = true;
                }
            }

            //Validação do campo dataNascimentoUsuario
            if(empty($_POST["dataNascimentoUsuario"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>DATA DE NASCIMENTO</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                $dataNascimentoUsuario = filtrar_entrada($_POST["dataNascimentoUsuario"]);

                if(strlen($dataNascimentoUsuario) == 10){
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
            if (empty($_POST["telefoneUsuario"])) {
                echo "<div class='alert alert-warning text-center'>O campo <strong>TELEFONE</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            } else {
                $telefoneUsuario = filtrar_entrada($_POST["telefoneUsuario"]);

                if (!preg_match('/^\d{11}$/', $telefoneUsuario)) {
                    echo "<div class='alert alert-warning text-center'>O campo <strong>TELEFONE</strong> deve conter exatamente 11 números (DDD + telefone).</div>";
                    $erroPreenchimento = true;
                }
            }

            //Validação do campo emailUsuario
            if(empty($_POST["emailUsuario"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>EMAIL</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                $emailUsuario = filtrar_entrada($_POST["emailUsuario"]);
            }

            //Validação do campo senhaUsuario
            if(empty($_POST["senhaUsuario"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>SENHA</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                $senhaUsuario = md5(filtrar_entrada($_POST["senhaUsuario"]));
            }

            //Validação do campo confirmarSenhaUsuario
            if(empty($_POST["confirmarSenhaUsuario"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>CONFIRMAR SENHA</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                $confirmarSenhaUsuario = md5(filtrar_entrada($_POST["confirmarSenhaUsuario"]));

                if($senhaUsuario != $confirmarSenhaUsuario){
                    echo "<div class='alert alert-warning text-center'>As <strong>SENHAS</strong> informadas não são iguais!</div>";
                    $erroPreenchimento = true;
                }
            }

             //Verifica se não há erro de preenchimento
            if(!$erroPreenchimento){

                // ATUALIZAÇÃO DA QUERY: Adicionado cpfUsuario na query de inserção
                $inserirUsuario = "INSERT INTO usuarios (nomeUsuario, cpfUsuario, dataNascimentoUsuario, telefoneUsuario, emailUsuario, senhaUsuario) VALUES ('$nomeUsuario', '$cpfUsuario', '$dataNascimentoUsuario', '$telefoneUsuario', '$emailUsuario', '$senhaUsuario')";

                include "conexaoBD.php";
                
                if(mysqli_query($conn, $inserirUsuario)){
                    
                    // Formata o CPF apenas para exibição na tabela final
                    $cpfFormatado = substr($cpfUsuario, 0, 3) . '.' . substr($cpfUsuario, 3, 3) . '.' . substr($cpfUsuario, 6, 3) . '-' . substr($cpfUsuario, 9, 2);

                    echo "<div class='alert alert-success text-center'>O cadastro do <strong>USUÁRIO</strong> foi efetuado com sucesso!</div>";
                    echo "
                            <table class='table'>
                                <tr>
                                    <th>NOME</th>
                                    <td>$nomeUsuario</td>
                                </tr>
                                <tr>
                                    <th>CPF</th>
                                    <td>$cpfFormatado</td>
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
            header("location:formUsuario.php");
        }

        function filtrar_entrada($dado){
            $dado = trim($dado); 
            $dado = stripslashes($dado); 
            $dado = htmlspecialchars($dado); 
            return($dado);
        }
    ?>

<?php include "footer.php" ?>