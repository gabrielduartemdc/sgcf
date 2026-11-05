<?php
session_start();
if (($_SESSION['perfil'] ?? '') !== 'fisioterapeuta') {
    header('Location: login_usuarios.php');
    exit;
}

$consultas   = require __DIR__ . '/../models/consultas_teste.php';
$prontuarios = require __DIR__ . '/../models/prontuarios_teste.php';
$relatorios  = require __DIR__ . '/../models/relatorios_teste.php';

// Separa em atendidas e não atendidas
$atendidas    = array_filter($consultas, fn($c) => $c['atendida']);
$naoAtendidas = array_filter($consultas, fn($c) => !$c['atendida']);

function formatarCpf(string $cpf): string
{
    return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf);
}

function formatarData(string $data): string
{
    return date('d/m/Y', strtotime($data));
}

function formatarDataHora(string $dataHora): string
{
    return date('d/m/Y \à\s H:i', strtotime($dataHora));
}

// Busca o nome do paciente de uma consulta pelo id
function nomeDoPaciente(array $consultas, int $idConsulta): string
{
    foreach ($consultas as $c) {
        if ($c['id'] === $idConsulta) {
            return $c['paciente'];
        }
    }
    return '';
}
?>
<?php require __DIR__ . '/layout/header.php'; ?>

<style>
    /* Colunas com largura fixa para as duas tabelas ficarem alinhadas */
    .tabela-consultas {
        table-layout: fixed;
    }

    /* Cabeçalho clicável */
    .cabecalho-toggle {
        cursor: pointer;
        user-select: none;
    }

    /* Seta: aponta para baixo quando aberto, para a direita quando recolhido */
    .cabecalho-toggle .seta {
        transition: transform .2s ease;
    }

    .cabecalho-toggle[aria-expanded="false"] .seta {
        transform: rotate(-90deg);
    }
</style>

<body>

    <nav class="navbar navbar-sgcf sticky-top">
        <div class="container-fluid">
            <span class="navbar-brand text-white">Clínica Dr. Gabriel Alves</span>
            <a class="btn btn-colaborador" href="../controller/controle_de_login.php?acao=logout">Sair</a>
        </div>
    </nav>

    <div class="container py-5">

        <div class="mb-4">
            <h1 class="h3 fw-bold mb-1">Painel do Fisioterapeuta</h1>
            <p class="text-muted mb-0">Olá, <?= htmlspecialchars($_SESSION['nome'], ENT_QUOTES, 'UTF-8') ?>. Veja suas consultas.</p>
        </div>

        <!-- Barra de pesquisa (visual) -->
        <div class="row mb-4">
            <div class="col-12 col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Pesquisar por paciente ou CPF...">
                    <button class="btn btn-primary" type="button">Pesquisar</button>
                </div>
            </div>
        </div>

        <!-- NÃO ATENDIDAS -->
        <div class="card shadow mb-4">
            <div class="card-header bg-warning-subtle d-flex justify-content-between align-items-center cabecalho-toggle"
                 data-bs-toggle="collapse" data-bs-target="#secaoNaoAtendidas"
                 role="button" aria-expanded="true" aria-controls="secaoNaoAtendidas">
                <div class="d-flex align-items-center gap-2">
                    <svg class="seta" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                    </svg>
                    <h2 class="h5 fw-bold mb-0">Não atendidas</h2>
                </div>
                <span class="badge bg-warning text-dark"><?= count($naoAtendidas) ?></span>
            </div>

            <div class="collapse show" id="secaoNaoAtendidas">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 tabela-consultas">
                            <colgroup>
                                <col style="width: 22%">
                                <col style="width: 16%">
                                <col style="width: 12%">
                                <col style="width: 10%">
                                <col> <!-- Ações: ocupa o restante -->
                            </colgroup>
                            <thead class="table-light">
                                <tr>
                                    <th>Paciente</th>
                                    <th>CPF</th>
                                    <th>Data</th>
                                    <th>Horário</th>
                                    <th class="text-end">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($naoAtendidas as $c): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($c['paciente'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?= formatarCpf($c['cpf']) ?></td>
                                        <td><?= formatarData($c['data']) ?></td>
                                        <td><?= htmlspecialchars($c['hora'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td>
                                            <div class="d-flex flex-wrap justify-content-end gap-2">
                                                <?php if (isset($prontuarios[$c['id']])): ?>
                                                    <button type="button" class="btn btn-sm btn-outline-info"
                                                            data-bs-toggle="modal" data-bs-target="#modalProntuario<?= (int) $c['id'] ?>">
                                                        Consultar prontuário
                                                    </button>
                                                    <a class="btn btn-sm btn-outline-warning"
                                                       href="atendimento_fisioterapeuta.php?id=<?= (int) $c['id'] ?>">
                                                        Adicionar relatório/Atendimento
                                                    </a>
                                                <?php else: ?>
                                                    <button type="button" class="btn btn-sm btn-outline-info">Consultar prontuário</button>
                                                    <button type="button" class="btn btn-sm btn-outline-warning">Adicionar relatório/Atendimento</button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- ATENDIDAS -->
        <div class="card shadow">
            <div class="card-header bg-success-subtle d-flex justify-content-between align-items-center cabecalho-toggle"
                 data-bs-toggle="collapse" data-bs-target="#secaoAtendidas"
                 role="button" aria-expanded="true" aria-controls="secaoAtendidas">
                <div class="d-flex align-items-center gap-2">
                    <svg class="seta" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                    </svg>
                    <h2 class="h5 fw-bold mb-0">Atendidas</h2>
                </div>
                <span class="badge bg-success"><?= count($atendidas) ?></span>
            </div>

            <div class="collapse show" id="secaoAtendidas">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 tabela-consultas">
                            <colgroup>
                                <col style="width: 22%">
                                <col style="width: 16%">
                                <col style="width: 12%">
                                <col style="width: 10%">
                                <col> <!-- Ações: ocupa o restante -->
                            </colgroup>
                            <thead class="table-light">
                                <tr>
                                    <th>Paciente</th>
                                    <th>CPF</th>
                                    <th>Data</th>
                                    <th>Horário</th>
                                    <th class="text-end">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($atendidas as $c): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($c['paciente'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?= formatarCpf($c['cpf']) ?></td>
                                        <td><?= formatarData($c['data']) ?></td>
                                        <td><?= htmlspecialchars($c['hora'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td>
                                            <div class="d-flex flex-wrap justify-content-end gap-2">

                                                <!-- Consultar prontuário -->
                                                <?php if (isset($prontuarios[$c['id']])): ?>
                                                    <button type="button" class="btn btn-sm btn-outline-info"
                                                            data-bs-toggle="modal" data-bs-target="#modalProntuario<?= (int) $c['id'] ?>">
                                                        Consultar prontuário
                                                    </button>
                                                <?php else: ?>
                                                    <button type="button" class="btn btn-sm btn-outline-info">Consultar prontuário</button>
                                                <?php endif; ?>

                                                <!-- Adicionar tratamento -->
                                                <?php if (isset($relatorios[$c['id']])): ?>
                                                    <a class="btn btn-sm btn-outline-primary"
                                                       href="tratamento_fisioterapeuta.php?id=<?= (int) $c['id'] ?>">
                                                        Adicionar tratamento
                                                    </a>
                                                <?php else: ?>
                                                    <button type="button" class="btn btn-sm btn-outline-primary">Adicionar tratamento</button>
                                                <?php endif; ?>

                                                <!-- Consultar relatório -->
                                                <?php if (isset($relatorios[$c['id']])): ?>
                                                    <button type="button" class="btn btn-sm btn-outline-success"
                                                            data-bs-toggle="modal" data-bs-target="#modalRelatorio<?= (int) $c['id'] ?>">
                                                        Consultar Relatório
                                                    </button>
                                                <?php else: ?>
                                                    <button type="button" class="btn btn-sm btn-outline-success">Consultar Relatório</button>
                                                <?php endif; ?>

                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- MODAIS DE PRONTUÁRIO -->
    <?php foreach ($prontuarios as $idConsulta => $p): ?>
        <div class="modal fade" id="modalProntuario<?= (int) $idConsulta ?>" tabindex="-1"
             aria-labelledby="tituloProntuario<?= (int) $idConsulta ?>" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="modal-header">
                        <h2 class="modal-title h5 fw-bold" id="tituloProntuario<?= (int) $idConsulta ?>">
                            Prontuário - <?= htmlspecialchars(nomeDoPaciente($consultas, $idConsulta), ENT_QUOTES, 'UTF-8') ?>
                        </h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>

                    <div class="modal-body">

                        <div class="row g-2 mb-4">
                            <div class="col-md-6"><strong>Nº do prontuário:</strong> <?= (int) $p['idProntuario'] ?></div>
                            <div class="col-md-6"><strong>Aberto em:</strong> <?= formatarDataHora($p['dtAbertura']) ?></div>
                        </div>

                        <h3 class="h6 fw-bold border-bottom pb-2 mb-2">Descrição</h3>
                        <p class="mb-4"><?= nl2br(htmlspecialchars($p['descricao'], ENT_QUOTES, 'UTF-8')) ?></p>

                        <h3 class="h6 fw-bold border-bottom pb-2 mb-2">Observações</h3>
                        <p class="mb-0"><?= nl2br(htmlspecialchars($p['observacoes'], ENT_QUOTES, 'UTF-8')) ?></p>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Fechar</button>
                    </div>

                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- MODAIS DE RELATÓRIO -->
    <?php foreach ($relatorios as $idConsulta => $r): ?>
        <div class="modal fade" id="modalRelatorio<?= (int) $idConsulta ?>" tabindex="-1"
             aria-labelledby="tituloRelatorio<?= (int) $idConsulta ?>" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="modal-header">
                        <h2 class="modal-title h5 fw-bold" id="tituloRelatorio<?= (int) $idConsulta ?>">
                            Relatório - <?= htmlspecialchars(nomeDoPaciente($consultas, $idConsulta), ENT_QUOTES, 'UTF-8') ?>
                        </h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>

                    <div class="modal-body">

                        <p class="mb-4"><strong>Registrado em:</strong> <?= formatarDataHora($r['dtRegistro']) ?></p>

                        <h3 class="h6 fw-bold border-bottom pb-2 mb-2">Descrição</h3>
                        <p class="mb-4"><?= nl2br(htmlspecialchars($r['descricao'], ENT_QUOTES, 'UTF-8')) ?></p>

                        <h3 class="h6 fw-bold border-bottom pb-2 mb-2">Observações</h3>
                        <p class="mb-0"><?= nl2br(htmlspecialchars($r['observacoes'], ENT_QUOTES, 'UTF-8')) ?></p>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Fechar</button>
                    </div>

                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <?php require __DIR__ . '/layout/footer.php'; ?>