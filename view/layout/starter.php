<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Rental Mobil - Revandi Sastra</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- CDN - PASTI KE LOAD -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a></li>
      <li class="nav-item d-none d-sm-inline-block"><a href="#" class="nav-link">Home - Revandi</a></li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item"><a class="nav-link" href="#"><i class="far fa-user"></i> revandisastra@gmail.com</a></li>
    </ul>
  </nav>

  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
      <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" class="brand-image img-circle elevation-3" style="opacity:.8">
      <span class="brand-text font-weight-light">Rental Revan</span>
    </a>
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image"><img src="https://adminlte.io/themes/v3/dist/img/user2-160x160.jpg" class="img-circle elevation-2"></div>
        <div class="info"><a href="#" class="d-block">Revandi Sastra</a></div>
      </div>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active"><i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p></a>
            <ul class="nav nav-treeview">
              <li class="nav-item"><a href="#" class="nav-link active"><i class="far fa-circle nav-icon"></i><p>Home</p></a></li>
              <li class="nav-item"><a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Data Mobil</p></a></li>
              <li class="nav-item"><a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Data Rental</p></a></li>
            </ul>
          </li>
          <li class="nav-item"><a href="index.php?url=Login_C/index" class="nav-link"><i class="nav-icon fas fa-sign-out-alt"></i><p>Logout</p></a></li>
        </ul>
      </nav>
    </div>
  </aside>

  <div class="content-wrapper">
    <div class="content-header"><div class="container-fluid"><div class="row mb-2"><div class="col-sm-6"><h1 class="m-0">Dashboard Revandi</h1></div><div class="col-sm-6"><ol class="breadcrumb float-sm-right"><li class="breadcrumb-item">Home</li><li class="breadcrumb-item active">Dashboard</li></ol></div></div></div></div>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-3 col-6"><div class="small-box bg-info"><div class="inner"><h3>12</h3><p>Mobil Tersedia</p></div><div class="icon"><i class="fas fa-car"></i></div><a href="#" class="small-box-footer">Info lanjut <i class="fas fa-arrow-circle-right"></i></a></div></div>
          <div class="col-lg-3 col-6"><div class="small-box bg-success"><div class="inner"><h3>44</h3><p>Pelanggan</p></div><div class="icon"><i class="fas fa-users"></i></div><a href="#" class="small-box-footer">Info lanjut <i class="fas fa-arrow-circle-right"></i></a></div></div>
          <div class="col-lg-3 col-6"><div class="small-box bg-warning"><div class="inner"><h3>5</h3><p>Rental Aktif</p></div><div class="icon"><i class="fas fa-shopping-cart"></i></div><a href="#" class="small-box-footer">Info lanjut <i class="fas fa-arrow-circle-right"></i></a></div></div>
          <div class="col-lg-3 col-6"><div class="small-box bg-danger"><div class="inner"><h3 style="font-size:16px;">revandisastra@gmail.com</h3><p>Login sebagai</p></div><div class="icon"><i class="fas fa-user"></i></div><a href="#" class="small-box-footer">Profil <i class="fas fa-arrow-circle-right"></i></a></div></div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <div class="card card-primary card-outline">
              <div class="card-header"><h5 class="m-0">Selamat Datang, Revandi!</h5></div>
              <div class="card-body"><h6 class="card-title">Sistem Rental Mobil</h6><p class="card-text">Login <b>revandisastra@gmail.com / 12345</b> berhasil! Error <code>prepare() on null</code> sudah fix. Status <span class="badge badge-success">Aktif</span></p><a href="#" class="btn btn-primary">Kelola Mobil</a></div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="card"><div class="card-header"><h5 class="m-0">Status Login</h5></div><div class="card-body"><p>Foto kamu yang berantakan tadi itu karena CSS lokal gak ketemu. Sekarang pakai CDN, pasti langsung jadi biru cakep!</p><a href="#" class="btn btn-success">Dashboard OK</a></div></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <footer class="main-footer"><div class="float-right d-none d-sm-inline">Rental Mobil Revandi</div><strong>Copyright &copy; 2024-2026 <a href="#">Revandi Sastra</a>.</strong> All rights reserved.</footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>