<?
/*************************************************************************************************************************************************************
scripts.FranciscoCharrua.com
This class is dedicated to providing data for template use.
**************************************************************************************************************************************************************/

class RECIPE
{
	  private $id;
	
      private $food;

      private $ingredients;
      
      private $steps;
	  
	  private $credit;
      
      function __construct($id)
      {
		  		global $db;
		       $this->id = $id;
			   
			   $db->createRecipes();
			   
			   $db->createRecipeImages();
			   
			   $db->createSteps();
			   
			   $db->createStepImages();
			   
			   $db->createUnits();
			   
			   $db->createCategories();
			   
			   $db->createCategorizedFood();
			   
			   $db->createIngredients();
			   
	           //Recipe steps.
               $sql = 'select steps.id, instructions  from recipes, steps ' . 
                      'where steps.recipe_id = recipes.id and recipes.id = ? order by steps.order';
			   
			   $this->steps = $db->execute($sql, $id);
			   
			   for($index = 0; $index < count($this->steps); $index++)
			   {
				   $sql = 'select id, file_name from step_images where step_id = ?';
				   
				   $this->steps[$index]['images'] = $db->execute($sql, $this->steps[$index]['id']);
			   }			   
               
			   //Ingredients.
               $sql = 'select ingredients.id, food.id as food_id, food.name as food_name, quantity, units.id as unit_id, units.name as unit_name from ' .
                      '(ingredients left join food on ingredients.food_id = food.id) left join units on ingredients.unit_id = units.id ' .
                      'where recipe_id = ? order by ingredients.order';
			   
			   $this->ingredients = $db->execute($sql, $id);
               
               $sql = 'select food_id, name, recipes.description, file_name from (recipes left join recipe_images on recipes.id = recipe_images.recipe_id), food ' . 
                      'where recipes.food_id = food.id and recipes.id = ?';
			   
			   $this->food = $db->execute($sql, $id);
			   $this->food = $this->food[0];
			   
			  //Credit.
			  $db->createCooks();
				  
			  $sql = 'select cook_id as id , last_name, first_name from authority, cooks where authority.cook_id = cooks.id and authority.recipe_id = ?';
				  
			  $cooks = $db->execute($sql, $this->id);
			  
			  if(sizeof($cooks) > 0) {
				  $this->credit = $cooks[0];
			  } else {
				  $this->credit = array('id' => -1, 'first_name' => '', 'last_name' => '');
			  }
      }
      
      function __get($property)
      {
               return($this->$property);
      }      
}
?>