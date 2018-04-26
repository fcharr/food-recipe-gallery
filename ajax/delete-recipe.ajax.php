<?
include('../server-classes/db.class.php');
include('../server-classes/edit-recipe.class.php');
include('../server-classes/image-files.class.php');
include('../server-classes/recipe-files.class.php');
include('../server-classes/permissions.class.php');

$recipe_id = isset($_POST['recipe_id']) ? $_POST['recipe_id'] : '';
$delete_files = isset($_POST['delete_files']) ? $_POST['delete_files'] : '';

$cook_id = Permissions::recipe($recipe_id);

if($delete_files == 'true') 
{
	ImageFiles::delete($recipe_id);
	RecipeFiles::delete($recipe_id, $cook_id);
}

EditRecipe::deleteRecipe($recipe_id);

if($recipe_id != 0 && $cook_id != 0) 
{ 
?>
$('[class=recipe_div][id=<?= $recipe_id ?>]').remove();
<? } ?>