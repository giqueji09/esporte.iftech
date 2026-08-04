<?php

    $hostBD   = "localhost"; //Define o local do servidor de BD
    $userBD   = "root"; //Define o usuário do BD (Padrão: root)
    $senhaBD  = "root"; //Define a senha do BD (Padrão: "" [Em Branco]). No IF deve estar como "root".
    $database = "reservai"; //Define com qual base será realizada a conexão

    //Função do PHP para estabelecer a conexão com o BD
    $conn     = mysqli_connect($hostBD, $userBD, $senhaBD, $database);

    //Verificar se há conexão com o BD
    if(!$conn){
        echo "<p>Erro ao tentar conectar a aplicação à base de dados <strong>$database</strong>!";
    }

?>
