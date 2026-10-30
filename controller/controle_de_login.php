<?php
session_start();

$telaLogin = '../views/login_usuarios.php';   // nome do arquivo da sua tela de login

// CPF => dados do usuário de teste (protótipo, sem banco)
$usuarios = [
    '11111111111' => ['senha' => '123456', 'nome' => 'Paciente Teste',       'perfil' => 'paciente',       'destino' => 'dashboard_paciente.php'],
    '22222222222' => ['senha' => '123456', 'nome' => 'Recepcionista Teste',  'perfil' => 'recepcionista',  'destino' => 'dashboard_recepcionista.php'],
    '33333333333' => ['senha' => '123456', 'nome' => 'Fisioterapeuta Teste', 'perfil' => 'fisioterapeuta', 'destino' => 'dashboard_fisioterapeuta.php'],
];

switch ($_GET['acao'] ?? '') {

    case 'login':
        $cpf   = is_string($_POST['cpf'] ?? null) ? preg_replace('/\D/', '', $_POST['cpf']) : '';
        $senha = is_string($_POST['senha'] ?? null) ? $_POST['senha'] : '';

        if (isset($usuarios[$cpf]) && $usuarios[$cpf]['senha'] === $senha) {
            $_SESSION['nome']   = $usuarios[$cpf]['nome'];
            $_SESSION['perfil'] = $usuarios[$cpf]['perfil'];
            header('Location: ../views/' . $usuarios[$cpf]['destino']);
            exit;
        }

        header('Location: ' . $telaLogin . '?erro=1');
        exit;

    case 'logout':
        session_destroy();
        header('Location: ' . $telaLogin);
        exit;

    default:
        header('Location: ' . $telaLogin);
        exit;
}