<? php
// Inicializa a sessão
session_start ();
 
// Verifique se o usuário já está logado, em caso afirmativo, redirecione-o para a página de boas-vindas
if (isset ($ _ SESSION ["registrado"]) && $ _SESSION ["registrado"] === verdadeiro) {
    cabeçalho ("localização: welcome.php");
    saída;
}
 
// Incluir arquivo de configuração
require_once "config.php";
 
// Definir variáveis ​​e inicializar com valores vazios
$ username = $ password = "";
$ username_err = $ password_err = $ login_err = "";
 
// Processando dados do formulário quando o formulário é enviado
if ($ _ SERVER ["REQUEST_METHOD"] == "POST") {
 
    // Verifique se o nome de usuário está vazio
    if (vazio (trim ($ _ POST ["nome de usuário"]))) {
        $ username_err = "Por favor insira o nome de usuário.";
    } senão{
        $ username = trim ($ _ POST ["username"]);
    }
    
    // Verifique se a senha está vazia
    if (vazio (trim ($ _ POST ["senha"]))) {
        $ password_err = "Por favor, insira sua senha.";
    } senão{
        $ senha = trim ($ _ POST ["senha"]);
    }
    
    // Validar credenciais
    if (vazio ($ username_err) && vazio ($ password_err)) {
        // Prepare uma declaração selecionada
        $ sql = "SELECIONE id, nome de usuário, senha FROM usuários WHERE nome de usuário =?";
        
        if ($ stmt = $ mysqli-> prepare ($ sql)) {
            // Vincule as variáveis ​​à instrução preparada como parâmetros
            $ stmt-> bind_param ("s", $ param_username);
            
            // Definir parâmetros
            $ param_username = $ username;
            
            // Tenta executar a instrução preparada
            if ($ stmt-> execute ()) {
                // Resultado da loja
                $ stmt-> store_result ();
                
                // Verifique se o nome de usuário existe, se sim, verifique a senha
                if ($ stmt-> num_rows == 1) {                    
                    // Vincular variáveis ​​de resultado
                    $ stmt-> bind_result ($ id, $ username, $ hashed_password);
                    if ($ stmt-> fetch ()) {
                        if (password_verify ($ password, $ hashed_password)) {
                            // A senha está correta, então inicie uma nova sessão
                            session_start ();
                            
                            // Armazena dados em variáveis ​​de sessão
                            $ _SESSION ["registrado"] = verdadeiro;
                            $ _SESSION ["id"] = $ id;
                            $ _SESSION ["username"] = $ username;                            
                            
                            // Redireciona o usuário para a página de boas-vindas
                            cabeçalho ("localização: welcome.php");
                        } senão{
                            // A senha não é válida, exibe uma mensagem de erro genérica
                            $ login_err = "Nome de usuário ou senha inválidos.";
                        }
                    }
                } senão{
                    // O nome de usuário não existe, exibe uma mensagem de erro genérica
                    $ login_err = "Nome de usuário ou senha inválidos.";
                }
            } senão{
                echo "Ops! Algo deu errado. Por favor, tente novamente mais tarde.";
            }

            // Fechar declaração
            $ stmt-> close ();
        }
    }
    
    // Fechar conexão
    $ mysqli-> close ();
}
?>
 
<! DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <title> Login </title>
    <link rel = "stylesheet" href = "https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        corpo {fonte: 14px sem serifa; }
        .wrapper {largura: 360px; preenchimento: 20px; }
    </style>
</head>
<body>
    <div class = "wrapper">
        <h2> Login </h2>
        <p> Por favor, preencha suas credenciais para fazer o login. </p>

        <? php 
        if (! empty ($ login_err)) {
            echo '<div class = "alert alert-danger">'. $ login_err. '</div>';
        }        
        ?>

        <form action = "<? php echo htmlspecialchars ($ _ SERVER [" PHP_SELF "]);?>" method = "post">
            <div class = "form-group">
                <label> Nome do usuário </label>
                <input type = "text" name = "username" class = "form-control <? php echo (! empty ($ username_err))? 'is-invalid': '';?>" value = "<? php echo $ username;?> ">
                <span class = "invalid-feedback"> <? php echo $ username_err; ?> </span>
            </div>    
            <div class = "form-group">
                <label> Senha </label>
                <input type = "password" name = "password" class = "form-control <? php echo (! empty ($ password_err))? 'is-invalid': '';?>">
                <span class = "invalid-feedback"> <? php echo $ password_err; ?> </span>
            </div>
            <div class = "form-group">
                <input type = "submit" class = "btn btn-primary" value = "Login">
            </div>
            <p> Não possui conta? <a href="register.php"> faça-se agora </a>. </p>
        </form>
    </div>
</body>
</html>