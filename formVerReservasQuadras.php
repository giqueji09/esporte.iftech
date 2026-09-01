<?php include "header.php"?>

    <div class="d-flex justify-content-center mb-3">
        <form action="actionVerReservasQuadra.php" method="POST" class="was-validated" enctype="multipart/form-data">




    <div class="form-floating mt-3 mb-3">
        <select name="nomeQuadra" id="nomeQuadra" placeholder="Quadra" class="form-control">
            <?php
            include "conexaoBD.php";
                $listarQuadras = "SELECT * FROM Quadras";
                $res = mysqli_query($conn, $listarQuadras) or die("Erro ao tentar carregar Quadras");
                while($registro = mysqli_fetch_assoc($res)){
                    $idQuadra   = $registro['idQuadra'];
                    $nomeQuadra = $registro['nomeQuadra'];
                    echo "<option value='$idQuadra'>$nomeQuadra</option>";
                }
            ?>
        </select>
        <label for="nomeQuadra">Quadra</label>
    </div>

            <div class="form-floating mt-3 mb-3">
                <?php 
                    date_default_timezone_set('America/Sao_Paulo'); 
                    $dataMinima = date('Y-m-d'); 
                ?>
                
                <input type="date" name="dataInicial" id="dataInicial" class="form-control" min="<?php echo $dataMinima; ?>">
                <label for="dataInicial">Data Inicial</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-floating mt-3 mb-3">
                <?php 
                    date_default_timezone_set('America/Sao_Paulo'); 
                    $dataMinima = date('Y-m-d'); 
                ?>
                
                <input type="date" name="dataFinal" id="dataFinal" class="form-control" min="<?php echo $dataMinima; ?>">
                <label for="datafinal">Data Final</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>
            

            <button type="submit" class="btn btn-outline-dark">Visualizar</button>

        </form>

    </div>

<?php include "footer.php"?>