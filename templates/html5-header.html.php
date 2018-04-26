<!DOCTYPE HTML>
<html>
<head>
<title><?= $header['title'] ?></title>

<link rel="stylesheet" type="text/css" href="css/kitchen.css" />
<link rel="stylesheet" type="text/css" href="<?= $css_file ?>" />
<? if(!$publish) { ?>
<script src="<?= $root ?>client-scripts/jquery.js"></script>
<script src="<?= $root ?>client-scripts/jquery.form.js"></script>
<script src="<?= $root ?>client-scripts/jquery.url.js"></script>
<script src="<?= $root ?>client-scripts/jquery.cookie.js"></script>
<script src="<?= $root ?>client-scripts/cooks.js"></script>
<script src="<?= $js_file ?>"></script>
<? } ?>
</head>

<body<? if(!$publish) { ?> onload="setup();"<? } ?>>

<a class="home_link" href="./"></a>
