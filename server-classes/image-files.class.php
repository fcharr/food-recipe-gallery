<?
/*************************************************************************************************************************************************************
scripts.FranciscoCharrua.com
This class is dedicated to providing names for generated image files, and deleting generated image files.
**************************************************************************************************************************************************************/

abstract class ImageFiles
{
         public function step($id)
         {
			    global $db;
			 
			    $file_name = '';
				
                $sql = 'select step_images.id as step_images_id, steps.order as `order`, food.name as food_name from step_images, steps, recipes, food ' .
                       'where food.id = recipes.food_id and recipes.id = steps.recipe_id and step_images.step_id = steps.id and step_images.id = ?';
				$step_images = $db->execute($sql, $id);
				
				if(sizeof($step_images) > 0)
				{
					$file_name = str_replace(' ', '-', $step_images[0]['food_name']) . '-step-' . str_pad($step_images[0]['order'], 2, '0', STR_PAD_LEFT) . '-' . $step_images[0]['step_images_id'];
					$file_name = strtolower($file_name);
				}
				
				return($file_name);
         }
         
         public function recipe($id)
         {
			    global $db;
				
				$file_name = '';
				
                $sql = 'select recipe_images.id as id, food.name as food_name from food, recipes, recipe_images ' . 
                       'where recipes.id = recipe_images.recipe_id and food.id = recipes.food_id and recipes.id = ?';
			    $recipe_images = $db->execute($sql, $id);
				
				if(sizeof($recipe_images) > 0)
				{
					$file_name = str_replace(' ', '-', $recipe_images[0]['food_name']) . '-recipe-' . $recipe_images[0]['id'];
					$file_name = strtolower($file_name);
				}
				
				return($file_name);            
         }
		 
		 public function delete($recipe_id = 0)
		 {
			 	global $db;
			 
			 	$sql = 'select file_name as name from recipe_images';
						
				if($recipe_id != 0)
				{
					$sql .= ' where recipe_id = ?';
					$files = $db->execute($sql, $recipe_id);
				} 
				else
				{
					$files = $db->execute($sql);
				}
				
				foreach($files as $file) 
				{
					if(file_exists('../food-images/' . $file['name']))
					{
						unlink('../food-images/' . $file['name']);
					}
				}
			 
			 	$sql = 'select file_name as name from step_images, steps, recipes where step_images.step_id = steps.id and steps.recipe_id = recipes.id';
				
				if($recipe_id != 0)
				{
					$sql .= ' and recipes.id = ?';
					$files = $db->execute($sql, $recipe_id);
				}
				else
				{
					$files = $db->execute($sql);
				}
						
				foreach($files as $file) 
				{
					if(file_exists('../step-images/' . $file['name']))
					{
						unlink('../step-images/' . $file['name']);
					}
				}
		 }
		 
		 public function brute_delete()
		 {
			 $food_images = glob('../food-images/*.*');
			 
			 foreach($food_images as $food_image)
			 {
				 if($food_image != '../food-images/food-image.png.php')
				 {
					 unlink($food_image);
				 }
			 }
			 
			 $step_images = glob('../step-images/*.*');
			 
			 foreach($step_images as $step_image)
			 {
				 if($step_image != '../step-images/step-image.png.php')
				 {
					 unlink($step_image);
				 }
			 }
		 }
         
         public function validate($uploaded_file)
         {
                if($uploaded_file['error'] != UPLOAD_ERR_OK || !is_uploaded_file($uploaded_file['tmp_name']))
                {
                   return('');
                }                               
                
                $valid_extensions = Array('jpg', 'gif', 'png');
                
                foreach($valid_extensions as $valid_extension)
                {
                        if(strripos($uploaded_file['name'], '.' . $valid_extension) == strlen($uploaded_file['name']) - strlen($valid_extension) - 1)
                        {
                           return('.' . $valid_extension);
                        }
                }
                
                return('');
         }         
}
?>