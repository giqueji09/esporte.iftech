<?php include "header.php" ?>


<div class="d-flex justify-content-center mb-3">
        <h2>Entre pro time</h2>
</div>

    <div class="d-flex justify-content-center mb-3">
        <form action="actionUsuario.php" method="POST" class="was-validated" enctype="multipart/form-data">

            <div class="form-floating mt-3 mb-3">
                <input type="text" name="nomeUsuario" id="nomeUsuario" placeholder="Nome Completo" class="form-control">
                <label for="nomeUsuario">Nome</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-floating mt-3 mb-3">
                <input type="text" name="cpfUsuario" id="cpfUsuario" placeholder="000.000.000-00" class="form-control" inputmode="numeric" maxlength="14" pattern="\d{3}\.?\d{3}\.?\d{3}-?\d{2}" >
                <label for="cpfUsuario">CPF</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-floating mt-3 mb-3">
                <input type="date" name="dataNascimentoUsuario" id="dataNascimentoUsuario" placeholder="Data de Nascimento" class="form-control">
                <label for="dataNascimentoUsuario">Data de Nascimento</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-floating mt-3 mb-3">
                <input type="tel" name="telefoneUsuario" id="telefoneUsuario" placeholder="Digite o número com ddd e sem espaço" class="form-control "  maxlength="11">
                <label for="telefoneUsuario">Telefone</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-floating mt-3 mb-3">
                <input type="email" name="emailUsuario" id="emailUsuario" placeholder="Email" class="form-control">
                <label for="emailUsuario">Email</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-floating mt-3 mb-3">
                <input type="password" name="senhaUsuario" id="senhaUsuario" placeholder="Senha" class="form-control" minlength="3" maxlength="8">
                <label for="senhaUsuario">Senha</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-floating mt-3 mb-3">
                <input type="password" name="confirmarSenhaUsuario" id="confirmarSenhaUsuario" placeholder="Confirme a Senha" class="form-control" minlength="3" maxlength="8">
                <label for="confirmarSenhaUsuario">Confirme a Senha</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>

            <button type="submit" class="btn btn-outline-dark">Cadastrar</button>

        </form>

    </div>

    <script>
        const cpfInput = document.getElementById('cpfUsuario');

    // Cria a máscara visual (000.000.000-00) enquanto o usuário digita
    cpfInput.addEventListener('input', (e) => {
        let value = e.target.value.replace(/\D/g, ''); // Remove tudo que não é número
        value = value.replace(/(\d{3})(\d)/, '$1.$2');       // Bloco 1
        value = value.replace(/(\d{3})(\d)/, '$1.$2');       // Bloco 2
        value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2'); // Bloco 3
        e.target.value = value;
    });

    // Remove os pontos e traços antes de enviar para o Banco de Dados
    document.querySelector('form').addEventListener('submit', (e) => {
        // Substitui o valor formatado apenas por números antes do envio
        cpfInput.value = cpfInput.value.replace(/\D/g, ''); 
    });
    </script>


<?php include "footer.php" ?>