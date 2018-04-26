<?
include('../server-classes/db.class.php');
include('../server-classes/login.class.php');
include('../templates/html5.class.php');
include('../server-classes/edit-recipe-steps.class.php');
include('../server-classes/image-files.class.php');
include_once('../server-classes/permissions.class.php');

$step_id = isset($_POST['step_id']) ? $_POST['step_id'] : 0;
$extension = ImageFiles::validate($_FILES['select_step_image']);

$cook_id = Permissions::step($step_id);

$publish = false;

if($extension != '' && $step_id != 0  && $cook_id != 0)
{
   $tmp_name = $_FILES['select_step_image']['tmp_name'];

   $image_handle = fopen($tmp_name, "rb");
   $image = addslashes(fread($image_handle, filesize($tmp_name)));
   fclose($image_handle);
   
   $step_image_id = EditRecipeSteps::addStepImage($step_id, $image);

	if($step_image_id != -1) 
	{
		$image_file_name = ImageFiles::step($step_image_id) . $extension;
		$image_file = '../step-images/' . $image_file_name;
		   
		move_uploaded_file($tmp_name, $image_file);
		   
		EditRecipeSteps::saveStepImageFileName($step_image_id, $image_file_name);
		   
		$image_array = array('id' => $step_image_id, 'file_name' => $image_file_name);
		   
		$login = isset($_COOKIE['login']) ? $_COOKIE['login'] : '';
		$password = isset($_COOKIE['password']) ? $_COOKIE['password'] : '';
		$login = new LOGIN($login, $password);
		   
		HTML5::recipe_step_image($image_array, $login, $publish);
	}
}
?>