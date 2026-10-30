<?php
session_start();
if (($_SESSION['perfil'] ?? '') !== 'paciente') {
    header('Location: login_usuarios.php');   // mesmo nome da sua tela de login
    exit;
}
?>
<?php require __DIR__ . '/layout/header.php'; ?>
<body>

<nav class="navbar navbar-sgcf sticky-top">
    <div class="container-fluid">
        <span class="navbar-brand text-white">Clínica Dr. Gabriel Alves</span>
        <a class="btn btn-colaborador" href="../controller/controle_de_login.php?acao=logout">Sair</a>
    </div>
</nav>

<div class="container py-5">
    <div class="card shadow">
        <div class="card-body text-center py-5">
            <h1 class="h3 fw-bold mb-2">Painel do paciente</h1>
            <p class="text-muted mb-0">Olá, <?= htmlspecialchars($_SESSION['nome'], ENT_QUOTES, 'UTF-8') ?>. Tela em construção.</p>
        </div>
    </div>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>