<?php include "header.php"?>

<?php 
    include "conexaoBD.php";
     //Verifica se o método de envio das informações do form é "POST"
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //Cria variáveis para armazenar as informações recebidas do array $_POST
        // Adicionado $cpfUsuario na inicialização das variáveis
        $quadra = $dataInicial = $dataFinal = "";

        //Variável booleana para controle de erros de preenchimento
        $erroPreenchimento = false;

        if(empty($_POST["nomeQuadra"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>QUADRA</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            } else {
                $quadra = filtrar_entrada($_POST["nomeQuadra"]);
            }

        if(empty($_POST["dataInicial"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>DATA INICIAL</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            } else {
                $dataInicial = filtrar_entrada($_POST["dataInicial"]);
            }
            
        if(empty($_POST["dataFinal"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>DATA Final</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            } else {
                $dataFinal = filtrar_entrada($_POST["dataFinal"]);
            }

        // Verifica se não há erro de preenchimento
        if(!$erroPreenchimento){

            // Adicionado 'quadras.nomeQuadra' na query para podermos exibi-la na tabela
            // Adicionado INNER JOIN com 'usuarios' para buscar o cpfUsuario
            $verReservas = "
                SELECT 
                    reservas.*, 
                    quadras.nomeQuadra,
                    usuarios.cpfUsuario
                FROM reservas 
                INNER JOIN quadras ON reservas.idQuadraReservada = quadras.idQuadra 
                INNER JOIN usuarios ON reservas.idReservante = usuarios.idUsuario
                WHERE reservas.idQuadraReservada = $quadra 
                AND reservas.dataReserva BETWEEN '$dataInicial' AND '$dataFinal'
                AND statusReserva = 'agendado'
            ";
            
            $res           = mysqli_query($conn, $verReservas) or die("Erro ao tentar listar Reservas: " . mysqli_error($conn));
            $totalReservas = mysqli_num_rows($res);

            // 2ª Parte: Exibe o cabeçalho da tabela com 7 colunas
            echo "
                <div class='table-responsive'>
                <table class='table'>
                    <thead class='table-dark'>
                        <tr>
                            <th>NOME QUADRA</th>
                            <th>DATA DE RESERVA</th>
                            <th>HORÁRIO INICIO RESERVA</th>
                            <th>HORÁRIO FIM DA RESERVA</th>
                            <th>ESPORTE RESERVA</th>
                            <th>STATUS RESERVA</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
            ";

// 3ª Parte: Laço while
            while($horariosReservasQuadras = mysqli_fetch_assoc($res)){
                $idReserva       = $horariosReservasQuadras['idReserva'];
                $cpfUsuario      = $horariosReservasQuadras['cpfUsuario']; // <-- Nova variável puxando o CPF
                $nomeQuadra      = $horariosReservasQuadras['nomeQuadra']; 
                $dataReserva     = $horariosReservasQuadras['dataReserva'];
                $diaReserva      = substr($dataReserva, 8, 2);
                $mesReserva      = substr($dataReserva, 5, 2);
                $anoReserva      = substr($dataReserva, 0, 4);
                $horarioInicio   = $horariosReservasQuadras['horarioInicio'];
                $horarioFim      = $horariosReservasQuadras['horarioFim'];
                $esporteReserva  = $horariosReservasQuadras['esporteReserva'];
                $statusReserva   = $horariosReservasQuadras['statusReserva'];

                if($nivelUsuario == 'administrador'){
                    // O admin agora exibe o CPF em vez do ID do reservante
                    echo "
                    <tr>
                        <td>$nomeQuadra (ID Reserva: $idReserva, CPF Reservante: $cpfUsuario)</td>
                        <td>$diaReserva/$mesReserva/$anoReserva</td>
                        <td>$horarioInicio</td>
                        <td>$horarioFim</td>
                        <td>$esporteReserva</td>
                        <td>$statusReserva</td>
                        <td></td>
                    </tr>
                    ";
                }
                else{
                    // O usuário comum continua vendo apenas o nome da quadra
                    echo "
                    <tr>
                        <td>$nomeQuadra</td>
                        <td>$diaReserva/$mesReserva/$anoReserva</td>
                        <td>$horarioInicio</td>
                        <td>$horarioFim</td>
                        <td>$esporteReserva</td>
                        <td>$statusReserva</td>
                        <td></td>
                    </tr>
                    ";
                }
            }
            
            // CORREÇÃO: Fechamento obrigatório das tags abertas antes do while
            echo "
                    </tbody>
                </table>
                </div>
            ";
        
        }
    }

    // Função para filtrar entrada de dados
        function filtrar_entrada($dado){
            $dado = trim($dado); 
            $dado = stripslashes($dado); 
            $dado = htmlspecialchars($dado); 
            return($dado);
        }

?>

<?php include "footer.php"?>