<?php include './connDB.php'  ?>
<!DOCTYPE html>
<html>
<head>
	<title>FORM</title>
	<link rel="stylesheet" href="./index.css">
</head>
<body>
	<div class="form-container" >
		<form action="./form.php" method="post">
			<label for="username">Username:</label>
			<input type="text" id="username" name="username"  required>
			
			<label for="email">Email:</label>
			<input type="email" id="email" name="email" required>
			
			<label for="password">Password:</label>
			<input type="password" id="password" name="password" required>
			
			<input type="submit" name="submit" value="Submit">
		</form>
	</div>
</body>
</html>
