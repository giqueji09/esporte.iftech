<?php include "header.php"?>

<?php 
    echo "<h1>Reservas de $primeiroNome</h1>";
    include "conexaoBD.php";
    $atualizarStatusConcluido = "
        UPDATE reservas
        SET statusReserva = 'concluída'
        WHERE statusReserva = 'agendado'
        AND CONCAT(dataReserva, ' ', horarioFim) <= NOW()";

        mysqli_query($conn, $atualizarStatusConcluido);

    $reservasUsuario = "
   SELECT
        reservas.idReserva,
        quadras.nomeQuadra, 
        reservas.dataReserva, 
        reservas.horarioInicio, 
        reservas.horarioFim, 
        reservas.statusReserva
    FROM 
        reservas
    INNER JOIN 
        quadras ON reservas.idQuadraReservada = quadras.idQuadra
    WHERE 
        reservas.idReservante = '$idUsuario'
    ORDER BY 
        reservas.dataReserva ASC";;
    
    $res           = mysqli_query($conn, $reservasUsuario) or die("Erro ao tentar listar Usuários!");
    $totalReservas = mysqli_num_rows($res); //A função mysqli_num_rows retorna a quantidade de registros encontrados pela QUERY

    echo "<div class='alert alert-info text-center'>Há <strong>$totalReservas</strong> reservas suas cadastradas no sistema!</div>";

    //2ª Parte: Exibe o cabeçalho da tabela
    echo "
        <div class='table-responsive'>
        <table class='table'>
            <thead class='table-dark'>
                <tr>
                    <th>NOME QUADRA</th>
                    <th>DATA DE RESERVA</th>
                    <th>HORÁRIO INICIO RESERVA</th>
                    <th>HORÁRIO FIM DA RESERVA</th>
                    <th>STATUS RESERVA</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
    ";

    //3ª Parte: Usa o comando while para armazenar os registros do Banco de Dados em um Array Associativo
    while($reservas = mysqli_fetch_assoc($res)){
        $idReserva           = $reservas['idReserva'];
        $nomeQuadra          = $reservas['nomeQuadra'];
        $dataReserva         = $reservas['dataReserva'];
        $diaReserva          = substr($dataReserva, 8, 2);
        $mesReserva          = substr($dataReserva, 5, 2);
        $anoReserva          = substr($dataReserva, 0, 4);
        $horarioInicio       = $reservas['horarioInicio'];
        $horarioFim          = $reservas['horarioFim'];
        $statusReserva       = $reservas['statusReserva'];

        $botaoCancelar = "";
        
        if($statusReserva == 'agendado'){
            $botaoCancelar = "<a href='cancelarReserva.php?id=$idReserva' class='btn btn-danger btn-sm' title='Cancelar reserva'><i class='bi bi-x-circle'></i> Cancelar</a>";
        } else if($statusReserva == 'cancelada'){
            $botaoCancelar = "<span class='text-muted'>Já Cancelada</span>";
        } else if($statusReserva == 'concluída') {
            $botaoCancelar = "<span class='text-success'>Já Concluída</span>";
        }

        //4ª Parte: Exibe os registros armazenados nas variáveis
        echo "
            <tr>
                <td>$nomeQuadra</td>
                <td>$diaReserva/$mesReserva/$anoReserva</td>
                <td>$horarioInicio</td>
                <td>$horarioFim</td>
                <td>$statusReserva</td>
                <td>$botaoCancelar</td>
            </tr>
        ";
    }
    // 5ª Parte: Encerra a tabela e a conexão com o Banco de Dados
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    mysqli_close($conn); //Encerra a conexão com o Banco de Dados
?>

<?php include "footer.php"?>