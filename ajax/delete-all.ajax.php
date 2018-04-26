<?
include('../server-classes/db.class.php');
include('../server-classes/image-files.class.php');
include('../server-classes/recipe-files.class.php');
include('../server-classes/permissions.class.php');

$is_db_admin = Permissions::isDBAdmin();
$delete_files = isset($_POST['delete_files']) ? $_POST['delete_files'] : '';

if($is_db_admin) 
{ 
	if($delete_files == 'true') 
	{
		ImageFiles::delete();
		recipeFiles::brute_delete();
	}
	
	$db->deleteAll();
?>
	document.location.reload();
<? } ?>