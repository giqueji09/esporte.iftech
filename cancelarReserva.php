<?php include "header.php"?>

<?php 
    include "conexaoBD.php";
    if(isset($_GET['id'])){
        $idReserva = $_GET['id'];

        $queryCancelar = "UPDATE reservas 
        SET statusReserva = 'cancelada'
        WHERE idReserva = $idReserva";

        if(mysqli_query($conn, $queryCancelar)){
            header("Location: minhasReservas.php");
            exit();
        } else{
            echo "Erro ao cancelar reserva";
        }
    } else{
        "ID da reserva não informado";
    }
?>

<?php include "footer.php"?>