<?php require __DIR__ . '/layout/header.php'; ?>

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

<?php require __DIR__ . '/layout/footer.php'; ?>