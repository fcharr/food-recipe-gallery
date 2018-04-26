function setup_save_buttons()
{
	$('.submit_login').click(function() {login();});
	
	$.each($('.save_cook'),
		 function(key, value) {
			 $('#cook_login' + value.id + 
			   ', #cook_password' + value.id + 
			   ', #cook_email' + value.id +
			   ', #cook_first_name' + value.id + 
			   ', #cook_last_name' + value.id).keyup(function() {$('[class=save_cook][id=' + value.id + ']').show();});
			   
			 $('[class=change_cook_password][id=' + value.id + ']').change(function() {toggle_cook_password(value.id);});
			 $('#cook_admin' + value.id).change(function() {$('[class=save_cook][id=' + value.id + ']').show();});
			 $('[class=save_cook][id=' + value.id + ']').click(function() { save_cook(value.id);});
			 $('[class=delete_cook][id=' + value.id + ']').click(function() { delete_cook(value.id);});
		 });
}

function setup() {
	cook();
	
	setup_save_buttons();
		 
	$('#add_cook').click(function() {add_cook();});
}

function delete_cook(cook_id)
{
	$.post('ajax/delete-cook.ajax.php', {cook_id: cook_id}, function(data) {eval(data)});
}

function add_cook() 
{
	$.post('ajax/add-cook.ajax.php', {}, function(data) {show_added_cook(data)});
}

function show_added_cook(html)
{
	$('.cook_login').unbind('keyup');
	$('.cook_admin').unbind('keyup');
	$('.cook_password').unbind('keyup');
	$('.change_cook_password').unbind('change');
	$('.cook_first_name').unbind('keyup');
	$('.cook_last_name').unbind('keyup');
	$('.cook_admin').unbind('change');
	$('.save_cook').unbind('click');
	
	$('#add_cook').before(html);
	
	setup_save_buttons();
}

function setCookie(name, value)
{
         if(name != '')
		 {
		 	expires = new Date(Date.now());
        	expires.setYear(parseInt(expires.getFullYear()) + 1);
			$.cookie(name, value, {expires: expires});
		 }
}

function login()
{
		expires = new Date(Date.now());
        expires.setYear(parseInt(expires.getFullYear()) + 1);

		 $.post('ajax/login.ajax.php',
		        {login: $('#login').val(), password: $('#password').val(), duration: expires.getSeconds()},
				function(data) {eval(data);});
}

function toggle_cook_password(cook_id) {
	if($('#cook_password' + cook_id).prop('disabled') == true) {
		$('#cook_password' + cook_id).prop('disabled', false);
	} else {
		$('#cook_password' + cook_id).val('');
		$('#cook_password' + cook_id).prop('disabled', true);
	}
}

function save_cook(cook_id) {
		$.post('ajax/save-cook.ajax.php', 
		{cook_id: cook_id, 
		cook_login: $('#cook_login' + cook_id).val(),
		cook_password: $('#cook_password' + cook_id).val(),
		cook_email: $('#cook_email' + cook_id).val(),
		cook_first_name: $('#cook_first_name' + cook_id).val(),
		cook_last_name: $('#cook_last_name' + cook_id).val(),
		cook_admin: $('#cook_admin' + cook_id).prop('checked')},
		function(data) {eval(data);});
}