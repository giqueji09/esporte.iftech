<?php include "header.php" ?>

    <?php
        // Verifica se o método de envio das informações do form é "POST"
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            // Cria variáveis para armazenar as informações recebidas do array $_POST
            // (Adicionei as variáveis que faltavam e que você usa no INSERT)
            $nomeUsuario = $nomeQuadra = $dataReserva = "";
            $idReservante = ["idReservante"];
            $idQuadraReservada = ["idQuadra"];

            // Variável booleana para controle de erros de preenchimento
            $erroPreenchimento = false;

            // Validação do campo nomeUsuario
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

            // Validação do campo nomeQuadra
            if(empty($_POST["nomeQuadra"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>NOME QUADRA</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                $nomeQuadra = filtrar_entrada($_POST["nomeQuadra"]);
            } // <--- CORREÇÃO: Chave fechada aqui!

            // Validação do campo dataReserva
            if(empty($_POST["dataReserva"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>DATA DE RESERVA</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                $dataReserva = filtrar_entrada($_POST["dataReserva"]);

                if(strlen($dataReserva) == 10){
                    $diaReserva = substr($dataReserva, 8, 2);
                    $mesReserva = substr($dataReserva, 5, 2);
                    $anoReserva = substr($dataReserva, 0, 4);
                }
                else{
                    echo "<div class='alert alert-warning text-center'><strong>DATA</strong> inválida!</div>";
                    $erroPreenchimento = true;
                }
            } // <--- CORREÇÃO: Chave fechada aqui!

            // Pegar demais dados enviados pelo formulário para não irem vazios para o banco
            if(!empty($_POST["telefoneUsuario"])) { $telefoneUsuario = filtrar_entrada($_POST["telefoneUsuario"]); }
            if(!empty($_POST["emailUsuario"])) { $emailUsuario = filtrar_entrada($_POST["emailUsuario"]); }
            if(!empty($_POST["senhaUsuario"])) { $senhaUsuario = filtrar_entrada($_POST["senhaUsuario"]); }

            // Verifica se não há erro de preenchimento
            if(!$erroPreenchimento){

                // Cria uma variável para armazenar a QUERY
                $inserirUsuario = "INSERT INTO reservas (nomeUsuario, dataReserva, telefoneUsuario, emailUsuario, senhaUsuario) VALUES ('$nomeUsuario', '$dataReserva', '$telefoneUsuario', '$emailUsuario', '$senhaUsuario')";

                // Inclui o arquivo de conexão com o Banco de Dados
                include "conexaoBD.php";
                
                // Executa a QUERY
                if(mysqli_query($conn, $inserirUsuario)){
                    echo "<div class='alert alert-success text-center'>O cadastro do <strong>USUÁRIO</strong> foi efetuado com sucesso!</div>";
                    echo "
                        <div class='container'>
                            <table class='table'>
                                <tr>
                                    <th>NOME</th>
                                    <td>$nomeUsuario</td>
                                </tr>
                                <tr>
                                    <th>DATA DE RESERVA</th>
                                    <td>$diaReserva/$mesReserva/$anoReserva</td>
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
            exit(); // Boa prática após redirecionamentos
        }

        // Função para filtrar entrada de dados
        function filtrar_entrada($dado){
            $dado = trim($dado); 
            $dado = stripslashes($dado); 
            $dado = htmlspecialchars($dado); 
            return($dado);
        }
    ?>

<?php include "footer.php" ?>
