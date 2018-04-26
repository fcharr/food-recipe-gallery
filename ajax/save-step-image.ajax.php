<?
include('../server-classes/db.class.php');
include('../server-classes/edit-recipe-steps.class.php');
include('../server-classes/image-files.class.php');
include('../server-classes/permissions.class.php');

$extension = isset($_FILES['step_image']) ? ImageFiles::validate($_FILES['step_image']) : '';
$step_image_id = isset($_POST['step_image_id']) ? $_POST['step_image_id'] : 0;

$cook_id = Permissions::step_image($step_image_id);

if($extension != '' && $step_image_id != 0 && $cook_id != 0)
{
   $tmp_name = $_FILES['step_image']['tmp_name'];

   $image_handle = fopen($tmp_name, "rb");
   $image = addslashes(fread($image_handle, filesize($tmp_name)));
   fclose($image_handle);
 
   EditRecipeSteps::saveStepImage($step_image_id, $image);
   
   $image_file_name = ImageFiles::step($step_image_id) . $extension;
   $image_file = '../step-images/' . $image_file_name;
   
   move_uploaded_file($tmp_name, $image_file);
   
   EditRecipeSteps::saveStepImageFileName($step_image_id, $image_file_name);
?>
now = new Date(); 
$('#step_image<?= $step_image_id ?>').attr('src', 'step-images/<?= addslashes($image_file_name) ?>?' + now.getTime());
$('[name=step_image][id=<?= $step_image_id ?>]').val('');
<? } ?>