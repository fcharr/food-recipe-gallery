<?
include('server-classes/db.class.php');
include('server-classes/login.class.php');
include('server-classes/recipes.class.php');
include('server-classes/recipe-files.class.php');
include('server-classes/permissions.class.php');
include('templates/html5.class.php');

if(isset($_GET['publish'])) {
	$publish = true;
} else {
	$publish = false;
}

$login = isset($_COOKIE['login']) ? $_COOKIE['login'] : '';
$password = isset($_COOKIE['password']) ? $_COOKIE['password'] : '';

if($publish) {
	$login = isset($_GET['login']) ? $_GET['login'] : '';
	$password = isset($_GET['password']) ? $_GET['password'] : '';
}

$login = new LOGIN($login, $password);

$recipes = new RECIPES($login->id, $publish);
$cooks = LOGIN::cooks();

$header = array('title' => 'food recipes');

HTML5::header($header, $publish);
HTML5::recipes($recipes, $login, $cooks, $publish);
HTML5::footer(); 
?>