<?php
session_start();
if (($_SESSION['perfil'] ?? '') !== 'administrador') {
    header('Location: login_usuarios.php');
    exit;
}

$usuarios = require __DIR__ . '/../models/usuarios_teste.php';

// Formata 11111111111 => 111.111.111-11
function formatarCpf(string $cpf): string
{
    return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf);
}

// Cor do badge para cada perfil
$coresPerfil = [
    'paciente'       => 'bg-info text-dark',
    'recepcionista'  => 'bg-warning text-dark',
    'fisioterapeuta' => 'bg-success',
    'administrador'  => 'bg-danger',
];
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

        <div class="mb-4">
            <h1 class="h3 fw-bold mb-1">Painel do Admin</h1>
            <p class="text-muted mb-0">Olá, <?= htmlspecialchars($_SESSION['nome'], ENT_QUOTES, 'UTF-8') ?>. Gerencie os usuários do sistema.</p>
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
    </div>

    <?php require __DIR__ . '/layout/footer.php'; ?>