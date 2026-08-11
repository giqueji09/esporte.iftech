<?php include "header.php"?>

<div class="d-flex justify-content-center mb-3">
        <h2>Cadastre a quadra</h2>
</div>

    <div class="d-flex justify-content-center mb-3">
        <form action="actionQuadra.php" method="POST" class="was-validated" enctype="multipart/form-data">

            <div class="form-floating mt-3 mb-3">
                <input type="file" name="fotoQuadra" id="fotoQuadra" placeholder="Foto da quadra" class="form-control">
                <label for="fotoQuadra">Foto da quadra</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>


            <div class="form-floating mt-3 mb-3">
                <input type="text" name="nomeQuadra" id="nomeQuadra" placeholder="Nome da quadra" class="form-control">
                <label for="nomeQuadra">Nome da quadra</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>


            <div class="form-floating mt-3 mb-3">
                <input type="text" name="esportes" id="esportes" placeholder="Futsal, basquete, poliesportiva e etc." class="form-control">
                <label for="esportes">Esportes práticaveis na quadra</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-floating mt-3 mb-3">
                <input type="text" name="localizacao" id="localizacao" placeholder="Digite o endereço da quadra que aparece no mapa" class="form-control ">
                <label for="localizacao">Localização de acordo com o mapa</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-floating mt-3 mb-3">
                <input type="time" name="horarioAbertura" id="horarioAbertura" placeholder="Horário que a quadra abre" class="form-control">
                <label for="horarioAbertura">Horário de abertura</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-floating mt-3 mb-3">
                <input type="time" name="horarioFechamento" id="horarioFechamento" placeholder="Horário em que a quadra se fecha" class="form-control" minlength="3" maxlength="8">
                <label for="horarioFechamento">Horário Fechamento</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>


            <button type="submit" class="btn btn-outline-dark">Cadastrar</button>

        </form>

    </div>

<?php include "footer.php"?>