<?
include('../server-classes/db.class.php');
include('../server-classes/login.class.php');
include('../server-classes/../templates/html5.class.php');
include('../server-classes/edit-recipe-ingredients.class.php');
include_once('../server-classes/permissions.class.php');

$ingredient_id = isset($_POST['ingredient_id']) ? $_POST['ingredient_id'] : 0;
$food_quantity = isset($_POST['food_quantity']) ? $_POST['food_quantity'] : '';
$unit_name = isset($_POST['unit_name']) ? $_POST['unit_name'] : '';
$food_name = isset($_POST['food_name']) ? $_POST['food_name'] : '';
$recipe_id = isset($_POST['recipe_id']) ? $_POST['recipe_id'] : 0;

$cook_id = Permissions::ingredient($ingredient_id) || Permissions::recipe($recipe_id);

$publish = false;

if($recipe_id != 0 && $cook_id != 0)
{
   $ingredient_id = EditRecipeIngredients::addIngredient($recipe_id, $food_name, $food_quantity, $unit_name);
   
   $ingredient_array = array('id' => $ingredient_id, 'quantity' => $food_quantity, 'unit_name' => $unit_name, 'food_name' => $food_name);
   
   $login = isset($_COOKIE['login']) ? $_COOKIE['login'] : '';
   $password = isset($_COOKIE['password']) ? $_COOKIE['password'] : '';
   $login = new LOGIN($login, $password);
   
   HTML5::recipe_ingredient($ingredient_array, $login, $publish);
}
?>