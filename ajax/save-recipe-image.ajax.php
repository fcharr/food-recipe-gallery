<?
include('../server-classes/db.class.php');
include('../server-classes/edit-recipe.class.php');
include('../server-classes/image-files.class.php');
include('../server-classes/permissions.class.php');

$extension = isset($_FILES['select_recipe_image']) ? ImageFiles::validate($_FILES['select_recipe_image']) : '';
$recipe_id = isset($_POST['recipe_id']) ? $_POST['recipe_id'] : 0;

$cook_id = Permissions::recipe($recipe_id);

if($extension != '' && $recipe_id != 0 && $cook_id != 0)
{
   $tmp_name = $_FILES['select_recipe_image']['tmp_name'];

   $image_handle = fopen($tmp_name, "rb");
   $image = addslashes(fread($image_handle, filesize($tmp_name)));
   fclose($image_handle);
   
   $id = EditRecipe::saveRecipeImage($recipe_id, $image);
   
   $image_file_name = ImageFiles::recipe($recipe_id) . $extension;
   $image_file = '../food-images/' . $image_file_name;
   
   move_uploaded_file($tmp_name, $image_file);
   
   EditRecipe::saveRecipeImageFileName($id, $image_file_name);
?>
now = new Date(); 
$('#recipe_image').attr('src', 'food-images/<?= addslashes($image_file_name) ?>?' + now.getTime());
$('.select_recipe_image').val('');
<? } ?>