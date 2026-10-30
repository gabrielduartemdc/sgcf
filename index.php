<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Clínica Dr. Gabriel Alves</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-sgcf sticky-top">
    <div class="container-fluid">
      <a class="btn btn-agendar me-3" href="views/cadastro_paciente.php">Agende já sua consulta</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" href="#index.php">Início</a>
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
        <a class="btn btn-colaborador ms-lg-auto mt-2 mt-lg-0" href="views/login_usuarios.php">Sou colaborador</a>
      </div>
    </div>
  </nav>

  <div class="row mx-0 secao-principal">

    <!-- 1/3: boas-vindas -->
    <div class="col-md-5 painel-boas-vindas d-flex flex-column justify-content-center align-items-center text-center p-5">

      <span class="selo-clinica mb-3">Fisioterapia e Reabilitação</span>

      <h1 class="display-6 fw-bold mb-3">Bem-vindo à Clínica Dr. Gabriel Alves</h1>

      <p class="lead text-muted mb-4">Cuidando da sua saúde com atenção e dedicação.</p>

      <div class="d-flex gap-2 flex-wrap justify-content-center">
        <a href="views/login_usuarios.php" class="btn btn-outline-dark btn-lg">Já sou paciente</a>
      </div>

      <hr class="divisor my-5">

      <p class="destaque-texto mb-0">
        Com profissionais qualificados para oferecer o melhor do atendimento clínico.
        <br><br>
        <a href="views/sobre_nos.php" class="btn btn-outline-dark btn-lg">Sobre nós</a>
      </p>


    </div>

    <!-- 2/3: informações e imagens -->
    <div class="col-md-7 p-4">
      <div id="carouselExampleAutoplaying" class="carousel slide carrossel-clinica" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="utils/fotoDoFisioterapeuta3.png" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="utils/fotoDoFisioterapeuta2.png" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="utils/fotoDoFisioterapeuta1.png" class="d-block w-100" alt="...">
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>

  </div>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/scripts.js"></script>

</body>

</html>