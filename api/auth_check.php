<?php
// Inicia a sessão em todas as páginas seguras
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se a variável de sessão 'loggedin' não está definida ou é falsa
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Se não estiver logado, redireciona para a página de login e encerra o script
    header('Location: login.html');
    exit;
}
?>
