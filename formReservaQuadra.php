<?php include "header.php" ?>

<?php
    include "conexaoBD.php";
    if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
        // Redireciona imediatamente para a página de login
        header("Location: formLogin.php"); 
        exit(); // Interrompe a execução do resto do código
    }

    if($_GET['idQuadra']){
        $quadraSelecionada = $_GET['idQuadra'];
    }
?>

    <div class="d-flex justify-content-center mb-3">
        <form action="actionReservaQuadra.php" method="POST" class="was-validated" enctype="multipart/form-data">

            <div class="form-floating mt-3 mb-3">
                <input type="text" name="nomeUsuario" id="nomeUsuario" placeholder="Nome Completo" class="form-control" value="<?php echo $nomeUsuario; ?>" readonly>
                <label for="nomeReservante">Nome Reservante</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
                <!-- Usa o $idUsuario do seu header no campo escondido -->
                <input type="hidden" name="idReservante" value="<?php echo $idUsuario; ?>">
            </div>



    <div class="form-floating mt-3 mb-3">
        <select name="nomeQuadra" id="nomeQuadra" placeholder="Quadra" class="form-control">
            <?php
            include "conexaoBD.php";
                $listarQuadras = "SELECT * FROM Quadras";
                $res = mysqli_query($conn, $listarQuadras) or die("Erro ao tentar carregar Quadras");
                while($registro = mysqli_fetch_assoc($res)){
                    $idQuadra   = $registro['idQuadra'];
                    $nomeQuadra = $registro['nomeQuadra'];
                    if($idQuadra == $quadraSelecionada){
                        echo "<option value='$idQuadra'>$nomeQuadra</option>";
                    }
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
                
                <input type="date" name="dataReserva" id="dataReserva" class="form-control" min="<?php echo $dataMinima; ?>">
                <label for="dataReserva">Data Reserva</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>
            

            <div class="form-floating mt-3 mb-3">
                <input type="time" name="horarioInicio" id="horarioInicio" placeholder="Horário para começar a usar a quadra" class="form-control" step="3600">
                <label for="horarioInicio">Horario inicio de uso</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
                <div class="invalid-feedback">O horário deve ser em horas cheias (ex: 13:00).</div>
            </div>

            <div class="form-floating mt-3 mb-3">
                <input type="time" name="horarioFim" id="horarioFim" placeholder="Horário para terminar de usar a quadra" class="form-control" step="3600">
                <label for="horarioFim">Horario do término de uso</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
                <div class="invalid-feedback">O horário deve ser em horas cheias (ex: 13:00).</div>
            </div>
            <button type="submit" class="btn btn-outline-dark">Cadastrar</button>

        </form>

    </div>



<?php include "footer.php" ?>