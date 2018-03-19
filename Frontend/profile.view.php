<!DOCTYPE html>
<html>
<head>
	<title>Hop</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="css/profile.css" type="text/css">
</head>
<body>
	<nav class="navbar navbar-dark bg-success justify-content-between">
		<div class="container">
			<h2 class="title">HOPS</h2>
			<form class="form-inline" method="post" action="profile.php">
				<input class="form-control mr-sm-2" type="search" placeholder="Find Beers or Breweries" aria-label="Search" name='search'>
				<button class="btn btn-default my-2 my-sm-2" type="submit">Search</button>
		  	</form>
		  </div>
	</nav>

	<div class="container">
		<div class="main-content">
			<div class="profile">
				<h1><span id="username"><?php echo $username; ?></span></h1>
				<span id="name"><?php echo $firstname . ' ' .$lastname; ?></span>
				<form method="post" action="profile.php">
					<input type="submit" class=" logout btn btn-outline-danger btn-sm" name='logout' value="Log out">
				</form>
				
				
			</div>
		</div>

	</div>
	
</body>
</html>