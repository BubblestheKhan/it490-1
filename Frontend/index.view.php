<!DOCTYPE html>
<html>
<head>
	<title>Hop</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="css/stylesheet.css" type="text/css">
</head>
<body>

	<div class="background-image h-100">
		<div class="login-box row h-100 justify-content-center align-items-center">
			<form method="post" class="col-12 login-form" action='login.php'>
				<h1 id="login-title">HOPS</h1>
				<p id="login-subtitle">Social Drinkers only</p>
				<div class="error-div">
					<span class="error"><?php echo $error; ?></span>
				</div>
				<div class="form-group row">
					<label class='col-md-12 col-form-label col-form-label-lg'>Username</label>
					<div class="col-md-12">
						<input type="text" name="username" placeholder="Enter your username" class="form-control input-lg">
					</div>
				</div>
				<div class="form-group row">
					<label class='col-md-12 col-form-label col-form-label-lg'>Password</label>
					<div class="col-md-12">
						<input type="text" name="password" placeholder="Enter your password" class="form-control input-lg">
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-12">
						<input type="submit" class="btn btn-success btn-lg btn-block" value="SIGN IN" name="login">
					</div>
					<div class="col-md-12">
						<input type="submit" class="btn btn-success btn-lg btn-block" value="CREATE AN ACCOUNT" name="register">
					</div>
				</div>
			</form>
		</div>
	</div>


	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

</body>
</html>
