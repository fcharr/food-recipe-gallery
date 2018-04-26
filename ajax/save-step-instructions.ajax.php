<?
include('../server-classes/db.class.php');
include('../server-classes/edit-recipe-steps.class.php');
include('../server-classes/permissions.class.php');

$step_id = isset($_POST['step_id']) ? $_POST['step_id'] : 0;
$instructions = isset($_POST['instructions']) ? stripslashes($_POST['instructions']) : '';

$cook_id = Permissions::step($step_id) || Permissions::recipe($recipe_id);

if($step_id != 0 && $cook_id != 0)
{
   EditRecipeSteps::saveStepInstructions($step_id, $instructions);
?>
$('[class="save_step"][id=<?= $step_id ?>]').hide();
<? } ?>