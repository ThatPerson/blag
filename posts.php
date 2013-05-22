<?php
	if (isset($_GET['post'])) {
		$fileurl = "posts/".$_GET['post'].".txt";
		if (file_exists($fileurl)) {
			$po = file_get_contents($fileurl);
			$poi = explode("\n", $po);
			$title = $poi[0];
			$poi[0] = "";
			$po = implode("<br>", $poi);
			echo "<h1>".$title."</h1><p>".str_replace("\n", "<br>", $po)."</p>";
		}
	}
?>