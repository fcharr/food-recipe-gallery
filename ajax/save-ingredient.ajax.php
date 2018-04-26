<?
include('../server-classes/db.class.php');
include('../server-classes/edit-recipe-ingredients.class.php');
include('../server-classes/permissions.class.php');

$ingredient_id = isset($_POST['ingredient_id']) ? $_POST['ingredient_id'] : 0;
$food_quantity = isset($_POST['food_quantity']) ? $_POST['food_quantity'] : '';
$food_unit = isset($_POST['food_unit']) ? $_POST['food_unit'] : '';
$food_name = isset($_POST['food_name']) ? $_POST['food_name'] : '';

$cook_id = Permissions::ingredient($ingredient_id) || Permissions::recipe($recipe_id);

if($ingredient_id != 0 && $cook_id != 0)
{
   EditRecipeIngredients::saveIngredient($ingredient_id, $food_name, $food_quantity, $food_unit);
?>
$('[id="<?= $ingredient_id ?>"][class="save_ingredient"]').hide();
<? } ?>