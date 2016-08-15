$(document).ready(function() {
	feedback();
});

function feedback()
{
	$("#newcarform").submit(
		function (event) {
			event.preventDefault();
			// collect form data
			$fname = $("#available").val();
			$mname = $("#travel").val();
			$onames = $("#carowner").val();
			$date = $("#dl").val();
			$idno = $("#id").val();
			$tel = $("#cat").val();
			$email = $("#email").val();
			$passport = $("#passportno").val();
			
			$errors = false;
			
			if($fname == '0') {
				displayError('Please Provide your firstname','#model');
				$errors = true;
			}
			if($mname == '0') {
				displayError('Please Provide your middlename','#model');
				$errors = true;
			}
			if($oname == '0') {
				displayError('Please Provide your othername','#model');
				$errors = true;
			}
			if($idno == '0') {
				displayError('Please Provide your ID number','#model');
				$errors = true;
			}
			if($date == '0') {
				displayError('Please select the date','#model');
				$errors = true;
			}
			if($tel == '0') {
				displayError('Please Provide your telephone Number','#model');
				$errors = true;
			}
			if($carcost <= '0') {
				displayError('Please select cost 2 hire car per day','#carcost');
				$errors = true;
			}
			
			if($num_of_cars <= '0') {
				displayError('Please select number of cars 2 add','#numcars');
				$errors = true;
			}
			
			if($newmakename == '') {
				displayError('Please enter a car make','#make');
				$errors = true;
			}
			
			if($newmodelname == '') {
				displayError('Please enter a car model','#model');
				$errors = true;
			}
			
			if(!$errors){
				//call ajax to send
				$.post('../ajax/newcar.php', {model_id: $model_id, make_id: $make_id, num_of_cars: $num_of_cars, carcost: $carcost, newmakename: $newmakename, newmodelname: $newmodelname}, function(data) {
					if(data == 3) {
						// correct
						displaySuccess('Update successful <a href="newcar.php">Continue</a>','.submit');
					}
					else
						displayError(data,'.submit');
				});
			}
		}
	);
	
	$("#adminform").submit(
		function (event) {
			event.preventDefault();
			// collect form data
			$username = $("#username").val();
			$password = $("#password").val();
			
			if($username == '') {
				displayError('Please enter your Username','#user');
			}
			if($password == '') {
				displayError('Please enter your Password','#word');
			}
			//call ajax to send
			$.post('ajax/login.php', {username: $username, password: $password}, function(data) {
				if(data == 3) {
					// correct
					displaySuccess('Login successful <a href="admin/">Continue</a>','.submit');
				}
				
				if(data == 4) {
					// wrong username or password
					alert('Incorrect Info');
				}
			});
		}
	);
	
	$("#hireform").submit(
		function (event) {
			event.preventDefault();
			// collect form data
			
			$firstname = $("#firstname").val();
			$lastname = $("#lastname").val();
			$nationalid = $("#nationalid").val();
			$carid = $("#carid").val();
			$num_of_cars = $("#num_of_cars").val();
			$num_of_days = $("#num_of_days").val();
			$cost_of_cars = $("#cost_of_cars").val();
			
			$errors = false;
			
			if($firstname == '') {
				displayError('Please enter your First name','#fname');
				$errors = true;
			}
			if($lastname == '') {
				displayError('Please enter your Last name','#lname');
				$errors = true;
			}
			
			if($nationalid == '' || !isInt($nationalid)) {
				displayError('Please enter your National id number','#natid');
				$errors = true;
			}
			
			if($carid == '0') {
				displayError('Please chose a car','#car');
				$errors = true;
			}
			
			if($num_of_cars == '0' || $num_of_cars == '' || !isInt($num_of_cars)) {
				displayError('Please enter the number of cars you want','#numcars');
				$errors = true;
			}
			
			if($num_of_days == '0' || $num_of_days == '' || !isInt($num_of_days)) {
				displayError('Please enter the number of days','#numdays');
				$errors = true;
			}
			
			if($cost_of_cars == '0' || $cost_of_cars == '' || !isInt($cost_of_cars)) {
				displayError('Please calculate the cost per day','#costcars');
				$errors = true;
			}
			
			if(!$errors) {
				//call ajax to send
				$.post('../ajax/hire.php', {firstname: $firstname, lastname: $lastname, nationalid: $nationalid, carid: $carid, num_of_cars: $num_of_cars, cost_of_cars: $cost_of_cars}, function(data) {
					if(data == 1) {
						// correct
						displaySuccess('Hire Successful <a href="hire.php">Continue</a>','.submit');
					} else {
						// wrong username or password
						displayError('Server error: ' + data,'.submit');
					}
				});
			}
		}
	);
}

function displayError(msg,to){
	var elem = $('<div>',{
		'class'	: 'errorMessage',
		html	: msg,
		style	: 'z-index: 3000'
	});
	
	elem.click(function(){
		$(this).fadeOut(function(){
			$(this).remove();
		});
	});
	
	setTimeout(function(){
		elem.click();
	},5000);
	
	elem.hide().appendTo(to).slideDown();
}

function displaySuccess(msg,to){
	var elem = $('<div>',{
		'class'	: 'successMessage',
		html	: msg,
		style	: ''
	});
	
	$(to).html(elem);
	//elem.hide().appendTo(to).slideDown();
}

function isInt (val)
{
	inputVal = val.toString();
	
	for (var i = 0 ; i < inputVal.length ; i++)
	{
		var oneChar = inputVal.charAt(i)
		
		if(i == 0 && oneChar == "-")
		{
			continue;
		}
		
		if(oneChar < "0" || oneChar > "9")
		{
			return false;
		}
	}
	
	return true;
}