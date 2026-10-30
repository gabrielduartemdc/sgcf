<?php require __DIR__ . '/layout/header.php'; ?>

<nav class="navbar navbar-expand-lg navbar-sgcf sticky-top">
    <div class="container-fluid">
        <a class="btn btn-agendar me-3" href="../index.php">Agende já sua consulta</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="../index.php">Início</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Contato
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="https://mail.google.com/mail/?view=cm&fs=1&to=contatoclinicag@gmail.com&su=Contato%20-%20Cl%C3%ADnica%20Gabriel%20Alves" target="_blank" rel="noopener noreferrer">
                                contatoclinicag@gmail.com
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="tel:345222451">
                                Telefone: 34522-2451
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="https://w.app/q2agcz" target="_blank" rel="noopener noreferrer">
                                Mensagem no WhatsApp
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <a class="btn btn-colaborador ms-lg-auto mt-2 mt-lg-0" href="login_usuarios.php">Sou colaborador</a>
        </div>
    </div>
</nav>

<div class="row mx-0 secao-principal secao-cadastro">
    <!-- 1/3: boas-vindas -->
    <div class="col-md-5 painel-boas-vindas d-flex flex-column justify-content-center align-items-center text-center p-5">

        <span class="selo-clinica mb-3">Fisioterapia e Reabilitação</span>

        <h1 class="display-6 fw-bold mb-3">Crie seu cadastro de paciente</h1>

        <p class="lead text-muted mb-4">Preencha seus dados para agendar e acompanhar suas consultas pelo seu painel.</p>

        <div class="d-flex gap-2 flex-wrap justify-content-center">
            <a href="login_usuarios.php" class="btn btn-outline-dark btn-lg">Já sou paciente</a>
        </div>

        <hr class="divisor my-5">

        <p class="destaque-texto mb-0">
            Com profissionais qualificados para oferecer o melhor do atendimento clínico.
        </p>

    </div>

    <!-- 2/3: formulário -->
    <div class="col-md-7 pt-4 px-4 pb-5 painel-form">
        <form action="" method="post">

            <!-- O card branco é essa div (cresce junto com o conteúdo) -->
            <div class="bg-white rounded-4 shadow-sm p-4">

                <!-- Dados pessoais -->
                <h2 class="h6 fw-bold border-bottom pb-2 mb-3">Dados pessoais</h2>
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label for="nome" class="form-label">Nome completo</label>
                        <input type="text" class="form-control" id="nome" name="nome">
                    </div>
                    <div class="col-md-4">
                        <label for="cpf" class="form-label">CPF</label>
                        <input type="text" class="form-control" id="cpf" name="cpf">
                    </div>
                    <div class="col-md-4">
                        <label for="data_nascimento" class="form-label">Data de nascimento</label>
                        <input type="date" class="form-control" id="data_nascimento" name="data_nascimento">
                    </div>
                    <div class="col-md-4">
                        <label for="sexo" class="form-label">Sexo</label>
                        <select class="form-select" id="sexo" name="sexo">
                            <option value="" selected>Selecione</option>
                            <option value="F">Feminino</option>
                            <option value="M">Masculino</option>
                            <option value="O">Outro</option>
                            <option value="N">Prefiro não informar</option>
                        </select>
                    </div>
                </div>

                <!-- Contato -->
                <h2 class="h6 fw-bold border-bottom pb-2 mb-3">Contato</h2>
                <div class="row g-3 mb-4">
                    <div class="col-md-7">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" autocomplete="email">
                    </div>
                    <div class="col-md-5">
                        <label for="telefone" class="form-label">Telefone / WhatsApp</label>
                        <input type="tel" class="form-control" id="telefone" name="telefone">
                    </div>
                </div>

                <!-- Endereço -->
                <h2 class="h6 fw-bold border-bottom pb-2 mb-3">Endereço</h2>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label for="cep" class="form-label">CEP</label>
                        <input type="text" class="form-control" id="cep" name="cep">
                    </div>
                    <div class="col-md-8">
                        <label for="logradouro" class="form-label">Rua / Quadra</label>
                        <input type="text" class="form-control" id="logradouro" name="logradouro">
                    </div>
                    <div class="col-md-3 col-5">
                        <label for="numero" class="form-label">Número</label>
                        <input type="text" class="form-control" id="numero" name="numero">
                    </div>
                    <div class="col-md-9 col-7">
                        <label for="complemento" class="form-label">Complemento</label>
                        <input type="text" class="form-control" id="complemento" name="complemento">
                    </div>
                    <div class="col-md-5">
                        <label for="bairro" class="form-label">Bairro</label>
                        <input type="text" class="form-control" id="bairro" name="bairro">
                    </div>
                    <div class="col-md-5 col-8">
                        <label for="cidade" class="form-label">Cidade</label>
                        <input type="text" class="form-control" id="cidade" name="cidade">
                    </div>
                    <div class="col-md-2 col-4">
                        <label for="uf" class="form-label">UF</label>
                        <input type="text" class="form-control" id="uf" name="uf">
                    </div>
                </div>

                <!-- Atendimento -->
                <h2 class="h6 fw-bold border-bottom pb-2 mb-3">Atendimento</h2>
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <span class="form-label d-block">Você tem convênio?</span>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tem_convenio" id="convenio_sim" value="1">
                            <label class="form-check-label" for="convenio_sim">Sim</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tem_convenio" id="convenio_nao" value="0" checked>
                            <label class="form-check-label" for="convenio_nao">Não</label>
                        </div>
                    </div>

                    <!-- Aparece só quando marcar "Sim" (controlado por js/scripts.js) -->
                    <div class="col-12 d-none" id="dadosConvenio">
                        <div class="border rounded-3 p-3 bg-light">
                            <div class="row g-3">
                                <div class="col-md-7">
                                    <label for="convenio_nome" class="form-label">Nome do convênio</label>
                                    <input type="text" class="form-control" id="convenio_nome" name="convenio_nome" disabled>
                                </div>
                                <div class="col-md-5">
                                    <label for="convenio_ans" class="form-label">Registro ANS</label>
                                    <input type="text" class="form-control" id="convenio_ans" name="convenio_ans" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Acesso -->
                <h2 class="h6 fw-bold border-bottom pb-2 mb-3">Acesso ao painel</h2>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" autocomplete="new-password">
                    </div>
                    <div class="col-md-6">
                        <label for="confirmar_senha" class="form-label">Confirmar senha</label>
                        <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" autocomplete="new-password">
                    </div>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="aceite_lgpd" name="aceite_lgpd">
                    <label class="form-check-label" for="aceite_lgpd">
                        Autorizo a clínica a guardar e usar meus dados para atendimento e agendamento de consultas.
                    </label>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-outline-dark btn-lg">Criar meu cadastro</button>
                </div>

            </div>
            <!-- fim do card -->

            <!-- respiro embaixo do card -->
            <div class="pb-5"></div>

        </form>
    </div>

</div>
<?php require __DIR__ . '/layout/footer.php'; ?>