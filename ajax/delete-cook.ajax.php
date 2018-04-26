<?
include('../server-classes/db.class.php');
include('../server-classes/login.class.php');
include('../templates/html5.class.php');
include('../server-classes/permissions.class.php');

$cook_id = isset($_POST['cook_id']) ? $_POST['cook_id'] : '';

$admin = Permissions::isDBAdmin();

if($admin)
{
  	LOGIN::deleteCook($cook_id);
?>
	$('#cook_div<?= $cook_id ?>').remove();
<? } ?>