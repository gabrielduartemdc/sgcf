<?php
session_start();
if (($_SESSION['perfil'] ?? '') !== 'recepcionista') {
    header('Location: login_usuarios.php');
    exit;
}

$consultas = require __DIR__ . '/../models/consultas_teste.php';

// Consultas agendadas (ainda não atendidas) e já atendidas (aptas a pagamento)
$agendadas = array_filter($consultas, fn($c) => !$c['atendida']);
$atendidas = array_filter($consultas, fn($c) => $c['atendida']);

// Monta a lista de pacientes a partir das consultas (agrupando por CPF)
$pacientes = [];
foreach ($consultas as $c) {
    $cpf = $c['cpf'];
    if (!isset($pacientes[$cpf])) {
        $pacientes[$cpf] = [
            'nome'      => $c['paciente'],
            'cpf'       => $cpf,
            'consultas' => [],
        ];
    }
    $pacientes[$cpf]['consultas'][] = $c;
}

function formatarCpf(string $cpf): string
{
    return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf);
}

function formatarData(string $data): string
{
    return date('d/m/Y', strtotime($data));
}

function e(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
}
?>
<?php require __DIR__ . '/layout/header.php'; ?>

<style>
    .tabela-recepcao {
        table-layout: fixed;
    }

    .nav-tabs .nav-link {
        font-weight: 600;
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
            <h1 class="h3 fw-bold mb-1">Painel da Recepção</h1>
            <p class="text-muted mb-0">Olá, <?= e($_SESSION['nome']) ?>. Gerencie agendamentos, pagamentos e pacientes.</p>
        </div>

        <!-- ABAS -->
        <ul class="nav nav-tabs mb-4" id="abasRecepcao" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="aba-agendamentos" data-bs-toggle="tab"
                        data-bs-target="#painelAgendamentos" type="button" role="tab"
                        aria-controls="painelAgendamentos" aria-selected="true">
                    Agendamentos
                    <span class="badge bg-warning text-dark ms-1"><?= count($agendadas) ?></span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="aba-pagamentos" data-bs-toggle="tab"
                        data-bs-target="#painelPagamentos" type="button" role="tab"
                        aria-controls="painelPagamentos" aria-selected="false">
                    Pagamentos
                    <span class="badge bg-success ms-1"><?= count($atendidas) ?></span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="aba-pacientes" data-bs-toggle="tab"
                        data-bs-target="#painelPacientes" type="button" role="tab"
                        aria-controls="painelPacientes" aria-selected="false">
                    Pacientes
                    <span class="badge bg-info text-dark ms-1"><?= count($pacientes) ?></span>
                </button>
            </li>
        </ul>

        <div class="tab-content">

            <!-- ================= AGENDAMENTOS ================= -->
            <div class="tab-pane fade show active" id="painelAgendamentos" role="tabpanel"
                 aria-labelledby="aba-agendamentos" tabindex="0">

                <div class="card shadow">
                    <div class="card-header bg-warning-subtle d-flex justify-content-between align-items-center">
                        <h2 class="h5 fw-bold mb-0">Consultas agendadas</h2>
                        <button type="button" class="btn btn-primary btn-sm"
                                data-bs-toggle="modal" data-bs-target="#modalNovoAgendamento">
                            + Novo agendamento
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 tabela-recepcao">
                                <colgroup>
                                    <col style="width: 26%">
                                    <col style="width: 18%">
                                    <col style="width: 14%">
                                    <col style="width: 12%">
                                    <col>
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
                                    <?php if (empty($agendadas)): ?>
                                        <tr><td colspan="5" class="text-center text-muted py-4">Nenhuma consulta agendada.</td></tr>
                                    <?php endif; ?>
                                    <?php foreach ($agendadas as $c): ?>
                                        <tr>
                                            <td><?= e($c['paciente']) ?></td>
                                            <td><?= formatarCpf($c['cpf']) ?></td>
                                            <td><?= formatarData($c['data']) ?></td>
                                            <td><?= e($c['hora']) ?></td>
                                            <td>
                                                <div class="d-flex flex-wrap justify-content-end gap-2">
                                                    <button type="button" class="btn btn-sm btn-outline-primary">Remarcar</button>
                                                    <button type="button" class="btn btn-sm btn-outline-danger">Cancelar</button>
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

            <!-- ================= PAGAMENTOS ================= -->
            <div class="tab-pane fade" id="painelPagamentos" role="tabpanel"
                 aria-labelledby="aba-pagamentos" tabindex="0">

                <div class="card shadow">
                    <div class="card-header bg-success-subtle d-flex justify-content-between align-items-center">
                        <h2 class="h5 fw-bold mb-0">Consultas atendidas</h2>
                        <button type="button" class="btn btn-success btn-sm"
                                data-bs-toggle="modal" data-bs-target="#modalPagamento">
                            + Registrar pagamento
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 tabela-recepcao">
                                <colgroup>
                                    <col style="width: 26%">
                                    <col style="width: 18%">
                                    <col style="width: 14%">
                                    <col style="width: 12%">
                                    <col>
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
                                    <?php if (empty($atendidas)): ?>
                                        <tr><td colspan="5" class="text-center text-muted py-4">Nenhuma consulta atendida.</td></tr>
                                    <?php endif; ?>
                                    <?php foreach ($atendidas as $c): ?>
                                        <tr>
                                            <td><?= e($c['paciente']) ?></td>
                                            <td><?= formatarCpf($c['cpf']) ?></td>
                                            <td><?= formatarData($c['data']) ?></td>
                                            <td><?= e($c['hora']) ?></td>
                                            <td>
                                                <div class="d-flex flex-wrap justify-content-end gap-2">
                                                    <button type="button" class="btn btn-sm btn-outline-success btn-pagar"
                                                            data-bs-toggle="modal" data-bs-target="#modalPagamento"
                                                            data-consulta="<?= (int) $c['id'] ?>">
                                                        Registrar pagamento
                                                    </button>
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

            <!-- ================= PACIENTES ================= -->
            <div class="tab-pane fade" id="painelPacientes" role="tabpanel"
                 aria-labelledby="aba-pacientes" tabindex="0">

                <div class="row mb-3">
                    <div class="col-12 col-md-6">
                        <input type="text" id="filtroPacientes" class="form-control"
                               placeholder="Pesquisar por paciente ou CPF...">
                    </div>
                </div>

                <div class="card shadow">
                    <div class="card-header bg-info-subtle">
                        <h2 class="h5 fw-bold mb-0">Pacientes</h2>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 tabela-recepcao" id="tabelaPacientes">
                                <colgroup>
                                    <col style="width: 30%">
                                    <col style="width: 20%">
                                    <col style="width: 16%">
                                    <col>
                                </colgroup>
                                <thead class="table-light">
                                    <tr>
                                        <th>Paciente</th>
                                        <th>CPF</th>
                                        <th>Consultas</th>
                                        <th class="text-end">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pacientes as $p): ?>
                                        <tr data-busca="<?= e(mb_strtolower($p['nome']) . ' ' . $p['cpf'] . ' ' . formatarCpf($p['cpf'])) ?>">
                                            <td><?= e($p['nome']) ?></td>
                                            <td><?= formatarCpf($p['cpf']) ?></td>
                                            <td><?= count($p['consultas']) ?></td>
                                            <td>
                                                <div class="d-flex flex-wrap justify-content-end gap-2">
                                                    <button type="button" class="btn btn-sm btn-outline-info"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalPaciente<?= e($p['cpf']) ?>">
                                                        Ver dados
                                                    </button>
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
    </div>

    <!-- ================= MODAL: NOVO AGENDAMENTO ================= -->
    <div class="modal fade" id="modalNovoAgendamento" tabindex="-1"
         aria-labelledby="tituloNovoAgendamento" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <form class="modal-content form-visual" method="post" action="#">

                <div class="modal-header">
                    <h2 class="modal-title h5 fw-bold" id="tituloNovoAgendamento">Novo agendamento</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="agPaciente" class="form-label">Paciente</label>
                        <select id="agPaciente" name="cpf" class="form-select" required>
                            <option value="">Selecione...</option>
                            <?php foreach ($pacientes as $p): ?>
                                <option value="<?= e($p['cpf']) ?>">
                                    <?= e($p['nome']) ?> - <?= formatarCpf($p['cpf']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row g-3">
                        <div class="col-7">
                            <label for="agData" class="form-label">Data</label>
                            <input type="date" id="agData" name="data" class="form-control" required>
                        </div>
                        <div class="col-5">
                            <label for="agHora" class="form-label">Horário</label>
                            <input type="time" id="agHora" name="hora" class="form-control" required>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label for="agObs" class="form-label">Observações</label>
                        <textarea id="agObs" name="observacoes" class="form-control" rows="3"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Agendar</button>
                </div>

            </form>
        </div>
    </div>

    <!-- ================= MODAL: REGISTRAR PAGAMENTO ================= -->
    <div class="modal fade" id="modalPagamento" tabindex="-1"
         aria-labelledby="tituloPagamento" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <form class="modal-content form-visual" method="post" action="#">

                <div class="modal-header">
                    <h2 class="modal-title h5 fw-bold" id="tituloPagamento">Registrar pagamento</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="pgConsulta" class="form-label">Consulta</label>
                        <select id="pgConsulta" name="id_consulta" class="form-select" required>
                            <option value="">Selecione...</option>
                            <?php foreach ($atendidas as $c): ?>
                                <option value="<?= (int) $c['id'] ?>">
                                    <?= e($c['paciente']) ?> - <?= formatarData($c['data']) ?> às <?= e($c['hora']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row g-3">
                        <div class="col-6">
                            <label for="pgValor" class="form-label">Valor (R$)</label>
                            <input type="number" id="pgValor" name="valor" class="form-control"
                                   min="0" step="0.01" required>
                        </div>
                        <div class="col-6">
                            <label for="pgForma" class="form-label">Forma de pagamento</label>
                            <select id="pgForma" name="forma" class="form-select" required>
                                <option value="">Selecione...</option>
                                <option value="dinheiro">Dinheiro</option>
                                <option value="pix">Pix</option>
                                <option value="debito">Cartão de débito</option>
                                <option value="credito">Cartão de crédito</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label for="pgData" class="form-label">Data do pagamento</label>
                        <input type="date" id="pgData" name="data_pagamento" class="form-control"
                               value="<?= date('Y-m-d') ?>" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Registrar</button>
                </div>

            </form>
        </div>
    </div>

    <!-- ================= MODAIS: DADOS DO PACIENTE ================= -->
    <?php foreach ($pacientes as $p): ?>
        <div class="modal fade" id="modalPaciente<?= e($p['cpf']) ?>" tabindex="-1"
             aria-labelledby="tituloPaciente<?= e($p['cpf']) ?>" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="modal-header">
                        <h2 class="modal-title h5 fw-bold" id="tituloPaciente<?= e($p['cpf']) ?>">
                            <?= e($p['nome']) ?>
                        </h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-2 mb-4">
                            <div class="col-md-6"><strong>Nome:</strong> <?= e($p['nome']) ?></div>
                            <div class="col-md-6"><strong>CPF:</strong> <?= formatarCpf($p['cpf']) ?></div>
                        </div>

                        <h3 class="h6 fw-bold border-bottom pb-2 mb-2">Histórico de consultas</h3>
                        <div class="table-responsive">
                            <table class="table table-sm align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Data</th>
                                        <th>Horário</th>
                                        <th>Situação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($p['consultas'] as $c): ?>
                                        <tr>
                                            <td><?= formatarData($c['data']) ?></td>
                                            <td><?= e($c['hora']) ?></td>
                                            <td>
                                                <?php if ($c['atendida']): ?>
                                                    <span class="badge bg-success">Atendida</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning text-dark">Agendada</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Fechar</button>
                    </div>

                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <script>
        // Filtro de pacientes (no navegador, sem recarregar a página)
        document.getElementById('filtroPacientes').addEventListener('input', function () {
            const termo = this.value.toLowerCase().trim();
            document.querySelectorAll('#tabelaPacientes tbody tr').forEach(function (linha) {
                linha.style.display = linha.dataset.busca.includes(termo) ? '' : 'none';
            });
        });

        // Botão "Registrar pagamento" da linha já seleciona a consulta no modal
        document.querySelectorAll('.btn-pagar').forEach(function (botao) {
            botao.addEventListener('click', function () {
                document.getElementById('pgConsulta').value = this.dataset.consulta;
            });
        });

        // Formulários visuais: ainda sem controller, apenas fecham o modal.
        // Troque por action="../controller/..." quando o back-end existir.
        document.querySelectorAll('.form-visual').forEach(function (form) {
            form.addEventListener('submit', function (ev) {
                ev.preventDefault();
                bootstrap.Modal.getInstance(form.closest('.modal')).hide();
                form.reset();
            });
        });
    </script>

    <?php require __DIR__ . '/layout/footer.php'; ?>
