<?
include('../server-classes/db.class.php');
include('../server-classes/edit-recipe-steps.class.php');
include('../server-classes/permissions.class.php');

$step_image_id = isset($_POST['step_image_id']) ? $_POST['step_image_id'] : 0;

$cook_id = Permissions::step_image($step_image_id);

if($cook_id != 0)
{
   EditRecipeSteps::deleteStepImage($step_image_id);
?>
$('#step_image_div<?= $step_image_id ?>').remove();
<? } ?>