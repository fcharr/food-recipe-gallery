<? if(!$publish) { ?>
<div id="publish_div">
<? if($can_edit) { ?>
<input id="<?= $recipe_id ?>" type="button" class="publish" name="publish" value="publish" />
<? } ?>
<? HTML5::login($login, $cooks, $publish); ?>
</div>
<? } ?>

<div class="recipe_div" id="recipe_<?= $recipe_id ?>">
<div class="recipe_image_div">
<img class="recipe_image" id="recipe_image" src="food-images/<?= $food['file_name'] ?>" />
<? if($can_edit) { ?>
<form id="recipe_image_form" action="../ajax/save-recipe-image.ajax.php" enctype="multipart/form-data" method="post">
<input type="hidden" name="recipe_id" value="<?= $recipe_id ?>" />
<input type="file" class="select_recipe_image" name="select_recipe_image" id="<?= $recipe_id ?>" />
</form>
<? } ?>
</div>
</div>

<div class="recipe_description_div">
<? HTML5::top_ad($publish); ?>

<? if($can_edit) { ?>
<textarea id="description" class="description"><?=  $food['description'] ?></textarea>
<? } else { ?>
<?=  $food['description'] ?>
<? } ?>

<? if($can_edit) { ?>
<br />
<input type="button" value="save" name="save_description" class="save_description" id="<?= $recipe_id ?>" />
<? } ?>
</div>

<div class="recipe_name">
<? if($can_edit) { ?>
<input type="text" id="food_name" value="<?= $food['name'] ?>" />
<input type="button" value="save" name="save_food" class="save_food" id="<?= $recipe_id ?>" />
<label for="clone_recipe">clone</label><input type="checkbox" id="clone_recipe" />
<? } else { ?>
<?= $food['name'] ?>
<? } ?>

<div class="ingredients">
<? foreach($ingredients as $ingredient) {
HTML5::recipe_ingredient($ingredient, $login, $publish);
} ?>
<? if($can_edit) { ?>
<div class="ingredient" id="add_ingredient_div"><input type="button" value="add ingredient" class="add_ingredient" name="add_ingredient" id="<?= $recipe_id ?>" /></div>
<? } ?>
</div>
<div class="nav"><a href="<?= $index_url ?>">my recipes</a></div>
</div>

<hr />

<? HTML5::side_ad($publish); ?>

<div class="recipe_steps_div">
<? foreach($steps as $step) { 
HTML5::recipe_step($step, $login, $publish);
} ?>

<? if($can_edit) { ?>
<div class="recipe_steps" id="add_step">
<input type="button" value="add step" class="add_step" name="add_step" id="<?= $recipe_id ?>" />
</div>
<? } ?>
</div>
