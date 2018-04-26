<?
include('../server-classes/db.class.php');
include('../server-classes/permissions.class.php');

$cook_id = isset($_POST['cook_id']) ? $_POST['cook_id'] : 0;
$cook_login = isset($_POST['cook_login']) ? $_POST['cook_login'] : '';
$cook_password = isset($_POST['cook_password']) ? $_POST['cook_password'] : '';
$cook_email = isset($_POST['cook_email']) ? $_POST['cook_email'] : '';
$cook_first_name = isset($_POST['cook_first_name']) ? $_POST['cook_first_name'] : '';
$cook_last_name = isset($_POST['cook_last_name']) ? $_POST['cook_last_name'] : '';
$cook_admin = isset($_POST['cook_admin']) ? $_POST['cook_admin'] : false;

$admin = Permissions::isDBAdmin();

if($admin == true)
{
	if($cook_password != '') {
		LOGIN::setCookPassword($cook_id, $cook_password);
	}
	
   	LOGIN::saveCook($cook_id, $cook_login, $cook_email, $cook_first_name, $cook_last_name, $cook_admin);
?>
	$('[class=change_cook_password][id=<?= $cook_id ?>]').prop('checked', false);
    $('#cook_password<?= $cook_id ?>').val('');    
    $('#cook_password<?= $cook_id ?>').prop('disabled', true);
 	$('[class=save_cook][id=<?= $cook_id ?>]').hide();
<? } ?>