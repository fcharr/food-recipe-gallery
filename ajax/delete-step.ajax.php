<?
include('../server-classes/db.class.php');
include('../server-classes/edit-recipe-steps.class.php');
include('../server-classes/permissions.class.php');

$step_id = isset($_POST['step_id']) ? $_POST['step_id'] : 0;

$cook_id = Permissions::step($step_id);

if($cook_id != 0)
{
   EditRecipeSteps::deleteStep($step_id);
?>
$('[class=step_images][id=<?= $step_id ?>]').remove();
<? }  ?>