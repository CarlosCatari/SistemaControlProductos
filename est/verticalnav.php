<?php
class NavVertical {
    private $menuItems = [];

    public function __construct() {
        $this->menuItems = [
            [
                "href" => "adminpanel.php",
                "icon" => "fas fa-fw fa-solid fa-house-user",
                "text" => "Inicio",
            ],
            [
                "href" => "admadmin.php",
                "icon" => "fas fa-fw fa-solid fa-user-tie",
                "text" => "Administradores"
            ],
            [
                "href" => "admpersonal.php",
                "icon" => "fas fa-fw fa-solid fa-address-card",
                "text" => "Personal"
            ],
            [
                "href" => "admproveedor.php",
                "icon" => "fas fa-fw fa-solid fa-truck",
                "text" => "Proveedores"
            ],
            [
                "href" => "admproducto.php",
                "icon" => "fas fa-fw fa-table",
                "text" => "Productos"
            ],
            [
                "href" => "admcategoria.php",
                "icon" => "fas fa-fw fa-solid fa-layer-group",
                "text" => "Categorías"
            ],
            [
                "href" => "../index.php",
                "icon" => "fas fa-fw fa-solid fa-door-open",
                "text" => "Cerrar Sesión"
            ]
        ];
    }

    public function renderNavbar() {
?>
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #19002f;">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html" style="background-color: #08001b;">
                <div class="sidebar-brand-text mx-3">Administrador</div>
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