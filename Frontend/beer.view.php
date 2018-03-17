
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="css/stylesheet.css" type="text/css">
</head>
<body>

	<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
		<div class="container nav-content">
			<a class="navbar-brand" href="index.view.php">LOGO</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

		  	<div class="collapse navbar-collapse" id="navbarTogglerDemo02">
		    	<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
		      		<li class="nav-item active">
		        		<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
		      		</li>
		      		<li class="nav-item">
		        		<a class="nav-link" href="#">Link</a>
		      		</li>
				    <li class="nav-item">
				    	<a class="nav-link disabled" href="#">Disabled</a>
				    </li>
		    	</ul>

				<form class="form-inline" method="post" action="index.php">
					<input class="form-control mr-sm-2" type="text" name='beerName' placeholder="Search for beer or brewery">
					<input class="btn btn-success" type="submit" value="Search">
				</form>
		  </div>
		</div>
	</nav>

	

	<form method="post" action="index.php">
		<input type="text" name='beerName' placeholder="Search for Beer">
		<br>
	</form>


	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

</body>
</html>
</body>
</html>

	<!--<?php foreach ($response as $information) : ?>
		<h2><?php echo $information['name']; ?></h2>
		<h2>Description</h2>
		<p><?php echo $information['description']; ?></p>	
		
		<h2>Type</h2>

		<p><?php echo $information['type']; ?></p>

		<h2>Available</h2>
		<p><?php echo $information['available']; ?></p>

	<?php endforeach; ?> -->


</body>
</html>