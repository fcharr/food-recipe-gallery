<? if(!$publish && isset($login) && $login->id != null) { ?>
<div id="cooks_div">
<? foreach($cooks as $cook) { 
	HTML5::cook($cook);
} ?>

<input type="button" value="add cook" class="add_cook" name="add_cook" id="add_cook" />
</div>
<? } ?>
