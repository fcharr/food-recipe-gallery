<?
/*************************************************************************************************************************************************************
scripts.FranciscoCharrua.com
This class is dedicated to creating, updating, and deleting recipe steps.
**************************************************************************************************************************************************************/

abstract class EditRecipeSteps
{
         public function addStepImage($step_id, $image)
         {
			    global $db;
				
				$sql = 'insert into step_images (step_id, file) values (?, ?)';
				$id = $db->execute($sql, $step_id, $image);
				   
                return($id);
         }
   
         public function saveStepImage($step_image_id, $image)
         {
			    global $db;
				
				$sql = 'update step_images set file = ? where id = ?';
				$db->execute($sql, $image, $step_image_id);
         }
 
         public function saveUniqueStepImage($step_id, $image)
         {
                global $db;
         
                $sql = 'select id from step_images where step_id = ?';
                
                $step_image = $db->execute($sql, $step_id);
                
                //Either update the existing image or add a new one.
                if(sizeof($step_image) > 0)
                {
					$step_image_id = $step_image[0]['id'];
                   	$sql = 'update step_images set file = ? where id = ' . $step_image_id;
					$db->execute($sql, $image);
                }
                else
                {
                   	$sql = 'insert into step_images (step_id, file) values (?, ?)';
                   	$step_image_id = $db->execute($sql, $step_id, $image);
                }
				        
                return($step_image_id);
         }
         
         public function saveStepImageFileName($id, $file_name)
         {
			    global $db;
				
				$sql = 'update step_images set file_name = ? where id = ?';
				$db->execute($sql, $file_name, $id);
         }
         
         public function saveStepInstructions($step_id, $instructions)
         {
			    global $db;
				
				$sql = 'update steps set instructions = ? where id = ?';
				$db->execute($sql, $instructions, $step_id);
         }
         
         public function addStepInstructions($recipe_id, $instructions)
         {
			    global $db;
                
                $instructions = self::sanitize($instructions);
                
                //Limits the number of inserted blank steps.
                if($instructions == '')
                {
                   $sql = 'select count(id) as count from steps where instructions = "" and recipe_id = ?';
				   $steps = $db->execute($sql, $recipe_id);
				   $count = $steps[0]['count'];
                   
                   if($count > 2)
                   {
                      return(0);
                   }
                }
                
                //Makes the inserted step be last one.
                $sql = 'select ifnull(max(steps.order), 0) + 1 as `order` from steps where recipe_id = ?';
				$steps = $db->execute($sql, $recipe_id);
				$order = $steps[0]['order'];

                //Inserts the step.
                $sql = 'insert into steps (recipe_id, instructions, `order`) values(?, ?, ?)';
				$step_id = $db->execute($sql, $recipe_id, $instructions, $order);
                
                return($step_id);
         }
         
         public function deleteStep($step_id)
         {
                global $db;
                
                //Delete the step intructions;
                $sql = 'delete from steps where id = ?';
                
              	$db->execute($sql, $step_id);
                
                //Delete the step image (if any).
                $sql = 'select file_name as name from step_images where step_id = ?';
                
               	$files = $db->execute($sql, $step_id);
                
                foreach($files as $file)
                {
					if(file_exists('../step-images/' . $file['name'])) 
					{
						unlink('../step-images/' . $file['name']);
					}
                }
                
                //Delete the step image (if any) from the dababase.
                $sql = 'delete from step_images where step_id = ?';
                
                $db->execute($sql, $step_id);
         }
         
         public function deleteStepImage($step_image_id)
         {
                global $db;
                
                //Delete the step image (if any).
                $sql = 'select file_name as name from step_images where id = ?';
                
                $files = $db->execute($sql, $step_image_id);
                
                foreach($files as $file)
                {
					if(file_exists('../step-images/' . $file['name'])) 
					{
						unlink('../step-images/' . $file['name']);
					}
                }
                
                //Delete the step image (if any) from the dababase.
                $sql = 'delete from step_images where id = ?';
                
                $db->execute($sql, $step_image_id);
         }
         
         private function sanitize($text)
         {
                 $text = trim($text);
                 $text = str_replace("<", "&lt;", $text);
                 $text = str_replace(">", "&gt;", $text);

                 return($text);
         }         
}
?>