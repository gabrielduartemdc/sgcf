<?php require __DIR__ . '/layout/header.php'; ?>
<link rel="stylesheet" href="../css/sobre_nos.css">

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

<main class="container sobre-nos py-5">

    <section class="text-center mb-5">
        <span class="sobre-tag">SOBRE NÓS</span>
        <h1 class="sobre-titulo mt-3">Clínica Dr. Gabriel Alves</h1>
        <p class="sobre-subtitulo">
            Cuidando da sua saúde com atenção e dedicação.
        </p>
        <div class="sobre-linha"></div>
    </section>

    <section class="row align-items-center mb-5">
        <div class="col-lg-6 mb-4 mb-lg-0 sobre-clinica">
            <h2 class="sobre-h2">Um pouco sobre nós...</h2>
            <p>
                A Clínica Dr. Gabriel Alves fundada em 2026, surgiu com o propósito de oferecer cuidados especializados em fisioterapia e reabilitação, proporcionando mais saúde, bem-estar e qualidade de vida aos seus pacientes. Nosso objetivo é oferecer um atendimento humanizado e de qualidade, ajudando cada pessoa a recuperar seus movimentos, aliviar dores, melhorar sua mobilidade e conquistar mais independência no dia a dia. Para isso, contamos com serviços voltados à avaliação, ao acompanhamento e à recuperação física, respeitando as necessidades individuais de cada paciente.
            </p>
            <p>
                Nossa equipe é comprometida com o cuidado, a atenção e o respeito a cada pessoa. Acreditamos que cada paciente possui necessidades e objetivos diferentes, por isso buscamos oferecer um atendimento individualizado, acolhedor e baseado na confiança. Trabalhamos para proporcionar uma experiência tranquila e segura, acompanhando cada etapa do tratamento e valorizando cada conquista durante o processo de reabilitação.
            </p>
        </div>
        <div class="col-lg-6">
            <img src="../img/recepcao.png" alt="Clínica Dr. Gabriel Alves" class="img-fluid rounded sobre-img">
        </div>
    </section>

    <section class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="sobre-card h-100">
                <h3>Missão</h3>
                <p>Promover a recuperação e a qualidade de vida dos nossos pacientes.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="sobre-card h-100">
                <h3>Visão</h3>
                <p>Ser referência em fisioterapia pelo cuidado e pela excelência.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="sobre-card h-100">
                <h3>Valores</h3>
                <p>Ética, respeito, acolhimento e compromisso com o paciente.</p>
            </div>
        </div>
    </section>

    <section class="text-center">
        <h2 class="sobre-h2">Quer conhecer a clínica?</h2>
        <a class="btn btn-agendar mt-2" href="cadastro_paciente.php">Agende já sua consulta!</a>
    </section>

</main>

<?php require __DIR__ . '/layout/footer.php'; ?>