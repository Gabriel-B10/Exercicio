<? php
// Inicializa a sessão
session_start ();
 
// Verifique se o usuário está logado, se não, redirecione-o para a página de login
if (! isset ($ _ SESSION ["loggingin"]) || $ _SESSION ["loggedin"]! == true) {
    cabeçalho ("localização: login.php");
    saída;
}
?>
 
<! DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <title> Bem-vindo </title>
    <link rel = "stylesheet" href = "https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        corpo {fonte: 14px sem serifa; alinhamento de texto: centro; }
    </style>
</head>
<body>
    <h1 class = "my-5"> Olá, <b> <? php echo htmlspecialchars ($ _ SESSION ["username"]); ?> </b> .Seja Bem vindo ao nosso site. </h1>
    p
        <a href="reset-password.php" class="btn btn-warning"> Redefina sua senha </a>
        <a href="logout.php" class="btn btn-danger ml-3"> Saia da sua conta </a>
    </p>
</body>
</html>