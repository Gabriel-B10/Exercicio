<? php

/ * Credenciais do banco de dados. Supondo que você esteja executando o MySQL

servidor com configuração padrão (usuário 'root' sem senha) * /

define ('DB_SERVER', 'localhost');

define ('DB_USERNAME', 'root');

define ('DB_PASSWORD', 'aluno');

define ('DB_NAME', 'ifome');

 

/ * Tentativa de conexão ao banco de dados MySQL * /

$ mysqli = novo mysqli (DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

 

// Verifique a conexão

if ($ mysqli === false) {

    die ("ERROR: Não foi possível conectar.". $ mysqli-> connect_error);

}

?>