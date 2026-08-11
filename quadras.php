<?php include "header.php" ?>

<div class="d-flex justify-content-center mb-3">
    <h2>Todas as Quadras Disponíveis</h2>
</div>

<?php
    // Query para listar TODOS os registros da tabela Quadras
    $listarQuadras = "SELECT * FROM Quadras";

    include "conexaoBD.php"; 
    $res          = mysqli_query($conn, $listarQuadras) or die("Erro ao tentar listar Quadras!");
    $totalQuadras = mysqli_num_rows($res); 

    // Abre a linha da grade antes do loop
    echo "<div class='row gx-3 gy-3 justify-content-center'>";

    while($Quadra = mysqli_fetch_assoc($res)){
        $idQuadra   = $Quadra['idQuadra'];
        $fotoQuadra = $Quadra['fotoQuadra'];
        $nomeQuadra = $Quadra['nomeQuadra'];
        $horarioAbertura = $Quadra['horarioAbertura'];
        $horarioFechamento = $Quadra['horarioFechamento'];

        $horarioAberturaCortada =  substr($horarioAbertura, 0, 5);
        $horarioFechamentoCortada = substr($horarioFechamento, 0, 5);

        // Cada quadra ganha sua própria coluna (ex: 4 quadras por linha em telas grandes)
        echo "
            <div class='col-6 col-sm-4 col-md-3'>
                <a class='portfolio-item text-decoration-none' href='formReservaQuadra.php?idQuadra=$idQuadra' style='border-radius: 15px; overflow: hidden; display: block;' title='Clique aqui para reservar a $nomeQuadra'>
                    <div class='caption-content mb-2' style='aspect-ratio: 4/3; overflow: hidden; border-radius: 10px;'>
                        <img class='img-fluid w-100 h-100' src='$fotoQuadra' style='object-fit: cover;'/>
                    </div>
                    <div class='h5 text-center' style='color: #1a2e17;'>$nomeQuadra</div>
                    <div class='p text-center' style='color: #1a2e17;'>Abre $horarioAberturaCortada até $horarioFechamentoCortada</div>

                </a>
            </div>
        ";
    }

    echo "</div>";
?>

<?php include "footer.php" ?>
