<a href="recipes.php">The Kitchen</a>
<br />

<? foreach($cooks as $cook) { ?>
<br />
	<? HTML5::cook_index_links($cook); ?>
<? } ?>

<br />
<? HTML5::index_links($files); ?>