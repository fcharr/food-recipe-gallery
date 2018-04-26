function cook()
{ 
		 $('.save_description').click(function(data) {save_description(data.target.id);});
		 $('.add_ingredient').click(function(data) {add_ingredient(data.target.id);});
		 $('.save_ingredient').click(function(data) {save_ingredient(data.target.id);});
		 $('.delete_ingredient').click(function(data) {delete_ingredient(data.target.id);});
		 
		 $('.add_step').click(function(data) {add_step_instructions(data.target.id)});
		 $('.save_step').click(function(data) {save_step_instructions(data.target.id)});
		 $('.delete_step').click(function(data) {delete_step(data.target.id)});
		 $('.delete_step_image').click(function(data) {delete_step_image(data.target.id)});
		 $('.select_step_image').change(function(data) {add_step_image(data.target.id)});
		 $('.step_image').change(function(data) {save_step_image(data.target.id)});
		 
		 $('.select_recipe_image').change(function() {save_recipe_image()});
		 $('.save_food').click(function(data) {change_recipe_name(data.target.id)});
		 $('.publish').click(function(data) {publish(data.target.id);});
		 
		 $('#description').keyup(function() {$('.save_description').show();});
		 $('#food_name').keyup(function() {$('.save_food').show();});
		 
		 $.each($('.ingredient'),
		 function(key, value) {
			 $('#food_name' + value.id + 
			   ', #food_unit' + value.id + 
			   ', #food_quantity' + value.id).keyup(function() {$('[class=save_ingredient][id=' + value.id + ']').show();});
		 });
		 
		 $('.prompt_add_step_image').click(function(data) {prompt_add_step_image(data.target.id);});
		 $('.cancel_add_step_image').click(function(data) {cancel_add_step_image(data.target.id)});
		 
		 $.each($('.step_instructions'),
		 function(key, value) {
			 $('[class=step_instructions][id=' +  value.id + ']').keyup(function() {$('[class=save_step][id=' +  value.id + ']').show();});
		 });
		  
		 $.each($("form[id^='recipe_step_form']"),
		 function(key, value) {
			 $('#' + value.id).ajaxForm({complete: function(data) {show_added_step_image(data.responseText, $('#' + value.id + ' #step_id').val());}});
		 });
		 
		 $.each($("form[id^='step_image_form']"),
		 function(key, value) {
			 $('#' + value.id).ajaxForm({complete: function(data) {eval(data.responseText);}});
		 });
		 
		 $('#recipe_image_form').ajaxForm({complete: function(data) {eval(data.responseText);}});
}

function save_description(recipe_id)
{		 
		 $.post('ajax/save-recipe-description.ajax.php',
		        {recipe_id: recipe_id, 
				 description: $('#description').val()},
				function(data) {eval(data);});
}

function save_ingredient(ingredient_id)
{
		 $.post('ajax/save-ingredient.ajax.php',
		        {ingredient_id: ingredient_id, 
				 food_name: $('#food_name' + ingredient_id).val(), 
				 food_unit: $('#food_unit' + ingredient_id).val(), 
				 food_quantity: $('#food_quantity' + ingredient_id).val()},
				function(data) {eval(data);});
}

function add_ingredient(recipe_id)
{
		 $.post('ajax/add-ingredient.ajax.php',
		        {recipe_id: recipe_id, food_quantity: 1},
				function(data) {show_added_ingredient(data);});	 
}

function show_added_ingredient(html)
{
         $('.save_ingredient').unbind('click');
		 $('.delete_ingredient').unbind('click');
		 	    
	     $('#add_ingredient_div').before(html);
		 
		 $('.save_ingredient').click(function(data) {save_ingredient(data.target.id);});
		 $('.delete_ingredient').click(function(data) {delete_ingredient(data.target.id);});
		 
		 $.each($('.ingredient'),
		 function(key, value) {
			 $('#food_name' + value.id + ', #food_unit' + value.id + ', #food_quantity' + value.id).unbind('keypress');
			   			 
			 $('#food_name' + value.id + 
			   ', #food_unit' + value.id + 
			   ', #food_quantity' + value.id).keypress(function() {$('[class=save_ingredient][id=' + value.id + ']').show();});
		 });
}

function change_recipe_name(recipe_id)
{
		 $.post('ajax/change-recipe-name.ajax.php',
		        {recipe_id: recipe_id, food_name: $('#food_name').val(), clone_recipe: $('#clone_recipe').prop('checked')},
				function(data) {eval(data);});
}

function delete_ingredient(ingredient_id)
{		 
		 $.post('ajax/delete-ingredient.ajax.php', {ingredient_id: ingredient_id}, function(data) {eval(data);});
}

function save_step_instructions(step_id)
{
         $.post('ajax/save-step-instructions.ajax.php', {step_id: step_id, instructions: $('[class="step_instructions"][id=' + step_id +  ']').val()}, function(data) {eval(data);});
}

function add_step_instructions(recipe_id)
{
         $.post('ajax/add-step-instructions.ajax.php', {recipe_id: recipe_id}, function(data) {show_added_step(data);});
}

function show_added_step(html)
{		 
	     $('#add_step').before(html);
		 
		 step_id = $('.step_instructions_div', html).attr('id');
		 
		 $('#recipe_step_form' + step_id).ajaxForm({complete: function(data) {show_added_step_image(data.responseText, $('#recipe_step_form' + step_id + ' #step_id').val());}});
		
         $.each($('.step_instructions'),
		 function(key, value) {
			 $('[class=step_instructions][id=' +  value.id + ']').unbind('keyup');
			 $('[class=step_instructions][id=' +  value.id + ']').keyup(function() {$('[class=save_step][id=' +  value.id + ']').show();});
		 });		 
		 
		 $('[class=save_step][id=' + step_id + ']').click(function(data) {save_step_instructions(data.target.id)});
		 $('[class=delete_step][id=' + step_id + ']').click(function(data) {delete_step(data.target.id)});	
		 
		 $('[class=prompt_add_step_image][id=' + step_id + ']').click(function(data) {prompt_add_step_image(data.target.id);});
		 $('[class=cancel_add_step_image][id=' + step_id + ']').click(function(data) {cancel_add_step_image(data.target.id)});
		 $('[class=select_step_image][id=' + step_id + ']').change(function(data) {add_step_image(data.target.id)}); 
}

function delete_step(step_id)
{ 
         $.post('ajax/delete-step.ajax.php', {step_id: step_id}, function(data) {eval(data);});
}

function delete_step_image(step_image_id)
{
         $.post('ajax/delete-step-image.ajax.php', {step_image_id: step_image_id}, function(data) {eval(data);});
}

function add_step_image(id)
{
		if($('[class=select_step_image][id=' + id + ']').val() != '')
		{
        	$('#recipe_step_form' + id).submit();
		}
}

function cancel_add_step_image(id)
{
	     $('[class=add_step_image_div][id=' + id + ']').hide();
		 $('[class=prompt_add_step_image][id=' + id + ']').show();
}

function prompt_add_step_image(id)
{
	     $('[class=add_step_image_div][id=' + id + ']').show();
		 $('[class=prompt_add_step_image][id=' + id + ']').hide();
}

function show_added_step_image(html, step_id)
{
	     $('.delete_step_image').unbind('click');
		 $('.step_image').unbind('change');
	
	     $('[class=add_step_image_div][id=' + step_id + ']').before(html);
		 $('[class=select_step_image][id=' + step_id + ']').val('');
	     $('[class=add_step_image_div][id=' + step_id + ']').hide();
		 $('[class=prompt_add_step_image][id=' + step_id + ']').show();	
		 
		 $.each($("form[id^='step_image_form']"),
		 function(key, value) {
			 $('#' + value.id).ajaxForm({complete: function(data) {eval(data.responseText);}});
		 });		 
		 
		 $('.delete_step_image').click(function(data) {delete_step_image(data.target.id)});
		 $('.step_image').change(function(data) {save_step_image(data.target.id)});
}

function save_step_image(id)
{         
		if($('[class=step_image][id=' + id +  ']').val() != '')  
		{
			$('#step_image_form' + id).submit();
		}
}

function save_recipe_image()
{
		if($('.select_recipe_image').val() != '')  
		{
			 $('#recipe_image_form').submit();
		}
}

function publish(recipe_id)
{
         $.post('ajax/publish-my-recipe.ajax.php', {recipe_id: recipe_id}, function(data) {eval(data);});
}