<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @var string $title
 * @var array $metaData
 * @var stdClass $page
 * @var array $menuHeader
 * @var array $menuFooter
 */

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
    <? foreach ($metaData as $name => $metaValue): ?>
        <meta name="<?= $name ?>" content="<?= $metaValue ?>"/>
    <? endforeach; ?>

    <!-- Bootstrap core CSS -->
    <link href="<?= base_url('/assets/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="<?= base_url('/assets/vendor/font-awesome/css/font-awesome.min.css')?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

    <!-- Custom styles for this template -->
    <link href="<?= base_url('/assets/css/agency.css') ?>" rel="stylesheet">
</head>
<body id="page-top">

<? $this->load->view('inner/header', array(
    'menu' => $menuHeader
)) ?>

<? $this->load->view('carcass/' . $page->carcass, array(
    'page' => $page
)) ?>

<? $this->load->view('inner/footer', array(
    'menu' => $menuFooter
)) ?>

<!-- Bootstrap core JavaScript -->
<script src="<?= base_url('/assets/vendor/jquery/jquery.min.js') ?>"></script>
<script src="<?=  base_url('/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')?>"></script>

<!-- Plugin JavaScript -->
<script src="<?= base_url('/assets/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>

<!-- Contact form JavaScript -->
<script src="<?= base_url('/assets/js/jqBootstrapValidation.js') ?>"></script>
<script src="<?= base_url('/assets/js/contact_me.js') ?>"></script>

<!-- Custom scripts for this template -->
<script src="<?= base_url('/assets/js/agency.min.js') ?>"></script>

</body>
</html>