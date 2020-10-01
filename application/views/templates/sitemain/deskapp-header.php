<!DOCTYPE html>
<html>
<head>
	<!-- Basic Page Info -->
    <meta charset="utf-8">
	<title><?= $title_page; ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="MEDICAL EMERGENCY RESPONSE PLAN GAP ANALYSIS TOOLS Adalah suatu instrument untuk mengetahui dan menilai kesiapan Unit Operasi/Anak Perusahaan dalam menghadapi kegawat-daruratan medis termasuk melakukan evakuasi medis." />
    <meta name="keywords" content="Menu management, System Login, User Management, MERP, Pertamina" />
    <meta name="author" content="PT Pertamina (Persero)" />
    <link rel="shortcut icon" href="<?= base_url(); ?>assets/icon/favicon.ico">
    <link rel="apple-touch-icon" sizes="57x57" href="<?= base_url(); ?>assets/icon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?= base_url(); ?>assets/icon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= base_url(); ?>assets/icon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url(); ?>assets/icon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= base_url(); ?>assets/icon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= base_url(); ?>assets/icon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?= base_url(); ?>assets/icon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= base_url(); ?>assets/icon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url(); ?>assets/icon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="<?= base_url(); ?>assets/icon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url(); ?>assets/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?= base_url(); ?>assets/icon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url(); ?>assets/icon/favicon-16x16.png">
    <link rel="manifest" href="<?= base_url(); ?>assets/icon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?= base_url(); ?>assets/icon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

	<!-- Google Font -->
	<!--<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">-->
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/deskapp/vendors/styles/core.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/deskapp/vendors/styles/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/deskapp/src/plugins/jvectormap/jquery-jvectormap-2.0.3.css">
    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
    <!-- <script src="<?= base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->
    <!-- Core plugin JavaScript-->
    <script src="<?= base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/deskapp/src/plugins/datatables/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/deskapp/src/plugins/datatables/css/responsive.bootstrap4.min.css">
    
</head>
<body onload="startTime()">
	<div class="main-container">