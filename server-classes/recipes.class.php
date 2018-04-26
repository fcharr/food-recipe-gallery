<?
/*************************************************************************************************************************************************************
scripts.FranciscoCharrua.com
This class is dedicated to providing data for template use.
**************************************************************************************************************************************************************/

class RECIPES
{
      private $list;
	  private $number;

      function __construct($cook_id, $publish = false)
      {
				global $db;
				
				$db->createFood();
				
				$db->createRecipes();			
				
				$db->createAuthority();				
				
				$sql = 'select recipes.id as recipe_id, name from food, (recipes left join authority on recipes.id = authority.recipe_id) where ' . 
					  	'recipes.food_id = food.id';
				
				if($publish)
				{
				   $sql .= ' and authority.published = true';
				}
				
				if($cook_id != -1) {
				   $sql .= ' and authority.cook_id = ?';
				}
				
				
			    $sql .= ' limit ?, ?';
			  
			    if($cook_id != -1) {
				    $this->list = $db->execute($sql, $cook_id, recipeFiles::offset(), recipeFiles::recipes_per_page());
			    } else {
				    $this->list = $db->execute($sql, recipeFiles::offset(), recipeFiles::recipes_per_page());
			    }
				
				
				$sql = 'select count(recipes.id) as count from food, (recipes left join authority on recipes.id = authority.recipe_id) where ' .
						'recipes.food_id = food.id';
						  
				if($publish)
				{
				   $sql .= ' and authority.published = true';
				}	
				
				if($cook_id != -1) {
					$sql .= ' and authority.cook_id = ?';
					$count = $db->execute($sql, $cook_id);
				} else {
					$count = $db->execute($sql);
				}
										  
				
				$this->number = $count[0]['count'];	   
      }
      
      function __get($property)
      {
               return($this->$property);
      }      
}
?>