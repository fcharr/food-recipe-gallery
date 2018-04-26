<?
/*************************************************************************************************************************************************************
scripts.FranciscoCharrua.com
The only class file that did not go in the server-classes folder. Handles passing variables to the html templates.
The reason I have so many small html templates, is to have them work with my ajax calls.
**************************************************************************************************************************************************************/

abstract class HTML5 
{
	private function _js_file() 
	{
		$pathinfo = pathinfo($_SERVER['PHP_SELF']);
		return(self::_root() . 'client-scripts/' . $pathinfo['filename'] . '.js');
	}
	
	private function _css_file() 
	{
		$pathinfo = pathinfo($_SERVER['PHP_SELF']);
		return(self::_root() . 'css/' . $pathinfo['filename'] . '.css');
	}
	
	private function _root() 
	{
		$folder_depth = substr_count($_SERVER["PHP_SELF"], "/", strpos($_SERVER["PHP_SELF"], ".com")) - 1;
		
        if($folder_depth == 0)
		{
           $root_path = "./";
		}
        else
		{
		   $root_path = str_repeat("../", $folder_depth);
		}
		
		return($root_path);
	}
	
	public function header($header, $publish) 
	{
		$js_file = self::_js_file();
		$css_file = self::_css_file();
		$root = self::_root();
		include('html5-header.html.php');
	}
	
	public function footer() 
	{
		include('html5-footer.html.php');
	}
	
	public function index($cooks, $files) 
	{
		include('html5-index.html.php');
	}
	
	public function cook_index_links($cook) 
	{
		for($i = 0; $i < sizeof($cook['files']); $i++)
		{
			$file = $cook['files'][$i];
			
			if($i == 0) 
			{
				$file_name = $cook['first_name'] . ' ' . $cook['last_name'];
			} 
			else 
			{
				$file_name = 'P' . ($i + 1);
			}
			
			include('html5-index-link.html.php');
		}
	}
	
	public function index_links($files) 
	{
		for($i = 0; $i < sizeof($files); $i++) 
		{
			$file = $files[$i];
			$file_name = 'P' . ($i + 1);
			include('html5-index-link.html.php');
		}
	}
	
	public function login($login, $cooks, $publish) 
	{
		include('html5-login.html.php');
		
		if($login->id == -1) 
		{
			include('html5-cooks.html.php');
		}
	}
	
	public function add_recipe($login) 
	{
		if($login->id != null) 
		{
			include('html5-add-recipe.html.php');
		}
	}
	
	public function recipes($recipes, $login, $cooks, $publish) 
	{
		$can_edit = isset($login) && $login->id != null;
		$rows_per_page = recipeFiles::rows_per_page();
		$columns_per_page = recipeFiles::columns_per_page();
		$offset = recipeFiles::offset();
		$is_db_admin = Permissions::isDBAdmin();
		include('html5-recipes.html.php');
	}
	
	public function index_page_links($recipes, $cook_id, $publish) 
	{
		$recipes_per_page = recipeFiles::recipes_per_page();
		$rows_per_page = recipeFiles::rows_per_page();
		$columns_per_page = recipeFiles::columns_per_page();
		$offset = recipeFiles::offset();
		
		$last_page_length = $recipes->number % $recipes_per_page != 0 ? $recipes->number % $recipes_per_page : $recipes_per_page;
		
		$previous_page_offset = $offset - $recipes_per_page >= 0 ? $offset - $recipes_per_page : $recipes->number - $last_page_length;
		$next_page_offset = $recipes->number > $offset + $recipes_per_page ? $offset + $recipes_per_page : 0;
		
		if($publish)
		{
			include_once('server-classes/recipe-files.class.php');
			$previous_page = (int) ($previous_page_offset / $recipes_per_page) + 1;
		    $next_page = (int) ($next_page_offset / $recipes_per_page) + 1;
			$previous_page_url = recipeFiles::recipes($previous_page, $cook_id);
			$next_page_url = recipeFiles::recipes($next_page, $cook_id);
		}
		else
		{
			$previous_page_url = 'recipes.php?offset=' . $previous_page_offset . '&rows=' . $rows_per_page . '&columns=' . $columns_per_page;
		    $next_page_url = 'recipes.php?offset=' . $next_page_offset . '&rows=' . $rows_per_page . '&columns=' . $columns_per_page;
		}
		
		if($previous_page_offset != $offset && $next_page_offset != $offset) 
		{
			include('html5-index-page-links.html.php');
		}
	}
	
	public function recipe_link($recipe, $login, $publish) 
	{
		$can_edit = ($login != null && $login->id != null) && (Permissions::recipe($recipe['recipe_id']) == $login->id || $login->admin == true);
		
		if($publish)
		{
			include_once('server-classes/recipe-files.class.php');
			$recipe_url = recipeFiles::recipe($recipe['recipe_id'], $login->id);
		}
		else
		{
			$recipe_url = 'recipe.php?id=' . $recipe['recipe_id'] . '&rows=' . recipeFiles::rows_per_page() . '&columns=' . recipeFiles::columns_per_page();
		}
		
		include('html5-recipe-link.html.php');
	}
	
	public function recipe($recipe, $login, $cooks, $publish) 
	{
		$root = self::_root();
		$can_edit = ($login != null && $login->id != null) && (Permissions::recipe($recipe->id) == $login->id || $login->admin == true) && ($publish == false);
		
		include_once($root . 'server-classes/recipe-files.class.php');
		$page_number = recipeFiles::index_page_number($recipe->id, $login->id, $publish);
		
		$recipe_id = $recipe->id;
		$food = $recipe->food;
		$ingredients = $recipe->ingredients;
		$steps = $recipe->steps;
		
		if($food['file_name'] == '') 
		{
			$food['file_name'] = 'food-image.png.php';
		}
		
		if($publish)
		{
			$index_url = recipeFiles::recipes($page_number, $login->id);
		}
		else
		{
			$index_url = $root . 'recipes.php?offset=' . ($page_number - 1) * recipeFiles::recipes_per_page() . '&rows=' . recipeFiles::rows_per_page() . '&columns=' . recipeFiles::columns_per_page();
		}
		
		include('html5-recipe.html.php');
	}
	
	public function recipe_step($step, $login, $publish) 
	{
		$can_edit = ($login != null && $login->id != null) && (Permissions::step($step['id']) == $login->id || $login->admin == true) && ($publish == false);
		
		$root = self::_root();
		include('html5-recipe-step.html.php');
	}
	
	public function recipe_step_image($image, $login, $publish) 
	{
		$can_edit = ($login != null && $login->id != null) && (Permissions::step_image($image['id']) == $login->id || $login->admin == true) && ($publish == false);
		
		$root = self::_root();
		include('html5-recipe-step-image.html.php');
	}
	
	public function recipe_ingredient($ingredient, $login, $publish) 
	{
		$can_edit = ($login != null && $login->id != null) && (Permissions::ingredient($ingredient['id']) == $login->id || $login->admin == true) && ($publish == false);
		
		include('html5-recipe-ingredient.html.php');
	}
	
	public function cook($cook) 
	{
		include('html5-cook.html.php');
	}
	
	public function top_ad($publish) 
	{
		include('html5-top-ad.html.php');
	}
	
	public function side_ad($publish) 
	{
		include('html5-side-ad.html.php');
	}
}
?>