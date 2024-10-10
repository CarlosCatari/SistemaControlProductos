<?php
class NavPages {
    private $menuItems = [];

    public function __construct() {
        $this->menuItems = [
            [
                "href" => "dashboard.php",
                "icon" => "fas fa-fw fa-solid fa-house-user",
                "text" => "Inicio",
            ],
            [
                "href" => "administrador.php",
                "icon" => "fas fa-fw fa-solid fa-user-tie",
                "text" => "Administradores"
            ],
            [
                "href" => "personal.php",
                "icon" => "fas fa-fw fa-solid fa-address-card",
                "text" => "Almaceneros"
            ],
            [
                "href" => "proveedor.php",
                "icon" => "fas fa-fw fa-solid fa-truck",
                "text" => "Proveedores"
            ],
            [
                "href" => "producto.php",
                "icon" => "fas fa-fw fa-table",
                "text" => "Productos"
            ],
            [
                "href" => "categoria.php",
                "icon" => "fas fa-fw fa-solid fa-layer-group",
                "text" => "Categorías"
            ],
            [
                "href" => "consultas.php",
                "icon" => "fas fa-fw fa-solid fa-clipboard",
                "text" => "Consultas"
            ],
            [
                "href" => "../index.php",
                "icon" => "fas fa-fw fa-solid fa-door-open",
                "text" => "Cerrar Sesión"
            ]
        ];
    }

    public function renderPagesNav() {
?>
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #002349;">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html" style="background-color: #001832;">
                <div class="sidebar-brand-text mx-3">Personal</div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item active d-flex justify-content-center align-items-center mt-3">
                <div class="text-center">
                    <button class="rounded-lg border-0" id="sidebarToggleTop">
                        <i class="fa fa-bars mt-1"></i>
                    </button>
                </div>
            </li>
            <hr class="sidebar-divider my-0 mt-4">
        <?php foreach ($this->menuItems as $item) { ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $item['href']; ?>">
                <i class="<?php echo $item['icon']; ?>"></i>
                <span><?php echo $item['text']; ?></span></a>
            </li>
        <?php } ?>
        </ul>
<?php
    }
}
?>
