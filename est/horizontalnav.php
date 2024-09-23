<?php
class NavHorizontal {
    private $user;

    public function __construct($user) {
        $this->user = $user;
    }

    public function renderNavbar() {
?>
        <nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow" style="background-color: #00187a;">
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>
            <span class="mx-2">Sistema Control de Productos</span>
            <ul class="navbar-nav ml-auto">
                <div class="topbar-divider d-none d-sm-block"></div>
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $this->user; ?></span>
                        <i><img src="../images/admin.png" alt="icono_admin" style="height: 35px;"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="perfiladmin.php">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            Perfil
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../index.php">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Cerrar Sesión
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
<?php
    }
}
?>
