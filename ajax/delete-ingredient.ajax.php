<?
include('../server-classes/db.class.php');
include('../server-classes/edit-recipe-ingredients.class.php');
include('../server-classes/permissions.class.php');

$ingredient_id = isset($_POST['ingredient_id']) ? $_POST['ingredient_id'] : 0;

$cook_id = Permissions::ingredient($ingredient_id);

if($cook_id != 0)
{
   EditRecipeIngredients::deleteIngredient($ingredient_id);
?>
$('[class=ingredient][id=<?= $ingredient_id ?>]').remove();
<? } ?>