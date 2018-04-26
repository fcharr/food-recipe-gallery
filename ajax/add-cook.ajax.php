<?
include('../server-classes/db.class.php');
include('../server-classes/login.class.php');
include('../server-classes/../templates/html5.class.php');
include('../server-classes/permissions.class.php');

$cook_login = isset($_POST['cook_login']) ? $_POST['cook_login'] : '';
$cook_email = isset($_POST['cook_email']) ? $_POST['cook_email'] : '';
$cook_first_name = isset($_POST['cook_first_name']) ? $_POST['cook_first_name'] : '';
$cook_last_name = isset($_POST['cook_last_name']) ? $_POST['cook_last_name'] : '';
$cook_admin = isset($_POST['cook_admin']) ? $_POST['cook_admin'] : false;
$cook_password = isset($_POST['cook_password']) ? $_POST['cook_password'] : '';

$admin = Permissions::isDBAdmin();

if($admin)
{
   $cook_id = LOGIN::addCook($cook_login, $cook_email, $cook_first_name, $cook_last_name, $cook_admin, $cook_password);
   
   $cook_array = array('id' => $cook_id, 'login' => $cook_login, 'email' => $cook_email, 'first_name' => $cook_first_name, 'last_name' => $cook_last_name, 'admin' => $cook_admin);
   
   HTML5::cook($cook_array);
}
?>