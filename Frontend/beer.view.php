
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<?php foreach ($response as $information) : ?>
		<h2><?php echo $information['name']; ?></h2>
		<h2>Description</h2>
		<p><?php echo $information['description']; ?></p>	
		
		<h2>Type</h2>

		<p><?php echo $information['type']; ?></p>

		<h2>Available</h2>
		<p><?php echo $information['available']; ?></p>

	<?php endforeach; ?>


</body>
</html>