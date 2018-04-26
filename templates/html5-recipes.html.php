<? if(!$publish) { ?>
<div id="publish_div">
<? if($can_edit) { ?>
<input id="publish" type="button" class="publish" name="publish" value="publish" />
<label for="rows">rows</label> <input type="text" value="<?= $rows_per_page ?>" size="2" id="rows">
<label for="columns">columns</label> <input type="text" value="<?= $columns_per_page ?>" size="2" id="columns">
<? } ?>
<? HTML5::login($login, $cooks, $publish); ?>
</div>
<? } ?>

<div class="recipes">
<? 
$count = 0;
foreach($recipes->list as $recipe) { 

if($count % $rows_per_page == 0) {?>
<div class="column">
<? }

HTML5::recipe_link($recipe, $login, $publish);

if($count % $rows_per_page == $rows_per_page - 1 || $count == $recipes->number - 1 - $offset) {?>
</div>
<? }
$count++;
} ?>
<? 
if(!$publish) {
	HTML5::add_recipe($login);
}

HTML5::index_page_links($recipes, $login->id, $publish); 

if($is_db_admin) {
?>
<input type="button" id="delete_all" value="delete everythting" />
<? } ?>
<? if($can_edit && !$publish) { ?>
<br />
<label for="delete_files">delete files</label>
<input type="checkbox" id="delete_files" />
<? } ?>
</div>