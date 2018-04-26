<div class="recipe_div" id="<?= $recipe['recipe_id'] ?>">

<? if($can_edit && !$publish) { ?>
<input type="button" class="delete_recipe" id="<?= $recipe['recipe_id'] ?>" value="delete" />
<? } ?>

<a href="<?= $recipe_url ?>"><?= $recipe['name'] ?></a>
<br />
</div>