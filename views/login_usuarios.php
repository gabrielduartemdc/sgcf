<?php require __DIR__ . '/layout/header.php'; ?>

<body class="fundo-form">


    <nav class="navbar navbar-expand-lg navbar-sgcf sticky-top">
        <div class="container-fluid">
            <a class="btn btn-agendar me-3" href="cadastro_paciente.php">Agende já sua consulta</a>
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
    <div class="d-flex align-items-center justify-content-center" style="min-height: calc(100vh - 70px);">
        <div class="col-11 col-sm-8 col-md-6 col-lg-4">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="text-center mb-4 text-dark">Login</h3>
                    <form action="../controller/controle_de_login.php?acao=login" method="POST"> 
                        <div class="mb-3">
                            <label class="text-dark">CPF</label>
                            <input type="text" name="cpf" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="text-dark">Senha</label>
                            <input type="password" name="senha" class="form-control">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100">Entrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <?php require __DIR__ . '/layout/footer.php'; ?>