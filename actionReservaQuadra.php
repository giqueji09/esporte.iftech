<?php include "header.php" ?>

    <?php
        // Verifica se o método de envio das informações do form é "POST"
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            
            $idReservante = $idQuadraReservada = $dataReserva = $horarioInicio = $horarioFim = "";
            $erroPreenchimento = false;

            if(empty($_POST["idReservante"])){
                echo "<div class='alert alert-warning text-center'>Erro de identificação do usuário. Faça login novamente!</div>";
                $erroPreenchimento = true;
            } else {
                $idReservante = filtrar_entrada($_POST["idReservante"]);
            }

            if(empty($_POST["nomeQuadra"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>QUADRA</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            } else {
                $idQuadraReservada = filtrar_entrada($_POST["nomeQuadra"]);
            }

            // Validação da Data de Reserva
            if(empty($_POST["dataReserva"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>DATA DE RESERVA</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            } else {
                $dataReserva = filtrar_entrada($_POST["dataReserva"]);
            } 

            // Validação do Horário de Início
            if(empty($_POST["horarioInicio"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>HORÁRIO DE INÍCIO</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            } else {
                $horarioInicio = filtrar_entrada($_POST["horarioInicio"]);
            }

            // Validação do Horário de Término
            if(empty($_POST["horarioFim"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>HORÁRIO DE TÉRMINO</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            } else {
                $horarioFim = filtrar_entrada($_POST["horarioFim"]);
            }

// Executa a inserção se não houver erros
            if(!$erroPreenchimento){

                // Query alinhada com a estrutura da tabela
                $inserirReserva = "INSERT INTO reservas (idReservante, idQuadraReservada, dataReserva, horarioInicio, horarioFim) 
                                   VALUES ('$idReservante', '$idQuadraReservada', '$dataReserva', '$horarioInicio', '$horarioFim')";

                // Inclui o arquivo de conexão
                include "conexaoBD.php";
                
                // Executa a QUERY
                if(mysqli_query($conn, $inserirReserva)){

                    $nomeDoUsuarioExibicao = "";
                    if(isset($_POST["nomeUsuario"])){
                        $nomeDoUsuarioExibicao = filtrar_entrada($_POST["nomeUsuario"]);
                    }

                    $nomeDaQuadraExibicao = "ID: " . $idQuadraReservada; // Valor de fallback
                    $buscarNomeQuadra = "SELECT nomeQuadra FROM Quadras WHERE idQuadra = '$idQuadraReservada'";
                    $resultadoQuadra = mysqli_query($conn, $buscarNomeQuadra);
                    
                    if($registroQuadra = mysqli_fetch_assoc($resultadoQuadra)){
                        $nomeDaQuadraExibicao = $registroQuadra['nomeQuadra'];
                    }

                    //Usa a função mysqli_query() para executar a QUERY no Banco de Dados
                    //Se conseguir, exibe alerta de sucesso e tabela com os dados informados
                    echo "<div class='alert alert-success text-center'>A <strong>RESERVA</strong> foi efetuada com sucesso!</div>";
                    echo "
                            <table class='table'>
                                <tr>
                                    <th>NOME DO RESERVANTE</th>
                                    <td>$nomeDoUsuarioExibicao</td>
                                </tr>
                                <tr>
                                    <th>QUADRA</th>
                                    <td>$nomeDaQuadraExibicao</td>
                                </tr>
                                <tr>
                                    <th>DATA</th>
                                    <td>".date('d/m/Y', strtotime($dataReserva))."</td>
                                </tr>
                                <tr>
                                    <th>HORÁRIO</th>
                                    <td>$horarioInicio às $horarioFim</td>
                                </tr>
                            </table>
                    ";
                }
                else{
                    echo "<div class='alert alert-danger text-center'>Erro ao tentar cadastrar a <strong>RESERVA</strong> no banco de dados!</div>";
                }
            }

        }
        else{
            //Usa a função header() para redirecionar o usuário para o formUsuario.php
            header("location:quadras.php");
            exit(); 
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