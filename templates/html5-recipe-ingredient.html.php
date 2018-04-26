<div class="ingredient" id="<?= $ingredient['id'] ?>">
<? if($can_edit) { ?>
<input type="button" value="delete" class="delete_ingredient" name="delete_ingredient" id="<?= $ingredient['id'] ?>" />
<input class="food_quantity" type="text" id="food_quantity<?= $ingredient['id'] ?>" title="quantity" value="<?= $ingredient['quantity'] ?>" />
<input class="food_unit" type="text" id="food_unit<?= $ingredient['id'] ?>" title="unit" value="<?= $ingredient['unit_name'] ?>" />
<input class="food_name" type="text" id="food_name<?= $ingredient['id'] ?>" title="name" value="<?= $ingredient['food_name'] ?>" />
<input type="button" value="save" class="save_ingredient" name="save_ingredient" id="<?= $ingredient['id'] ?>" />
<? } else { ?>
<?= $ingredient['quantity'] ?>&nbsp;<?= $ingredient['unit_name'] ?>&nbsp;<?= $ingredient['food_name'] ?>
<? } ?>
</div>   