<?
include('../server-classes/db.class.php');
include('../server-classes/login.class.php');

$login = isset($_POST['login']) ? $_POST['login'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

$cook = new LOGIN($login, $password);

if($cook->id != 0 || $login == '') 
{
?>
setCookie('login', '<?= addslashes($login) ?>');
setCookie('password', '<?= addslashes($password) ?>');
document.location.reload();
<? } ?>