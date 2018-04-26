function cook()
{
		 $('.prompt_add_recipe').click(function() {prompt_add_recipe();});
		 $('.add_recipe').click(function() {add_recipe();});
		 $('#food_name').keypress(function() {$('#add_recipe').show();});
		 $('.cancel_add_recipe').click(function() {cancel_add_recipe();});
		 $('.delete_recipe').click(function(data) {delete_recipe(data.target.id);});
		 $('.publish').click(function(data) {publish(0, _rows(), _columns());});
		 $('#rows, #columns').change(function() {refresh()});
		 $('#delete_all').click(function() {delete_all();});
}

function prompt_add_recipe()
{
	    $('.add_recipe_div').show();
		$('.prompt_add_recipe_div').hide();
}

function add_recipe()
{
		 $.post('ajax/add-recipe.ajax.php',
		        {food_name: $('#food_name').val()},
				function(data) {show_added_recipe(data);});
}

function cancel_add_recipe()
{
	     $('#add_recipe').hide();
		 $('#food_name').val('');
		 $('#add_recipe_div').hide();
		 $('.prompt_add_recipe_div').show();
}

function show_added_recipe(html)
{
	     $('#add_recipe_div').before(html);
	     $('#add_recipe').hide();
		 $('#food_name').val('');
		 $('#add_recipe_div').hide();
		 $('.prompt_add_recipe_div').show();
		 $('.delete_recipe').unbind('click');
		 $('.delete_recipe').click(function(data) {delete_recipe(data.target.id);}); 
}

function delete_recipe(recipe_id)
{
	     $.post('ajax/delete-recipe.ajax.php',
		        {recipe_id: recipe_id, delete_files: $('#delete_files').attr('checked')}, 
				function(data) {eval(data)});
}

function delete_all()
{
		$.post('ajax/delete-all.ajax.php', {delete_files: $('#delete_files').prop('checked')}, function(data) {eval(data)});
}

function _rows()
{
	rows = $.cookie('rows') == undefined ? $('#rows').val() : $.cookie('rows');
	return(rows);
}

function _columns()
{
	columns = $.cookie('columns') == undefined ? $('#columns').val() : $.cookie('columns');
	return(columns);
}

function publish(offset, rows, columns)
{
    $.post('ajax/publish-my-recipes.ajax.php', {offset: offset, rows: rows, columns: columns}, function(data) {eval(data);});
}


function refresh() 
{
	setCookie('rows', $('#rows').val());
	setCookie('columns', $('#columns').val());
	window.location.href = 'recipes.php?rows=' + $('#rows').val() + '&columns=' + $('#columns').val();
}