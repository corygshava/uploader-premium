<?php
	$folder = "ggr/";
	$folder = "uploads/";
	$files = array_diff(scandir($folder), array('.', '..'));
	$filesdata = "[]";

	if(!empty($files)){
		$filesdata = "[";

		foreach($files as $file){
			$filepath = $folder.$file;
			$size = round(filesize($filepath) / 1024,2);
			$created = date("F d y, H:i",filectime($filepath));

			$filebox = "{\"name\": \"$file\",\"size\": \"$size\",\"u_date\" : \"$created\",\"fpath\": \"$filepath\"}";

			$filesdata .= $filebox.",\n";
		}

		$filesdata = substr($filesdata, 0, -2);
		$filesdata .= "]";
	}
?>