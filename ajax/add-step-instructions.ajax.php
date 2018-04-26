<?
include('../server-classes/db.class.php');
include('../server-classes/login.class.php');
include('../server-classes/edit-recipe-steps.class.php');
include('../server-classes/permissions.class.php');
include('../templates/html5.class.php');

$recipe_id = isset($_POST['recipe_id']) ? $_POST['recipe_id'] : 0;
$instructions = isset($_POST['instructions']) ? stripslashes($_POST['instructions']) : '';

$cook_id = Permissions::recipe($recipe_id);

$publish = false;

if($recipe_id != 0 && $cook_id != 0)
{
   $step_id = EditRecipeSteps::addStepInstructions($recipe_id, $instructions);
   
   if($step_id != 0) 
   {
	   $step_array = array('id' => $step_id, 'instructions' => $instructions, 'images' => array());
	   
	   $login = isset($_COOKIE['login']) ? $_COOKIE['login'] : '';
	   $password = isset($_COOKIE['password']) ? $_COOKIE['password'] : '';
	   $login = new LOGIN($login, $password);   
	   
	   HTML5::recipe_step($step_array, $login, $publish);
   }
}
?>