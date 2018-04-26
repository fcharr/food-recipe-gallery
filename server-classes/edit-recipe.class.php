<?
/*************************************************************************************************************************************************************
scripts.FranciscoCharrua.com
This class is dedicated to creating, updating, and deleting recipes.
**************************************************************************************************************************************************************/

abstract class EditRecipe
{
         public function saveFood($food_name)
         {
			    global $db;
			 
                $food_name = self::sanitize($food_name);
 
				$sql = 'select id from food where name = ?';
				$food = $db->execute($sql, $food_name);
				$food_id = sizeof($food) > 0 ? $food[0]['id'] : 0;
                
                if($food_id == 0)
                {
                   $sql = 'insert into food (name) values (?)';
				   $food_id = $db->execute($sql, $food_name);
                }
                
                return($food_id);
         }
         
         public function saveUnit($unit_name)
         {
			    global $db;
			 
                $unit_name = self::sanitize($unit_name);
				
				$sql = 'select id from units where name = ?';
				$unit = $db->execute($sql, $unit_name);
				$unit_id = sizeof($unit) > 0 ? $unit[0]['id'] : 0;
                
                if($unit_id == 0)
                {
                   $sql = 'insert into units (name) values (?)';
				   $unit_id = $db->execute($sql, $unit_name);
                }
				                
                return($unit_id);
         }
    
         public function saveRecipeImage($recipe_id, $image)
         {
			    global $db;
				
				$sql = 'select id from recipe_images where recipe_id = ?';
				$recipe_images = $db->execute($sql, $recipe_id);
                
                //Either update the existing image or add a new one.
                if(sizeof($recipe_images) > 0)
                {
                   $sql = 'update recipe_images set file = ? where id = ' . $recipe_images[0]['id'];
				   $db->execute($sql, $image);
				   return($recipe_images[0]['id']);
                }
                else
                {
                   $sql = 'insert into recipe_images (recipe_id, file) values (?, ?)';
				   $id = $db->execute($sql, $recipe_id, $image);
                   return($id);
                }
         }
         
         public function saveRecipeImageFileName($recipe_id, $file_name)
         {
			    global $db;
				
				$sql = 'update recipe_images set file_name = ? where id = ?';
				$db->execute($sql, $file_name, $recipe_id);
         }
         
         public function saveRecipeDescription($recipe_id, $description)
         {
			    global $db;
			 
                $description = self::sanitize($description);
				
				$sql = 'update recipes set description = ? where id = ?';
				$db->execute($sql, $description, $recipe_id);
         }
         
         public function addRecipe($food_name, $cook_id)
         {
			    global $db;
			 
                $food_id = self::saveFood($food_name);
                
                //Create the recipe.
				$sql = 'insert into recipes (food_id) values (?)';
				$recipe_id = $db->execute($sql, $food_id);

                //Associate the recipe to the logged on cook.
				if($cook_id != -1) 
				{
					$sql = 'insert into authority (recipe_id, cook_id) values (?, ?)';
					$db->execute($sql, $recipe_id, $cook_id);
				}
                
                return($recipe_id);
         }
         
         public function changeRecipeName($recipe_id, $food_name)
         {
			    global $db;
			 
                $food_id = self::saveFood($food_name);
				
				$sql = 'update recipes set food_id = ? where id = ?';
				$db->execute($sql, $food_id, $recipe_id);
         }
		 
		 public function cloneRecipe($recipe_id)
		 {
			    global $db;
				
			    $sql = 'insert into recipes (food_id, description) select food_id, description from recipes where id = ?';
				$new_recipe_id = $db->execute($sql, $recipe_id);
				
				$sql = 'insert into recipe_images (recipe_id, file_name, file) select ?, file_name, file from recipe_images where recipe_id = ?';
				$db->execute($sql, $new_recipe_id, $recipe_id);
				
				$sql = 'insert into authority (cook_id, recipe_id, published) select cook_id, ?, published from authority where recipe_id = ?';
				$db->execute($sql, $new_recipe_id, $recipe_id);
				
				$sql = 'insert into steps (recipe_id, instructions, `order`) select ?, instructions, `order` from steps where recipe_id = ?';
				$db->execute($sql, $new_recipe_id, $recipe_id);
				
				$sql = 'insert into step_images (step_id, file_name, file) ' .
				       'select old_steps.id, file_name, file ' .
                       'from steps as new_steps, steps as old_steps, step_images ' .
                       'where old_steps.recipe_id = ? and new_steps.recipe_id = ? and new_steps.id = step_images.step_id';
			    $db->execute($sql, $new_recipe_id, $recipe_id);
		 }
		 
		 public function deleteRecipe($recipe_id)
		 {
			    global $db;
				
				$sql = 'delete from recipes where id = ?';
				$db->execute($sql, $recipe_id);
				
				$sql = 'delete from recipe_images where recipe_id = ?';
				$db->execute($sql, $recipe_id);
				
				$sql = 'delete from authority where recipe_id = ?';
				$db->execute($sql, $recipe_id);
				
				$sql = 'delete from steps where recipe_id = ?';
				$db->execute($sql, $recipe_id);
				
				$sql = 'delete from step_images where step_id in (select id from steps where steps.recipe_id = ?)';
			    $db->execute($sql, $recipe_id);				
		 }
         
         public function publish($recipe_id, $cook_id)
         {
                global $db;
                
                $sql = 'update authority set published = true where recipe_id = ? and cook_id = ?';
                $db->execute($sql, $recipe_id, $cook_id);
         }
         
         public function createFile($recipe_id, $file_name)
         {          
                $recipe = $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'];
                $recipe = 'http://' . substr($recipe, 0, strrpos($recipe, '/ajax/')) . '/recipe.php?id=' . $recipe_id .
				          '&login=' . $_COOKIE['login'] . '&password=' . $_COOKIE['password'] . '&publish';
                
                $html = file($recipe);
                
                $file_path = $file_name;
                
                $file_pointer = fopen("../" . $file_path, 'w');
                
                foreach($html as $line)
                {
                        fwrite($file_pointer, $line);
                }
                
                fclose($file_pointer);
                
                return($file_path);                                
         }
		 
		 public function createIndexFile($file_name, $category_id = 0)
		 {
			    $recipes = $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'];
                $recipes = 'http://' . substr($recipes, 0, strrpos($recipes, '/ajax/')) . '/recipes.php?offset=' . recipeFiles::offset() . '&rows=' . recipeFiles::rows_per_page() . '&columns=' . recipeFiles::columns_per_page() .
				          '&login=' . $_COOKIE['login'] . '&password=' . $_COOKIE['password'] . '&publish';
						  
                $html = file($recipes);
                
                $file_path = $file_name;
                
                $file_pointer = fopen("../" . $file_path, 'w');
                
                foreach($html as $line)
                {
                        fwrite($file_pointer, $line);
                }
                
                fclose($file_pointer);
                
                return($file_path);    						  
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