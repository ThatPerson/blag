<?php
	include_once("users.php");
	$auth = 0;
	$message = "";
	if (isset($_POST['username']) && isset($_POST['password'])) {
		for ($i = 0; $i < count($user); $i++) {
			if (($_POST['username'] == $user[$i]) && (md5($_POST['password']) == $pass[$i])){
				setcookie ("username", $_POST['username'], time() + 3600);
				setcookie ("password", md5($_POST['password']), time() + 3600);
				header("Location: index.php");
				$auth = 1;
			}
		}
		if ($auth != 1) {
			$message = "Wrong Login Details";
		}
	}
?>
<!doctype html>
<html>
<body>
	<p style="color:#ff0000;"><?php echo $message; ?></p>
	<form action="login.php" method="post">
		Username: <input type="text" name="username" placeholder="Username"><br>
		Password: <input type="password" name="password" placeholder="Password"><br>
		<input type="submit" value="Login">
	</form>
</body>
</html>