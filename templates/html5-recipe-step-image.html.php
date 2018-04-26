<div id="step_image_div<?= $image['id'] ?>">
<img class="step_image" id="step_image<?= $image['id'] ?>" src="step-images/<?= $image['file_name'] ?>" />
<? if($can_edit) { ?>
<form action="../ajax/save-step-image.ajax.php" enctype="multipart/form-data" method="post" id="step_image_form<?= $image['id'] ?>">
<input type="button" class="delete_step_image" name="delete_step_image" value="delete" id="<?= $image['id'] ?>" />
<input type="hidden" name="step_image_id" value="<?= $image['id'] ?>" />
<input type="file" class="step_image" name="step_image" id="<?= $image['id'] ?>" />
</form>
<? } ?>
</div>  