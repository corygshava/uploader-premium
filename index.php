<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Uploader Premium by CoryG</title>

	<link rel="stylesheet" href="css/styles.css">
	<link rel="stylesheet" href="css/w3.css">

	<style>
		*{
			box-sizing: border-box;
		}

		body{
			/* background-image: linear-gradient(80deg,var(--modeColor),var(--primaryColor) 90%); */
			/* background-image: url('images/mainbg.jpg'); */
		}

		.content{
			min-height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
		}

		.themebtn.active{
			background-color: var(--themecolor);
		}
		.themebtn{
			display: inline-block;
			padding: 12px 16px;
			border:none;
			border-radius: 12px;
			background-color: #eee;
			color: #111;
			text-decoration: none;
		}
	</style>
</head>
<body>
	<?php
		include 'elements/navbar.php';
	?>
	<div class="content">
		<div class="callout w3-center">
			<div class="section">
				<h1>Your files anywhere, anytime</h1>
			</div>
			<div class="section">
				<p>Secure lockbox storage for all your files both big and small.</p>
			</div>
			<div class="w3-center section">
				<a class="themebtn active" href="upload_file.php">go</a>
				<a class="themebtn" href="uploaded.php">view uploads</a>
			</div>
		</div>
	</div>
</body>