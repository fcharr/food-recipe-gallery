<?
include('../server-classes/db.class.php');
include('../server-classes/edit-recipe.class.php');
include('../server-classes/recipe-files.class.php');
include('../server-classes/permissions.class.php');
include('../server-classes/recipe.class.php');

$recipe_id = isset($_POST['recipe_id']) ? $_POST['recipe_id'] : 0;

$cook_id = permissions::recipe($recipe_id);

if($cook_id != 0)
{
   $recipe = new RECIPE($recipe_id);

   copy('../food-images/' . $recipe->food['file_name'], '../food-images/' . $recipe->food['file_name']);

   foreach($recipe->steps as $step)
   {
	   foreach($step['images'] as $image)
	   {
		   copy('../step-images/' . $image['file_name'], '../step-images/' . $image['file_name']);
	   }
   }

   editRecipe::publish($recipe_id, $cook_id);
   $file_name = recipeFiles::recipe($recipe_id, $cook_id);
   $file_name = editRecipe::createFile($recipe_id, $file_name);
?>
window.open('<?= addslashes($file_name) ?>', '_newtab');
<? } ?>