<?
include('../server-classes/db.class.php');
include('../server-classes/edit-recipe.class.php');
include('../server-classes/permissions.class.php');

$recipe_id = isset($_POST['recipe_id']) ? stripslashes($_POST['recipe_id']) : 0;
$description = isset($_POST['description']) ? stripslashes($_POST['description']) : '';

$cook_id = Permissions::recipe($recipe_id);

if($cook_id != 0)
{
   EditRecipe::saveRecipeDescription($recipe_id, $description);
?>
$('.save_description').hide();
<? } ?>