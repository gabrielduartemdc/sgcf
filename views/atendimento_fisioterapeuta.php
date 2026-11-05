<?php
session_start();
if (($_SESSION['perfil'] ?? '') !== 'fisioterapeuta') {
    header('Location: login_usuarios.php');
    exit;
}

$consultas   = require __DIR__ . '/../models/consultas_teste.php';
$prontuarios = require __DIR__ . '/../models/prontuarios_teste.php';

// Descobre qual consulta está sendo atendida (?id=3)
$idConsulta = (int) ($_GET['id'] ?? 0);
$consulta   = null;
foreach ($consultas as $c) {
    if ($c['id'] === $idConsulta) {
        $consulta = $c;
        break;
    }
}
$p = $prontuarios[$idConsulta] ?? null;

// Se não achou a consulta ou o prontuário, volta para o painel
if (!$consulta || !$p) {
    header('Location: dashboard_fisioterapeuta.php');
    exit;
}

function h(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

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
?>
<?php require __DIR__ . '/layout/header.php'; ?>

<body>

<nav class="navbar navbar-sgcf sticky-top">
    <div class="container-fluid">
        <span class="navbar-brand text-white">Clínica Dr. Gabriel Alves</span>
        <div class="d-flex gap-2">
            <a class="btn btn-agendar" href="dashboard_fisioterapeuta.php">Voltar ao painel</a>
            <a class="btn btn-colaborador" href="../controller/controle_de_login.php?acao=logout">Sair</a>
        </div>
    </div>
</nav>

<div class="row mx-0 secao-principal secao-cadastro">

    <!-- ESQUERDA: paciente + prontuário -->
    <div class="col-md-5 painel-boas-vindas p-5">

        <span class="selo-clinica mb-3 d-inline-block">Atendimento</span>

        <h1 class="h3 fw-bold mb-1"><?= h($consulta['paciente']) ?></h1>
        <p class="text-muted mb-4">
            Consulta de <?= formatarData($consulta['data']) ?> às <?= h($consulta['hora']) ?>
        </p>

        <h2 class="h6 fw-bold border-bottom pb-2 mb-3">Dados do paciente</h2>
        <div class="row g-2 mb-4">
            <div class="col-12"><strong>Nome:</strong> <?= h($consulta['paciente']) ?></div>
            <div class="col-12"><strong>CPF:</strong> <?= formatarCpf($consulta['cpf']) ?></div>
        </div>

        <h2 class="h6 fw-bold border-bottom pb-2 mb-3">Prontuário</h2>
        <div class="row g-2 mb-3">
            <div class="col-12"><strong>Nº do prontuário:</strong> <?= (int) $p['idProntuario'] ?></div>
            <div class="col-12"><strong>Aberto em:</strong> <?= formatarDataHora($p['dtAbertura']) ?></div>
        </div>

        <p class="mb-2"><strong>Descrição:</strong></p>
        <p class="mb-3"><?= nl2br(h($p['descricao'])) ?></p>

        <p class="mb-2"><strong>Observações:</strong></p>
        <p class="mb-0"><?= nl2br(h($p['observacoes'])) ?></p>

    </div>

    <!-- DIREITA: formulário do fisioterapeuta -->
    <div class="col-md-7 pt-4 px-4 pb-5 painel-form">
        <form action="" method="post">

            <div class="bg-white rounded-4 shadow-sm p-4">

                <h2 class="h5 fw-bold mb-4">Novo registro no prontuário</h2>

                <h3 class="h6 fw-bold border-bottom pb-2 mb-3">Dados do registro</h3>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="data_registro" class="form-label">Data e hora do registro</label>
                        <input type="text" class="form-control" id="data_registro"
                               value="<?= date('d/m/Y H:i') ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="paciente" class="form-label">Paciente</label>
                        <input type="text" class="form-control" id="paciente"
                               value="<?= h($consulta['paciente']) ?>" readonly>
                    </div>
                </div>

                <h3 class="h6 fw-bold border-bottom pb-2 mb-3">Atendimento</h3>
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="6"
                                  placeholder="Descreva o atendimento realizado e a evolução do paciente"></textarea>
                    </div>
                    <div class="col-12">
                        <label for="observacoes" class="form-label">Observações</label>
                        <textarea class="form-control" id="observacoes" name="observacoes" rows="3"
                                  placeholder="Orientações, cuidados, pontos de atenção..."></textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-center gap-2">
                    <a href="dashboard_fisioterapeuta.php" class="btn btn-outline-secondary btn-lg">Cancelar</a>
                    <button type="submit" class="btn btn-outline-dark btn-lg">Salvar registro</button>
                </div>

            </div>

            <div class="pb-5"></div>

        </form>
    </div>

</div>

<?php require __DIR__ . '/layout/footer.php'; ?>