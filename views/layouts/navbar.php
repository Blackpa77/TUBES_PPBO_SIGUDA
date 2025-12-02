<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="<?= $base_url ?>/Dashboard">SIGUDA PPBO</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= $base_url ?>/Dashboard">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $base_url ?>/Kategori">Kategori</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $base_url ?>/Produk">Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $base_url ?>/Transaksi">Transaksi</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link btn btn-danger text-white btn-sm px-3" href="<?= $base_url ?>/Logout">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>