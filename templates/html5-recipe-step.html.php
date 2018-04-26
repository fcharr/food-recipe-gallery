<div class="step_images" id="<?= $step['id'] ?>">
<?   foreach($step['images'] as $image) { HTML5::recipe_step_image($image, $login, $publish);
} ?> 

   <? if($can_edit) { ?>
   <div class="add_step_image_div" id="<?= $step['id'] ?>">
   <img src="step-images/step-image.png.php" />
   <form action="../ajax/add-step-image.ajax.php" enctype="multipart/form-data" method="post" class="recipe_step_form" id="recipe_step_form<?= $step['id'] ?>">
   <input type="hidden" id="step_id" name="step_id" value="<?= $step['id'] ?>" />
   <input type="button" class="cancel_add_step_image" id="<?= $step['id'] ?>" value="cancel" />
   <input type="file" class="select_step_image" name="select_step_image" id="<?= $step['id'] ?>" />
   </form> 
   </div>
   <? } ?>  

   <div class="step_instructions_div" id="<?= $step['id'] ?>">
   <? if($can_edit) { ?>
   <textarea class="step_instructions" id="<?= $step['id'] ?>"><?= $step['instructions'] ?></textarea>
 
   <input type="button" value="delete step" class="delete_step" name="delete_step" id="<?= $step['id'] ?>" />
   <input type="button" value="save" class="save_step" name="save_step" id="<?= $step['id'] ?>" />
   <input type="button" class="prompt_add_step_image" id="<?= $step['id'] ?>" value="add step image" />
   <? } else { ?>
   <?= $step['instructions'] ?>
   <? } ?>
   </div> 
</div>