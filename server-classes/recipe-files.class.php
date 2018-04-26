<?
/*************************************************************************************************************************************************************
scripts.FranciscoCharrua.com
This class is dedicated to providing names for generated html files, generating links, and deleting generated html files.
**************************************************************************************************************************************************************/

abstract class recipeFiles
{
         public function recipe($recipe_id, $cook_id)
         {
			    global $db;
				
				$file_name = '';
					   
			    if($cook_id != null && $cook_id != -1)
				{
					$sql = 'select food.name, cooks.first_name, cooks.last_name from recipes, food, (cooks right join authority on authority.cook_id = cooks.id) where ' .
                       		'recipes.food_id = food.id and authority.recipe_id = recipes.id and authority.recipe_id = ? ' .
							'and authority.cook_id = ?';
					$recipe = $db->execute($sql, $recipe_id, $cook_id);
				}
				else
				{
					$sql = 'select food.name from recipes, food where recipes.id = ?';
					$recipe = $db->execute($sql, $recipe_id);
				}
				
				if(sizeof($recipe) > 0)
				{
					$file_name = str_replace(' ', '-', $recipe[0]['name']) . '-' . str_pad($recipe_id, 3, '0', STR_PAD_LEFT) . '.php';
					$file_name = strtolower($file_name);
				}
				
				return($file_name);
         }
		 
		 public function recipes($page_number, $cook_id = 0, $category_id = 0)
		 {
			 	global $db;
				
				$sql = 'select first_name, last_name from cooks where id = ?';
				$cook = $db->execute($sql, $cook_id);
				
				if(sizeof($cook) > 0) {
					$file_name = strtolower(str_replace(' ', '-', $cook[0]['first_name'] . '-' . $cook[0]['last_name'] . '-'));
				} else {
					$file_name = '';
				}
				
			    $file_name .= 'recipes-' . str_pad($page_number, 3, '0', STR_PAD_LEFT) . '.php';
				
				return($file_name);
		 }
		 
		 public function generated_by($cook_id)
		 {
			 	global $db;
				
				$sql = 'select first_name, last_name from cooks where id = ?';
				$cook = $db->execute($sql, $cook_id);
				
				if(sizeof($cook) > 0) 
				{
					$files = glob('*' . strtolower(str_replace(' ', '-', $cook[0]['first_name'])) . '*' . strtolower(str_replace(' ', '-', $cook[0]['last_name'])) . '*');
				} 
				else 
				{
					$files = array();
				}
				
				return($files);
		 }
		 
		 public function index_page_number($recipe_id, $cook_id, $publish)
		 {
			    global $db;
			 
			    $sql = 'select count(recipes.id) as count from food, recipes, authority where ' . 
			           'recipes.id = authority.recipe_id and recipes.food_id = food.id and recipes.id < ?';
					   	   
			    if($publish)
				{
					$sql .= ' and authority.published = true';
				}
				
				if($cook_id > 0) 
				{
					$sql .= ' and authority.cook_id = ?';
					$rows = $db->execute($sql, $recipe_id, $cook_id);
				} 
				else 
				{
					$rows = $db->execute($sql, $recipe_id);
				}
				
				$count = sizeof($rows) > 0 ? $rows[0]['count'] : 0;
				
				$page = (int) ($count / self::recipes_per_page()) + 1;
				
				return($page);
		 }
		 
		 public function delete($recipe_id, $cook_id)
		 {
			 $file_name = self::recipe($recipe_id, $cook_id);
			 
			 if(file_exists('../' . $file_name))
			 {
				 unlink('../' . $file_name);
			 }
		 }
		 
		 public function delete_all()
		 {
			 global $db;
			 
			 $sql = 'select id from cooks';
			 
			 $cooks = $db->execute($sql);
			 
			 foreach($cooks as $cook)
			 {
				 self::delete_cook($cook['id']);
			 }
		 }
		 
		 public function delete_cook($cook_id)
		 {
			 global $db;
			 
			 $sql = 'select recipe_id as id, cook_id from authority where cook_id = ?';
			 
			 $recipes = $db->execute($sql, $cook_id);
			 
			 foreach($recipes as $recipe)
			 {
				 self::delete($recipe['id'], $recipe['cook_id']);
			 }
			 
			 $index_files = self::generated_by($cook_id);
			 
			 foreach($index_files as $index_file)
			 {
				 if(file_exists('../' . $index_file))
				 {
					 unlink('../' . $index_file);
				 }
			 }
		 }
		 
		 public function brute_delete()
		 {
			 $script_files = Array('../recipes.php', '../recipe.php', '../index.php');
			 
			 $files = glob('../*.*');
			 
			 foreach($files as $file)
			 {
				 if(!in_array($file, $script_files))
				 {
					unlink($file); 
				 }
			 }
		 }
		 
		 public function offset()
		 {
			 return(isset($_GET['offset']) ? $_GET['offset'] : (isset($_POST['offset']) ? $_POST['offset'] : 0));
		 }
		 
		 public function recipes_per_page() 
		 {
			 return(self::rows_per_page() * self::columns_per_page());
		 }
		 
		 public function rows_per_page() 
		 {
			 $rows = isset($_GET['rows']) ? $_GET['rows'] : (isset($_POST['rows']) ? $_POST['rows'] : (isset($_COOKIE['rows']) ? $_COOKIE['rows'] : 10));
			 
			 return($rows);
		 }
		 
		  public function columns_per_page() 
		 {
			 $columns = isset($_GET['columns']) ? $_GET['columns'] : (isset($_POST['columns']) ? $_POST['columns'] : (isset($_COOKIE['columns']) ? $_COOKIE['columns'] : 5));
			 
			 return($columns);
		 }
}
?>