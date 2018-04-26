<?
/*************************************************************************************************************************************************************
scripts.FranciscoCharrua.com
This class is dedicated to preventing unauthorised access to resources. 
The general rule is that, aside from the helper methods, each function is named after the table that it's protecting.
**************************************************************************************************************************************************************/

include_once('login.class.php');

abstract class Permissions
{
         public function loginID()
         {
			    global $db;
                 
                $login = isset($_COOKIE['login']) ? $_COOKIE['login'] : '';
                $password = isset($_COOKIE['password']) ?  LOGIN::encrypt($_COOKIE['password']) : '';
				
                 
                $sql = 'select id from cooks where login = ? and password = ?';
				$cook = $db->execute($sql, $login, $password);
				$cook_id = sizeof($cook) > 0 ? $cook[0]['id'] : 0;
				
				if($login == DB_USER && $password == LOGIN::encrypt(DB_PASS) && $cook_id == 0) 
				{
					$cook_id = -1;
				}
				
				return($cook_id);
         }
		 
		 public function isAdmin() {
			    $login = isset($_COOKIE['login']) ? $_COOKIE['login'] : '';
                $password = isset($_COOKIE['password']) ?  LOGIN::encrypt($_COOKIE['password']) : '';
			 
			 	if($login == DB_USER && $password == LOGIN::encrypt(DB_PASS))
				{
					return(true);
				}
			 
			 	global $db;
                 
				$sql = 'select admin from cooks where login = ? and password = ?';
				$cook = $db->execute($sql, $login, $password);
				
				if(sizeof($cook) > 0) 
				{
					return($cook[0]['admin'] == true);
				} 
				else 
				{
					return(false);
				}
		 }
		 
		 public function isDBAdmin() {
			 $login = isset($_COOKIE['login']) ? $_COOKIE['login'] : '';
             $password = isset($_COOKIE['password']) ?  LOGIN::encrypt($_COOKIE['password']) : '';
			 
			 if($login == DB_USER && $password == LOGIN::encrypt(DB_PASS)) 
			 {
					return(true);
			 }
			 
			 return(false);
		 }
         
         public function step($id)
         {
			    global $db;
				
				if(self::isAdmin()) 
				{
					$sql = 'select cook_id as id from authority, steps where authority.recipe_id = steps.recipe_id and steps.id = ?';
					$cook = $db->execute($sql, $id);
					$cook_id = sizeof($cook) > 0 ? $cook[0]['id'] : -1;
					return($cook_id);
				}
				
                $login_id = self::loginID();
				
				$sql = 'select count(cook_id) as count from authority, steps where authority.recipe_id = steps.recipe_id and steps.id = ? and authority.cook_id = ?';
				$cook = $db->execute($sql, $id, $login_id);
				$cook_id = $cook[0]['count'] > 0 ? $login_id : 0;
				
				return($cook_id);
         }
   
         public function step_image($id)
         {
			    global $db;
				
				if(self::isAdmin()) 
				{
					$sql = 'select cook_id as id from authority, steps, step_images where authority.recipe_id = steps.recipe_id and steps.id = step_images.step_id and step_images.id = ?';
					$cook = $db->execute($sql, $id);
					$cook_id = sizeof($cook) > 0 ? $cook[0]['id'] : -1;
					return($cook_id);
				}
				
				$login_id = self::loginID();
				
				$sql = 'select count(cook_id) as count from authority, steps, step_images where authority.recipe_id = steps.recipe_id and steps.id = step_images.step_id and step_images.id = ? and authority.cook_id = ?';
				$cook = $db->execute($sql, $id, $login_id);
				$cook_id = $cook[0]['count'] > 0 ? $login_id : 0;
				
				return($cook_id);    
         }
         
         public function recipe($id)
         {
			    global $db;
				
				if(self::isAdmin()) 
				{
					$sql = 'select cook_id as id from authority where authority.recipe_id = ?';
					$cook = $db->execute($sql, $id);
					$cook_id = sizeof($cook) > 0 ? $cook[0]['id'] : -1;
					
					return($cook_id);
				}
				
                $login_id = self::loginID();
				
				$sql = 'select count(cook_id) as count from authority where authority.recipe_id = ? and authority.cook_id = ?';
				$cook = $db->execute($sql, $id, $login_id);
				$cook_id = $cook[0]['count'] > 0 ? $login_id : 0;
				
				return($cook_id);
         }
         
         public function ingredient($id)
         {
			    global $db;
				
				if(self::isAdmin()) 
				{
					$sql = 'select cook_id as id from authority, ingredients where authority.recipe_id = ingredients.recipe_id and ingredients.id = ?';
					$cook = $db->execute($sql, $id);
					$cook_id = sizeof($cook) > 0 ? $cook[0]['id'] : -1;
					
					return($cook_id);
				}
			 
                $login_id = self::loginID();
				
				$sql = 'select count(cook_id) as count from authority, ingredients where authority.recipe_id = ingredients.recipe_id and ingredients.id = ? and authority.cook_id = ?';
				$cook = $db->execute($sql, $id, $login_id);
				$cook_id = $cook[0]['count'] > 0 ? $login_id : 0;
				
				return($cook_id);
         }      
}
?>