<?php
date_default_timezone_set('America/Sao_Paulo');

session_start();
if (($_SESSION['perfil'] ?? '') !== 'administrador') {
    header('Location: login_usuarios.php');
    exit;
}

$pagamentos = require __DIR__ . '/../models/pagamentos_teste.php';
$usuarios = require __DIR__ . '/../models/usuarios_teste.php';

// Formata 11111111111 => 111.111.111-11
function formatarCpf(string $cpf): string
{
    return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf);
}

// Formata 150.5 => R$ 150,50
function formatarMoeda(float $valor): string
{
    return 'R$ ' . number_format($valor, 2, ',', '.');
}

// Cor do badge para cada perfil
$coresPerfil = [
    'paciente'       => 'bg-info text-dark',
    'recepcionista'  => 'bg-warning text-dark',
    'fisioterapeuta' => 'bg-success',
    'administrador'  => 'bg-danger',
];

// ------------------------------
// Dados financeiros fictícios
// ------------------------------


$nomesMes = [
    '2026-10' => 'Outubro de 2026',
    '2026-11' => 'Novembro de 2026',
];

// Agrupa os pagamentos por mês e calcula os totais
$porMes = array_fill_keys(array_keys($nomesMes), []);
foreach ($pagamentos as $pg) {
    $porMes[substr($pg['data'], 0, 7)][] = $pg;
}

$totais = [];
foreach ($porMes as $mes => $lista) {
    $totais[$mes] = array_sum(array_column($lista, 'valor'));
}
$totalGeral = array_sum($totais);

// Variação de novembro em relação a outubro
$variacao = $totais['2026-10'] > 0
    ? (($totais['2026-11'] - $totais['2026-10']) / $totais['2026-10']) * 100
    : 0;
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

        <div class="painel-cabecalho mb-4">
            <span class="selo-clinica mb-2 d-inline-block">Administração</span>
            <p class="mb-0">Olá, <?= htmlspecialchars($_SESSION['nome'], ENT_QUOTES, 'UTF-8') ?>.</p>
        </div>
        <div class="mt-1 mb-3">
            <h2 class="h4 fw-bold mb-1">Usuários</h2>
            <p class="text-muted mb-0">Gerencie os usuários do sistema.</p>
        </div>

        <div class="card shadow">
            <div class="card-body">

                <div class="row mb-4 g-2 align-items-center">
                    <div class="col-12 col-md-6">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Pesquisar por nome, CPF ou perfil...">
                            <button class="btn btn-primary" type="button">Pesquisar</button>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 text-md-end">
                        <button type="button" class="btn btn-success">+ Adicionar usuário</button>
                    </div>
                </div>

                <!-- Tabela de usuários -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>Perfil</th>
                                <th class="text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $cpf => $u): ?>
                                <tr>
                                    <td><?= htmlspecialchars($u['nome'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td><?= formatarCpf($cpf) ?></td>
                                    <td>
                                        <span class="badge <?= $coresPerfil[$u['perfil']] ?? 'bg-secondary' ?>">
                                            <?= htmlspecialchars(ucfirst($u['perfil']), ENT_QUOTES, 'UTF-8') ?>
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-sm btn-outline-primary">Editar</button>
                                        <button type="button" class="btn btn-sm btn-outline-danger">Excluir</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <!-- ==============================
             FINANCEIRO
        ============================== -->
        <div class="mt-5 mb-3">
            <h2 class="h4 fw-bold mb-1">Financeiro</h2>
            <p class="text-muted mb-0">Consultas pagas em outubro e novembro.</p>
        </div>

        <!-- Cards de resumo -->
        <div class="row g-3 mb-4">
            <div class="col-12 col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted small">Receita de novembro</div>
                        <div class="h4 fw-bold mb-1"><?= formatarMoeda($totais['2026-11']) ?></div>
                        <span class="badge <?= $variacao >= 0 ? 'bg-success' : 'bg-danger' ?>">
                            <?= $variacao >= 0 ? '▲' : '▼' ?>
                            <?= number_format(abs($variacao), 1, ',', '.') ?>% vs. outubro
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted small">Receita de outubro</div>
                        <div class="h4 fw-bold mb-1"><?= formatarMoeda($totais['2026-10']) ?></div>
                        <span class="text-muted small"><?= count($porMes['2026-10']) ?> consultas pagas</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted small">Total no período</div>
                        <div class="h4 fw-bold mb-1"><?= formatarMoeda($totalGeral) ?></div>
                        <span class="text-muted small"><?= count($pagamentos) ?> consultas pagas</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Uma tabela por mês (novembro primeiro) -->
        <?php foreach (array_reverse($porMes, true) as $mes => $lista): ?>
            <div class="card shadow mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <span class="fw-bold"><?= $nomesMes[$mes] ?></span>
                    <span class="badge bg-success"><?= count($lista) ?> pagamentos</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Paciente</th>
                                    <th>CPF</th>
                                    <th>Data</th>
                                    <th>Forma de pagamento</th>
                                    <th>Situação</th>
                                    <th class="text-end">Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($lista as $pg): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($pg['paciente'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?= formatarCpf($pg['cpf']) ?></td>
                                        <td><?= date('d/m/Y', strtotime($pg['data'])) ?></td>
                                        <td><?= htmlspecialchars($pg['forma'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><span class="badge bg-success">Pago</span></td>
                                        <td class="text-end"><?= formatarMoeda($pg['valor']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="table-light fw-bold">
                                    <td colspan="5" class="text-end">Total do mês</td>
                                    <td class="text-end"><?= formatarMoeda($totais[$mes]) ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>

    <?php require __DIR__ . '/layout/footer.php'; ?>