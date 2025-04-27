<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title ?></title>

  <!-- Bootstrap -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >

  <!-- Your custom palette -->
  <link
    href="<?= base_url('assets/css/style.css') ?>"
    rel="stylesheet"
  >

  <style>
    body { padding-top: 70px; }
    .navbar-brand { font-weight: bold; }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?= site_url() ?>">Phonebook</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="<?= site_url() ?>">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= site_url('contacts/create') ?>">Add Contact</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container">
