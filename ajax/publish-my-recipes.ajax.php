<?
include('../server-classes/db.class.php');
include('../server-classes/edit-recipe.class.php');
include('../server-classes/recipe-files.class.php');
include('../server-classes/permissions.class.php');
include('../server-classes/recipes.class.php');

$cook_id = permissions::loginID();

if($cook_id != 0)
{	
   $recipes = new RECIPES($cook_id, true);
   
   $page_number = (int) (recipeFiles::offset() / recipeFiles::recipes_per_page()) + 1;

   $file_name = recipeFiles::recipes($page_number, $cook_id); 
   $file_name = editRecipe::createIndexFile($file_name);
?>
window.open('<?= $file_name ?>', '_blank');
<? 
}
if($recipes->number > recipeFiles::offset() + recipeFiles::recipes_per_page())
{
?>
publish(<?= (recipeFiles::offset() + recipeFiles::recipes_per_page()) ?>, <?= recipeFiles::rows_per_page() ?>, <?= recipeFiles::columns_per_page() ?>);
<? } ?>