<div class="cook_div" id="cook_div<?= $cook['id'] ?>">
<input value="delete" class="delete_cook" type="button" name="delete_cook" id="<?= $cook['id'] ?>" />
<input class="cook_login" type="text" id="cook_login<?= $cook['id'] ?>" title="login" value="<?= $cook['login'] ?>" />
<input class="change_cook_password" type="checkbox" id="<?= $cook['id'] ?>" />
<input class="cook_password" type="text" id="cook_password<?= $cook['id'] ?>" disabled="disabled" title="password" />
<input class="cook_email" type="text" id="cook_email<?= $cook['id'] ?>" title="email address" value="<?= $cook['email'] ?>" />
<input class="cook_first_name" type="text" id="cook_first_name<?= $cook['id'] ?>" title="first name" value="<?= $cook['first_name'] ?>" />
<input class="cook_last_name" type="text" id="cook_last_name<?= $cook['id'] ?>" title="last name" value="<?= $cook['last_name'] ?>" />
<input class="cook_admin" type="checkbox" id="cook_admin<?= $cook['id'] ?>"  <? if($cook['admin']) { ?>checked<? } ?> />
<input value="save" class="save_cook" type="button" name="save_cook" id="<?= $cook['id'] ?>" />
</div>
