<div id="cook">
<? if($login == null || $login->id == null) { ?>
<input type="text" id="login" />
<input type="password" id="password" />
<input type="button" value="login" class="submit_login" name="submit_login" id="submit_login" />
<? } else { ?>
<?= $login->first_name ?> <?= $login->last_name ?>
<input type="hidden" id="login" />
<input type="hidden" id="password" />
<input type="button" value="logout" class="submit_login" name="submit_login" id="submit_login" />
<? } ?>
</div>