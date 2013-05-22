<?php
	$auth = 0;
	include_once("users.php");
	if (isset($_GET['signout'])) {
		setcookie ("username", "", time() - 3600);
		setcookie ("password", "", time() - 3600);
		header("Location: index.php");
	}
	if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
		for ($i = 0; $i < count($user); $i++) {
			if (($_COOKIE['username'] == $user[$i]) && (($_COOKIE['password']) == $pass[$i])){
				echo "<a href='new.php'>New</a>&nbsp;";
				echo "<a href='index.php?signout'>Logout</a>";
				$auth = 1;
			}
		}
		if ($auth != 1) {
			setcookie ("username", "", time() - 3600);
			setcookie ("password", "", time() - 3600);
		}
	}
	
	if ($auth != 1) {
		echo "<a href='login.php'>Login</a>";
	}
	$l = file_get_contents("posts/postlist");
	$o = explode("\n", $l);
	$regex = array(".+::", "::.+:<:", ":<:.+:>:", ":>.+");
	class post {
		public $url = "";
		public $title = "";
		public $date = "";
		public $content = "";
		public function __construct($url, $title, $content, $date) {
			$this->url = $url;
			$this->title = $title;
			$this->date = $date;
			$this->content = $content;
		}
	}
	$lio = array();
	for ($i = 0; $i < count($o); $i++) {
		$pio = array(array());
		$title = "";
		$date = "";
		$url = "";
		$content = "";
		for ($p = 0; $p < count($regex); $p++) {
			preg_match_all("/".$regex[$p]."/", $o[$i], $pio[$p]);
		}
		$date = substr($pio[0][0][0], 0, strlen($pio[0][0][0])-2);
		$title = substr($pio[1][0][0], 2, strlen($pio[1][0][0])-5);
		$url = "posts.php?post=".substr($pio[2][0][0], 3, strlen($pio[2][0][0])-6);
		$content = str_replace("\\", "", substr($pio[3][0][0], 3));
		$lio[] = new post($url, $title, $content, $date);
	}
	for ($i = count($lio)-1; $i >= 0; $i--) {
		echo "<p>".$lio[$i]->date." <a href='".$lio[$i]->url."'>".$lio[$i]->title."</a></p><p>".$lio[$i]->content."</p><hr>";
	}
?>