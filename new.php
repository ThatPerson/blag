<?php
	include_once("users.php");
	$auth = 0;
	if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
		for ($i = 0; $i < count($user); $i++) {
			if (($_COOKIE['username'] == $user[$i]) && (($_COOKIE['password']) == $pass[$i])){
				$auth = 1;
			}
		}
		if ($auth != 1) {
			setcookie ("username", "", time() - 3600);
			setcookie ("password", "", time() - 3600);
		}
	}
	if ($auth == 0) {
		header("Location: login.php");
		exit();
	}
	if (isset($_POST['title']) && isset($_POST['content'])) {
		$date = date("d/m/y");
		$title = $_POST['title'];
		$content = $_POST['content'];
		$url = strtolower($title)."-".strval(rand(1000, 9000));
		while (file_exists("posts/".$url)) {
			$url = strtolower($title).strlen(rand(1000, 9000));
		}
		file_put_contents("posts/".$url.".txt", $title."\n".$content);
		file_put_contents("posts/postlist", $date."::".$_COOKIE['username']." - ".$title.":<:".$url.":>:".substr(str_replace("\n", "<br>", $content),0,100)."\n", FILE_APPEND);
		header("Location: index.php");
//		24/05/13::Project:<:project:>:Hello world\!<br>Whats up\?

	}
?>
<!doctype html>
<html>
<body>
	<form action="new.php" method="post">
		<input type="text" placeholder="Title" name="title"><br>
		<textarea name="content" placeholder="Content"></textarea><br>
		<input type="submit" value="Post">
	</form>
</body>
