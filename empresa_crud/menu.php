<nav class="navbar md:navbar-expand bg-1">
  <div class="container-fluid">
    <a class="navbar-brand" href="/empresa_crud/index.php">Empresa</a>
    <button class="btn-icon navbar-toggler" type="button" data-bs-toggle="drawer" data-bs-target="#navbarDrawer" aria-controls="navbarDrawer" aria-expanded="false" aria-label="Abrir menu">
      <span class="navbar-toggler-icon" aria-hidden="true"></span>
    </button>
    <dialog class="drawer drawer-end" tabindex="-1" id="navbarDrawer" aria-labelledby="navbarDrawerLabel">
      <div class="drawer-header">
        <h5 class="drawer-title" id="navbarDrawerLabel">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="drawer" aria-label="Fechar"></button>
      </div>
      <div class="drawer-body mb-2 md:mb-0">
        <ul class="nav navbar-nav me-auto">
          <li class="nav-item"><a class="nav-link" href="/empresa_crud/index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="/empresa_crud/funcionario/listar.php">Funcionários</a></li>
          <li class="nav-item"><a class="nav-link" href="/empresa_crud/funcionario/adicionar.php">Novo funcionário</a></li>
        </ul>
      </div>
    </dialog>
  </div>
</nav>
