<?
/*************************************************************************************************************************************************************
scripts.FranciscoCharrua.com
This class could have been called COOKS, it handles logging and user (cooks) management.
**************************************************************************************************************************************************************/

class LOGIN
{      
      private $user;
      private $password;
	  
	  private $result;
      
      function __construct($user, $password)
      {
		       	global $db;
			   
			   	$db->createCooks();
		  
			   $this->password = $password;
			   $password =  self::encrypt($password);
			   $this->user = $user;
			   
			   $sql = 'select id, email, first_name, last_name, admin from cooks where binary login = ? and password = ?';
			   $this->result = $db->execute($sql, $user, $password);
			   
			   if($user == DB_USER && $password == self::encrypt(DB_PASS)) 
			   {
				   $this->result[0] = array('id' => '-1', 'first_name' => 'the', 'last_name' => 'admin', 'admin' => true, 'email' => 'me@gmail.com');
			   }
      }
      
      function __get($property)
      {
		    	if(isset($this->$property))
			      return($this->$property);
				  
			  	if(isset($this->result[0]))
		          return($this->result[0][$property]);
				  
				return(null);
      }
	  
	  static public function encrypt($password) 
	  {
		     return(md5($password));
	  }
        
	  public function cooks() 
	  {
		  global $db;
		  
		  $sql = 'select id, login, email, first_name, last_name, admin from cooks';
		  
		  return($db->execute($sql));
	  }
	  
	  public function setCookPassword($cook_id, $cook_password) 
	  {
		  global $db;
		  
		  $sql = 'update cooks set password = ? where id = ?';
		  
		  return($db->execute($sql, self::encrypt($cook_password), $cook_id));
	  }
	  
	  public function saveCook($cook_id, $cook_login, $cook_email, $cook_first_name, $cook_last_name, $cook_admin) 
	  {
		  global $db;
		  
		  $cook_admin = $cook_admin == 'true' ? 1 : 0;
		  
		  $sql = 'update cooks set login = ?, email = ?, first_name = ?, last_name = ?, admin = ? where id = ?';
		  
		  return($db->execute($sql, $cook_login, $cook_email, $cook_first_name, $cook_last_name, $cook_admin, $cook_id));
	  }
	  
	  public function addCook($cook_login, $cook_email, $cook_first_name, $cook_last_name, $cook_admin, $cook_password) 
	  {
		  global $db;
		  
		  $cook_admin = $cook_admin == 'true' ? 1 : 0;
		  
		  $sql = 'insert into cooks (login, email, first_name, last_name, admin, password) values (?, ?, ?, ?, ?, ?)';
		  
		  return($db->execute($sql, $cook_login, $cook_email, $cook_first_name, $cook_last_name, $cook_admin, self::encrypt($cook_password)));
	  }
	  
	  public function deleteCook($cook_id) 
	  {
		  global $db;
		  
		  $sql = 'delete from authority where cook_id = ?';
		  
		  $db->execute($sql, $cook_id);
		  
		  $sql = 'delete from cooks where id = ?';
		  
		  $db->execute($sql, $cook_id);
	  }
}
?>