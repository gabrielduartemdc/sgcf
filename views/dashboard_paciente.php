<?php
session_start();
if (($_SESSION['perfil'] ?? '') !== 'paciente') {
    header('Location: login_usuarios.php');   // mesmo nome da sua tela de login
    exit;
}

// DADOS DE EXEMPLO: depois trocar pelos dados reais do banco
$proxima_consulta = ['data' => '12/11/2026', 'hora' => '14:30'];
$fisioterapeuta   = 'Raquel Oliveira';
$tratamento       = 'Reabilitação de joelho';

$consultas = [
    ['data' => '12/11/2026', 'hora' => '14:30', 'profissional' => 'Raquel Oliveira', 'status' => 'Agendada'],
    ['data' => '05/11/2026', 'hora' => '10:00', 'profissional' => 'Raquel Oliveira', 'status' => 'Realizada'],
    ['data' => '29/10/2026', 'hora' => '09:00', 'profissional' => 'Raquel Oliveira', 'status' => 'Realizada'],
];

$cores_status = [
    'Agendada'  => 'bg-warning text-dark',
    'Realizada' => 'bg-success',
    'Cancelada' => 'bg-secondary',
];
?>
<?php require __DIR__ . '/layout/header.php'; ?>
<link rel="stylesheet" href="../css/dashboard_paciente.css">

<nav class="navbar navbar-sgcf sticky-top">
    <div class="container-fluid">
        <span class="navbar-brand text-white ms-3">Clínica Dr. Gabriel Alves</span>
        <a class="btn btn-colaborador me-3" href="../controller/controle_de_login.php?acao=logout">Sair</a>
    </div>
</nav>

<div class="container py-5">

    <!-- Saudação -->
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">Olá, <?= htmlspecialchars($_SESSION['nome'], ENT_QUOTES, 'UTF-8') ?>!</h1>
        <p class="text-muted mb-0">Acompanhe aqui suas consultas e o seu tratamento.</p>
    </div>

    <!-- Cards de resumo -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card  card-painel h-100">
                <div class="card-body">
                    <h2 class="h6 text-muted">Próxima consulta</h2>
                    <p class="h4 fw-bold mb-0"><?= htmlspecialchars($proxima_consulta['data']) ?></p>
                    <p class="text-muted mb-0">às <?= htmlspecialchars($proxima_consulta['hora']) ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card  card-painel h-100">
                <div class="card-body">
                    <h2 class="h6 text-muted">Fisioterapeuta</h2>
                    <p class="h5 fw-bold mb-0"><?= htmlspecialchars($fisioterapeuta) ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card  card-painel h-100">
                <div class="card-body">
                    <h2 class="h6 text-muted">Tratamento em andamento</h2>
                    <p class="h5 fw-bold mb-0"><?= htmlspecialchars($tratamento) ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabela de consultas -->
    <div class="card  card-painel">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h5 fw-bold mb-0">Minhas consultas</h2>
                <!-- Trocar o # pela página de agendamento quando existir -->
                <a href="#" class="btn btn-nova-consulta fw-semibold rounded-pill px-4">Agendar nova consulta</a>
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Hora</th>
                            <th>Profissional</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($consultas as $c): ?>
                            <tr>
                                <td><?= htmlspecialchars($c['data']) ?></td>
                                <td><?= htmlspecialchars($c['hora']) ?></td>
                                <td><?= htmlspecialchars($c['profissional']) ?></td>
                                <td>
                                    <span class="badge <?= $cores_status[$c['status']] ?? 'bg-secondary' ?>">
                                        <?= htmlspecialchars($c['status']) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php require __DIR__ . '/layout/footer.php'; ?>