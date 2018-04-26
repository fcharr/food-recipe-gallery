<?
/*************************************************************************************************************************************************************
scripts.FranciscoCharrua.com
This class is dedicated to creating, updating, and deleting recipe ingredients.
**************************************************************************************************************************************************************/

require('edit-recipe.class.php');

abstract class EditRecipeIngredients extends EditRecipe
{
         public function saveIngredient($ingredient_id, $food_name, $food_quantity, $unit_name)
         {
			    global $db;
			 
                $food_id = self::saveFood($food_name);
                
                $unit_id = self::saveUnit($unit_name);
				
				//Updates the ingredient.
				$sql = 'update ingredients set quantity = ?, food_id = ?, unit_id = ? where id = ?';
				$db->execute($sql, $food_quantity, $food_id, $unit_id, $ingredient_id);
         }
         
         public function addIngredient($recipe_id, $food_name, $food_quantity, $unit_name)
         {
			    global $db;
			 
                $food_id = $food_name != '' ? self::saveFood($food_name) : null;
                
                $unit_id = $unit_name != '' ? self::saveUnit($unit_name) : null;
                
                //Limits the number of blank ingredients added.                
                $sql = 'select count(id) as count from ingredients where food_id is null and recipe_id = ?';
				$ingredient = $db->execute($sql, $recipe_id);
				$count = $ingredient[0]['count'];
				
                if($count > 2)
                {
                   return(0);
                }                                
                
                //Makes the inserted ingredient be the last one.
                $sql = 'select coalesce(max(`order`) + 1, 1) as `order` from ingredients where recipe_id = ?';
				$ingredient = $db->execute($sql, $recipe_id);
				$order = $ingredient[0]['order'];
 
                //Inserts the ingredient.
                $sql = 'insert into ingredients (recipe_id, food_id, unit_id, quantity, `order`) values (?, ?, ?, ?, ?)';
				$ingredient_id = $db->execute($sql, $recipe_id, $food_id, $unit_id, $food_quantity, $order);

                return($ingredient_id);
         }
         
         public function deleteIngredient($ingredient_id)
         {
			    global $db;
				
				$sql = 'delete from ingredients where id = ?';
				$db->execute($sql, $ingredient_id);
         }
}
?>