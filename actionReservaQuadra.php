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

            // Validação do Esporte Reserva
            if(empty($_POST["esporteReserva"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>ESPORTE RESERVA</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            } else {
                $esporteReserva = filtrar_entrada($_POST["esporteReserva"]);
            }

            // Executa as verificações de regras de negócio se não houver erros básicos de preenchimento
            if(!$erroPreenchimento){
                
                // Inclui o arquivo de conexão mais cedo para poder fazer as consultas de validação
                include "conexaoBD.php";

                //Validação de Duração (Máximo de 2 horas e término após o início)
                $inicioTimestamp = strtotime($horarioInicio);
                $fimTimestamp = strtotime($horarioFim);
                $diferencaSegundos = $fimTimestamp - $inicioTimestamp;
                
                // 7200 segundos = 2 horas (60 * 60 * 2)
                if($diferencaSegundos <= 0){
                    echo "<div class='alert alert-warning text-center'>O horário de término deve ser posterior ao horário de início!</div>";
                    $erroPreenchimento = true;
                } else if ($diferencaSegundos > 7200) {
                    echo "<div class='alert alert-warning text-center'>Só são permitidas reservas de no máximo <strong>2 horas</strong>!</div>";
                    $erroPreenchimento = true;
                }

                date_default_timezone_set('America/Sao_Paulo');

                if(!$erroPreenchimento){
                    $dataAtual = date('Y-m-d');
                    
                    if($dataReserva < $dataAtual){
                        echo "<div class='alert alert-warning text-center'>Não é possível realizar reservas para <strong>datas que já passaram</strong>!</div>";
                        $erroPreenchimento = true;
                    } 
                    else if ($dataReserva == $dataAtual) {
                        $horarioAtual = date('H:i');
                        if($horarioInicio < $horarioAtual){
                            echo "<div class='alert alert-warning text-center'>Não é possível agendar para um <strong>horário que já passou</strong> no dia de hoje!</div>";
                            $erroPreenchimento = true;
                        }
                    }
                }

                //Validação de Duração (Máximo de 2 horas e término após o início)
                $inicioTimestamp = strtotime($horarioInicio);

                //Apenas uma reserva por dia por usuário
                if(!$erroPreenchimento){
                    $checarReservaUsuario = "SELECT idReserva FROM reservas WHERE idReservante = '$idReservante' AND dataReserva = '$dataReserva'";
                    $resultadoUsuario = mysqli_query($conn, $checarReservaUsuario);
                    
                    if(mysqli_num_rows($resultadoUsuario) > 0){
                        echo "<div class='alert alert-warning text-center'>Você já possui uma reserva agendada para o dia <strong>".date('d/m/Y', strtotime($dataReserva))."</strong>. É permitida apenas uma reserva por dia!</div>";
                        $erroPreenchimento = true;
                    }
                }

                // Validação de Horário de Funcionamento da Quadra
                if(!$erroPreenchimento){
                    $queryHorarios = "SELECT horarioAbertura, horarioFechamento FROM quadras WHERE idQuadra = '$idQuadraReservada'";
                    $resultadoHorarios = mysqli_query($conn, $queryHorarios);
                    
                    if($dadosQuadra = mysqli_fetch_assoc($resultadoHorarios)){
                        $horarioAbertura = $dadosQuadra['horarioAbertura'];
                        $horarioFechamento = $dadosQuadra['horarioFechamento'];

                        // Verifica se o início é antes da abertura ou se o fim é depois do fechamento
                        if($horarioInicio < $horarioAbertura || $horarioFim > $horarioFechamento){
                            // Formata os horários para exibição amigável (sem os segundos)
                            $aberturaFormatada = date('H:i', strtotime($horarioAbertura));
                            $fechamentoFormatado = date('H:i', strtotime($horarioFechamento));
                            
                            echo "<div class='alert alert-warning text-center'>A quadra selecionada funciona apenas das <strong>$aberturaFormatada</strong> às <strong>$fechamentoFormatado</strong>!</div>";
                            $erroPreenchimento = true;
                        }
                    }
                }

                //Prevenção de conflito de horários no mesmo local
                if(!$erroPreenchimento){
                    // A lógica verifica se existe alguma reserva onde o Início é menor que o Novo Fim E o Fim é maior que o Novo Início
                    $checarConflitoLocal = "SELECT idReserva FROM reservas WHERE idQuadraReservada = '$idQuadraReservada' AND dataReserva = '$dataReserva' AND horarioInicio < '$horarioFim' AND horarioFim > '$horarioInicio'";
                    $resultadoConflito = mysqli_query($conn, $checarConflitoLocal);
                    
                    if(mysqli_num_rows($resultadoConflito) > 0){
                        echo "<div class='alert alert-warning text-center'>Este horário já está reservado ou entra em conflito com outra reserva nesta quadra!</div>";
                        $erroPreenchimento = true;
                    }
                }



                // Se passou por todas as regras de negócio, executa a inserção
                if(!$erroPreenchimento){

                    
                    
                    if($horarioInicio)
                    // Query alinhada com a estrutura da tabela
                    $inserirReserva = "INSERT INTO reservas (idReservante, idQuadraReservada, dataReserva, horarioInicio, horarioFim, esporteReserva) 
                                       VALUES ('$idReservante', '$idQuadraReservada', '$dataReserva', '$horarioInicio', '$horarioFim', '$esporteReserva')";
                    
                    // Executa a QUERY principal
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

                        // Exibe alerta de sucesso e tabela com os dados informados
                        echo "<div class='alert alert-success text-center'>A <strong>RESERVA</strong> foi efetuada com sucesso!</div>";
                        echo "
                            <div class='container'>
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
                                    <tr>
                                        <th>ESPORTE RESERVA</th>
                                        <td>$esporteReserva</td>
                                    </tr>
                                </table>
                            </div>
                        ";
                    }
                    else{
                        echo "<div class='alert alert-danger text-center'>Erro ao tentar cadastrar a <strong>RESERVA</strong> no banco de dados!</div>";
                    }
                }
            }

        }
        else{
            // Redireciona o usuário
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