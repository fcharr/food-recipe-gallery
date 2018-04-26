<?
if(!isset($root)) $root = './';

include($root . 'server-classes/db.class.php');
include($root . 'server-classes/login.class.php');
include($root . 'server-classes/recipe.class.php');
include($root . 'server-classes/permissions.class.php');
include($root . 'templates/html5.class.php');

if(isset($_GET['publish'])) {
	$publish = true;
} else {
	$publish = false;
}

$login = isset($_COOKIE['login']) ? $_COOKIE['login'] : '';
$password = isset($_COOKIE['password']) ? $_COOKIE['password'] : '';

$login = new LOGIN($login, $password);

$id = isset($_GET['id']) ? $_GET['id'] : 0;

$recipe = new RECIPE($id);

if($login->id != null) {
	$credit = array('first_name' => $login->first_name, 'last_name' => $login->last_name);
} else {
	$login = isset($_GET['login']) ? $_GET['login'] : '';
    $password = isset($_GET['password']) ? $_GET['password'] : '';
	
	$login =  new LOGIN($login, $password);
	$credit = array('first_name' => $login->first_name, 'last_name' => $login->last_name);
}

$credit = $recipe->credit;

$header = array('title' => $recipe->food['name']);

if($credit['id'] != -1) {
	$header['title'] .= ' by ' . $credit['first_name'] . ' ' . $credit['last_name'];
}

$cooks = LOGIN::cooks();

HTML5::header($header, $publish);
HTML5::recipe($recipe, $login, $cooks, $publish);
HTML5::footer(); 
?>