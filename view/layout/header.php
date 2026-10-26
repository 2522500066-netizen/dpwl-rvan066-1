<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Rental Revan | <?= $nm_user ?? 'Revandi' ?></title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="/dpwl-rvan066-1/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="/dpwl-rvan066-1/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<?php if(!empty($info_psn)) echo "<script>alert('".$info_psn."');</script>"; ?>
<div class="wrapper">
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a></li>
      <li class="nav-item d-none d-sm-inline-block"><a href="/dpwl-rvan066-1/" class="nav-link">Home - Revandi</a></li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-user"></i> <?= $nm_user ?? 'revandisastra@gmail.com' ?></a></li>
    </ul>
  </nav>