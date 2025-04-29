<?php
	include 'actions/getfiles.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<link rel="stylesheet" type="text/css" href="css/w3.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">

	<title>Uploaded Files</title>

	<style>
		* {
			box-sizing: border-box;
			transition: 0.3s ease-out;
		}
		h1 {
			text-align: center;
			margin-bottom: 30px;
		}

		.content.newversion{
			justify-content: flex-start;
		}

		.files_holder {
		    display: flex;
		    flex-wrap: wrap;
		    justify-content: center;
		    gap: 20px;
		    width: 100%;
		    padding: 20px 12px;
		}
		.file-card{
			flex: 0 1 350px;
			min-height: 150px;
			display: flex;
			flex-direction: column;
			justify-content: space-between;
			padding: 12px;
			border: 1px solid grey;
			border-radius: var(--roundness);
			background: var(--panelbg);
			--metacolor: #777;
		}
		.file-card:hover{
			background: var(--bgcolor);
			box-shadow: 0 0 12px var(--themecolor);
			border: 2px solid transparent;
			scale: 1.04;
			--metacolor: var(--textcolor);
		}
		.file-card.placeholder {
			flex: 1 0 300px;
			box-shadow: none;
			min-height: 200px;
			display: flex;
			align-items: center;
			justify-content: center;
			text-align: center;
		}
		.file-info {
			text-align: left;
		}
		.file-name {
			font-size: 18px;
			font-weight: bold;
			color: var(--themecolor);
		}
		.file-meta {
			font-size: 0.9rem;
			color: var(--metacolor);
		}
	</style>

	<link rel="stylesheet" href="css/styles.css">
	<link rel="stylesheet" href="css/w3.css">
</head>
<body data-mode="light">
	<?php
		include 'elements/navbar.php';
		include 'elements/nav.php';
	?>
	<?php
		if(isset($_COOKIE['accesstoken'])){
	?>
	<header>
		<h1>Uploaded Files</h1>
	</header>

	<div class="content w3-text-white newversion">
		<div class="files_holder">
		</div>

		<div class="container">
			<ul class="w3-hide">
				<?php if (!empty($files)): ?>
					<?php foreach ($files as $file): 
						$filePath = $folder . $file;
						if (is_file($filePath)):
							$size = round(filesize($filePath) / 1024, 2) . ' KB';
							$created = date("F d Y, H:i", filectime($filePath));
					?>
						<li>
							<div class="file-info">
								<div class="file-name"><?php echo htmlspecialchars($file); ?></div>
								<div class="file-meta"><?php echo $size . ' | Created: ' . $created; ?></div>
							</div>
						</li>
					<?php endif; endforeach; ?>
				<?php else: ?>
					<li>No files found.</li>
				<?php endif; ?>
			</ul>
		</div>
	</div>

	<script>
		let files = JSON.parse(`<?=$filesdata?>`);

		let filesguy = document.querySelector(".files_holder");

		function init() {
			files.forEach(el => {
				el.ftype = findfiletype(el.name);
			});

			filterfiles("*");
		}

		function filterfiles(con) {
			let touse = [];

			if(con == "*"){
				touse = files;
			}

			renderfiles(touse);
		}

		function renderfiles(list) {
			list.forEach((el,id) => {
				let item = document.createElement('div');

				item.dataset.ftype = el.ftype;
				item.className = "file-card";

				thesize = getsize(Number(el.size));

				item.innerHTML = `
					<div class="file-name">${el.name}</div>
					<div class="file-meta">${thesize} | ${el.u_date} | ${el.ftype}</div>
					<div class="file-actions">
						<a class="iconbtn w3-grey" onclick="copymylink(${id})"><i class="fa fa-share"></i></a>
						<a class="iconbtn w3-grey" href="${el.fpath}" download><i class="fa fa-download"></i></a>
					</div>
				`

				filesguy.appendChild(item);
			})
		}

		function getsize(s) {
			console.log(s);

			let val = s;
			let mul = 100;
			let suffix = "B";
			let res = "";

			if(s < 1000 && s > 1){
				mul = 1;
				suffix = "KB";
			} else if(s < 1000000){
				mul = 1 / 1000;
				suffix = "MB";
			} else if(s < 1000000000){
				mul = 1 / 1000000;
				suffix = "GB";
			} else {
				mul = 1 / 1000;
				suffix = "WTF!";
			}

			if(suffix == "WTF!"){
				res = suffix;
			} else {
				let m_size = val * mul;
				let num = m_size.toString().split(".")[0];
				let frac = m_size.toString().split(".")[1].substr(0,2);
				let finval = `${num}.${frac}`;

				res = `${finval} ${suffix}`;
			}

			return res;
		}

		function copymylink(n) {
			let tocopy = files[n];
			let thepath = tocopy.fpath;

			let winloc = window.location.href;
			let tmarray = winloc.split("/");

			tmarray.pop();
			tmarray.push(thepath);
			thepath = tmarray.join("/");

			// alert(thepath);

			copytext1(thepath);

			showAlert("text copied successfully!",5,"success");
		}

		window.onload = () => {
			init();
		}
	</script>
	<?php
		} else {
	?>

	<div class="content">
		<div class="formholder w3-animate-zoom">
			<form id="verifyForm">
				<h2 class="my_header">Access Token Required</h2>
				<!-- <label for="thekey">enter your given key below</label> -->
				<input type="text" name="thekey" id="thekey" placeholder="enter your key here">
				<button type="submit">Verify</button>
			</form>
			<div id="response" style="display: none;" data-shown="0">
				<p>Invalid key</p>
				<a class="themebtn" href="">retry</a>
			</div>
		</div>
	</div>

	<script>
		let theform = document.querySelector("#verifyForm");


		theform.addEventListener('submit',async (e) => {
			e.preventDefault();

			let keytext = theform.thekey.value;
			let payload = `mykey=${keytext}`;

			let result = await fetch(`verifytoken.php?${payload}`);

			if(!result.ok){
				showAlert("it failed",7,"danger");
				return;
			}

			let response = await result.text();
			let a_type = response.split("|")[1];
			let a_text = response.split("|")[0];

			showAlert(a_text,2,a_type);

			if(a_type == "success"){
				theform.animate([{opacity:1},{opacity: 0}],{duration:400,fill:"forwards"})

				setTimeout(() => {
					window.location.reload();
				},1200);
			}
		})
	</script>

	<?php
		}
	?>
	<?php
		include 'elements/codes.php';
	?>
</body>
</html>
