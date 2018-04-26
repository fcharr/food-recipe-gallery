<?
include('../server-classes/db.class.php');
include('../server-classes/edit-recipe.class.php');
include('../server-classes/permissions.class.php');

$food_name = isset($_POST['food_name']) ? $_POST['food_name'] : '';
$recipe_id = isset($_POST['recipe_id']) ? $_POST['recipe_id'] : '';
$clone_recipe = isset($_POST['clone_recipe']) ? $_POST['clone_recipe'] : '';

$cook_id = Permissions::recipe($recipe_id);

EditRecipe::changeRecipeName($recipe_id, $food_name);

if($clone_recipe == 'true')
{
	EditRecipe::cloneRecipe($recipe_id);
}


if($cook_id != 0) { 
?>
$('.save_food').hide();
<? } ?>