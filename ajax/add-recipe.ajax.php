<?
include('../server-classes/db.class.php');
include('../server-classes/login.class.php');
include('../server-classes/edit-recipe.class.php');
include('../server-classes/recipe-files.class.php');
include('../server-classes/permissions.class.php');
include('../templates/html5.class.php');

$food_name = isset($_POST['food_name']) ? $_POST['food_name'] : '';

$cook_id = Permissions::loginID();

$recipe_id = $cook_id != 0 ? EditRecipe::addRecipe($food_name, $cook_id) : 0;

if($recipe_id != 0 && $cook_id != 0) 
{
	$recipe_array = array('recipe_id' => $recipe_id, 'name' => $food_name);
	
	$login = isset($_COOKIE['login']) ? $_COOKIE['login'] : '';
    $password = isset($_COOKIE['password']) ? $_COOKIE['password'] : '';
    $cook = new LOGIN($login, $password);
	
	HTML5::recipe_link($recipe_array, $cook, false);
}
?>