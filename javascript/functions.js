//sliding dropdown to select options
$(document).ready(function(){
    $("#avatar").click(function(){
       	$("#login_dropdown").slideToggle();	
    });
});

//validating register form
function registration_validation(){
			var user = document.forms['register_form']['username'].value;
			var email = document.forms['register_form']['email'].value;
			var phone = document.forms['register_form']['phone'].value;
			var pwd = document.forms['register_form']['pwd'].value;

			var phone_pattern = /[1-9][0-9]{9}/g;
			var result = phone.match(phone_pattern);
			if(result != phone){
				alert('Enter valid phone number');
				return false;
			}
			var email_pattern = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			if(!email_pattern.test(email)){
				alert('Enter valid mail id');
				return false;
			}
			var user_pattern = /^[a-zA-Z]\w*\d*\w*/;
			var user_result = user.match(user_pattern);

			if(user_result != user){
				window.alert('Enter valid username');
				return false;
			}
			return true;
		}

//validating forgot user form
function forgot_user_validation(){
	var email = document.forms['forgot_form']['email'].value;
	var phone = document.forms['forgot_form']['phone'].value;
	var phone_pattern = /[1-9][0-9]{9}/g;
	var result = phone.match(phone_pattern);
	if(result != phone){
		alert('Enter valid phone number');
		return false;
	}
	var email_pattern = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if(!email_pattern.test(email)){
		alert('Enter valid email');
		return false;
	}
	return true;
}

//validating update password form
function update_pwd_validation(){
		var email = document.forms['update_form']['email'].value;
		var email_pattern = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			if(!email_pattern.test(email)){
				alert('Enter valid email');
				return false;
			}
			return true;
		}

function display_options(number){
	if(number == 1){
		document.getElementById('login_dropdown').style.display= 'block';
	}else{
		document.getElementById('login_dropdown').style.display= 'none';
	}			
}

//displays message box on clicking new message
function display_message_box(){
	$("#new_msg").click(function(){
		$("#popout").fadeIn("slow");
	});
}

//ajax function to retrieve messages of a user
function show_messages(user){
	var username = user;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			document.getElementById('messages').innerHTML = this.responseText;
		}
	};
	xhttp.open("POST", "getmessages.php?q="+username, true);
	xhttp.send();
}

//validating issue form
function issue_email_validation(){
	var id = document.forms['issue_form']['username'].value;
	var email_pattern = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var user_pattern = /^[a-zA-Z]\w*\d*\w*/;

	var user_result = id.match(user_pattern);

	if(id != "" && (!email_pattern.test(id) && user_result != id)){
		alert('Enter valid email or username');
		return false;
	}
	return true;
}

//validating add user form
function add_user_validation(){
			var user = document.forms['add_user']['username'].value;
			var email = document.forms['add_user']['email'].value;
			var phone = document.forms['add_user']['phone'].value;
			var pwd = document.forms['add_user']['pwd'].value;

			var phone_pattern = /[1-9][0-9]{9}/g;
			var result = phone.match(phone_pattern);
			if(result != phone){
				alert('Enter valid phone number');
				return false;
			}
			var email_pattern = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			if(!email_pattern.test(email)){
				alert('Enter valid mail id');
				return false;
			}
			var user_pattern = /^[a-zA-Z]\w*\d*\w*/;
			var user_result = user.match(user_pattern);

			if(user_result != user){
				window.alert('Enter valid username');
				return false;
			}
			return true;
}

//ajax function to retrieve the issues
function show_issues(){
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function(){
				if(this.readyState == 4 && this.status == 200){
					document.getElementById('issues').innerHTML = this.responseText;
				}
			};
			xhttp.open("POST", "getissues.php", true);
			xhttp.send();
}

//validating remove user form
function remove_user_validation(){
			var username = document.forms['remove_user']['username'].value;
			var email = document.forms['remove_user']['email'].value;

			var email_pattern = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			if(!email_pattern.test(email)){
				window.alert('Enter valid mail id');
				return false;
			}

			var user_pattern = /^[a-zA-Z]\w*\d*\w*/;
			var user_result = username.match(user_pattern);
			if(user_result != username){
				window.alert('Enter valid username');
				return false;
			}

			var confirmation = confirm("Are you sure to remove?");

			return confirmation;
}

//ajax function to retrieve the search history of each user
function get_history(username){
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			document.getElementById('main_content').innerHTML = this.responseText;
		}
	};
	xhttp.open("POST", "get_history.php?q="+username, true);
	xhttp.send();
}