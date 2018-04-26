<?
$publish = false;
$root = '';

include('server-classes/db.class.php');
include('server-classes/login.class.php');
include('server-classes/recipe-files.class.php');
include('templates/html5.class.php');

$cooks = LOGIN::cooks();

foreach($cooks as $key => $cook) {
	$cooks[$key]['files'] = recipeFiles::generated_by($cook['id']);
}

$files = array();

for($page = 1; $page <= 20; $page++) {
	$file = recipeFiles::recipes($page);
	if(file_exists($file)) {
		$files[] = $file;
	}
}

$header = array('title' => 'food recipes');

HTML5::header($header, $publish);
HTML5::index($cooks, $files);
HTML5::footer(); 
?>