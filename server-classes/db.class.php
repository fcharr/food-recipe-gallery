<?
/*************************************************************************************************************************************************************
scripts.FranciscoCharrua.com
This class handles all MySQL queries, and table creation / deletion.
**************************************************************************************************************************************************************/

define('DB_HOST', 'localhost');
define('DB_USER', 'frank_cooks');
define('DB_PASS', 'dacodor');
define('DB_NAME', 'frank_cooks');

class DB 
{
    
    private $connection;
	
	public function error() 
	{
		return($this->connection->error);
	}
    
    public function __construct($database, $user, $password, $host = 'localhost') 
	{
        $this->connection = new MySQLi($host, $user, $password, $database);
    }
    
    public function __destruct() 
	{
        $this->connection->close();
    }
    
    public function execute($query) 
	{
        $statement = $this->connection->prepare($query);
        
        $args = func_get_args();
        $bind_params = array();
        
        //Set up the bind parameters.
        for ($i = 1; $i < count($args); $i++) 
		{
			if(!isset($bind_params[0])) 
			{
				$bind_params[0] = '';
			}
            $bind_params[0] .= $this->getType($args[$i]);
            $bind_params[$i] = &$args[$i];
        }    
        
        if (count($bind_params) > 0) 
		{
            call_user_func_array(array($statement, 'bind_param'), $bind_params);
        }
        
        $statement->execute();
		
        //Returns a result set, an insert id, or the number of affected rows.
        if ($resultset = $statement->get_result()) 
		{
            $rows = array();
        }
		 else 
		{
            $rows = $statement->insert_id == 0 ? $statement->affected_rows : $statement->insert_id;
        }
        
        while ($resultset != null && $row = $resultset->fetch_assoc()) 
		{
            $rows[] = $row;
        }
        
        if ($resultset != null) 
		{
            $resultset->free();
        }
        
        $statement->close();
        
        return($rows);
    }
    
    private function getType($var) 
	{
        $type = gettype($var);
		$type = $type[0];
		if($type = 'N') $type = 's';
        return($type);
    }    
    
    //Helper functions.
    
    static public function toInt($var) 
	{
        return(0 + $var);
    }
    
    static public function toDouble($var) 
	{
        return(0.0 + $var);
    }
    
    static public function toString($var) 
	{
        return('' . $var);
    }
	
	public function createCooks() 
	{
		$sql =
		'create table if not exists cooks
		(
		id int primary key auto_increment,
		login varchar(64),
		email varchar(64),
		first_name varchar(64),
		last_name varchar(64),
		password varchar(128),
		admin bool default false
		)';
		
		$this->execute($sql);
	}
	
	public function createFood() 
	{
		$sql =
		'create table if not exists food
		(
		id int primary key auto_increment,
		name varchar(64)
		)';
		
		$this->execute($sql);
	}
	
	public function createCategories() 
	{
		$sql =
		'create table if not exists categories
		(
		id int primary key auto_increment,
		name varchar(64)
		)';
		
		$this->execute($sql);
	}
	
	public function createUnits() 
	{
		$sql =
		'create table if not exists units
		(
		id int primary key auto_increment,
		name varchar(64)
		)';
		
		$this->execute($sql);
	}
	
	public function createRecipes() 
	{		
		$sql =
		'create table if not exists recipes
		(
		id int primary key auto_increment,
		food_id int,
		description text,
		foreign key (food_id) references food (id)
		)';
		
		$this->execute($sql);
	}
	
	public function createCategorizedFood() 
	{
		$sql =
		'create table if not exists categorized_food
		(
		id int primary key auto_increment,
		category_id int,
		food_id int,
		foreign key (category_id) references categories (id),
		foreign key (food_id) references food (id)
		)';
		
		$this->execute($sql);
	}
	
	public function createAuthority() 
	{
		$sql =
		'create table if not exists authority
		(
		id int primary key auto_increment,
		cook_id int,
		recipe_id int,
		published bool default false,
		foreign key (cook_id) references cooks (id), 
		foreign key (recipe_id) references recipes (id)
		)';
		
		$this->execute($sql);
	}
	
	public function createSteps() 
	{
		$sql =
		'create table if not exists steps
		(
		id int primary key auto_increment,
		recipe_id int,
		instructions text,
		`order` int,
		foreign key (recipe_id) references recipes (id)
		)';
		
		$this->execute($sql);
	}
	
	public function createIngredients() 
	{
		$sql =
		'create table if not exists ingredients
		(
		id int primary key auto_increment,
		recipe_id int,
		food_id int,
		quantity int,
		unit_id int,
		`order` int,
		foreign key (recipe_id) references recipes (id),
		foreign key (food_id) references food (id),
		foreign key (unit_id) references units (id)
		)';
		
		$this->execute($sql);
	}
	
	public function createRecipeImages() 
	{
		$sql = 
		'create table if not exists recipe_images
		(
		id int primary key auto_increment,
		recipe_id int,
		file_name varchar(64),
		file blob,
		foreign key (recipe_id) references recipes (id)
		)';
		
		$this->execute($sql);
	}
	
	public function createStepImages() 
	{
		$sql =
		'create table if not exists step_images
		(
		id int primary key auto_increment,
		step_id int,
		file_name varchar(64),
		file blob,
		foreign key (step_id) references steps (id)
		)';
		
		$this->execute($sql);
	}
	
	public function deleteAll() 
	{
		$sql = 'drop table if exists step_images, recipe_images, ingredients, authority, categorized_food';
		$this->execute($sql);
		
		$sql = 'drop table if exists steps, recipes';
		$this->execute($sql);
		
		$sql = 'drop table if exists cooks, food, units, categories';
		$this->execute($sql);
	}
}

$db = new DB(DB_NAME, DB_USER, DB_PASS, DB_HOST);
?>