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
		    margin-bottom: 73px;
		}
		.file-card{
			flex: 0 1 400px;
			min-height: 180px;
			display: flex;
			flex-direction: column;
			justify-content: space-between;
			padding: 12px;
			border: 1px solid grey;
			border-radius: var(--roundness);
			background: var(--panelbg);
			--metacolor: #777;
		}
		.file-card:not(.placeholder):hover{
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
		.container{
			height: 100px;
		}

		.loader {
			width: calc(80px / cos(45deg));
			height: 14px;
			margin-bottom: 20px;
			background: repeating-linear-gradient(-45deg,#fff 0 15px,#0000 0 20px) left/200% 100%;
			animation: l3 2s infinite linear;
		}
		@keyframes l3 {
		    100% {background-position:right}
		}
	</style>

	<link rel="stylesheet" href="css/styles.css">
	<link rel="stylesheet" href="css/w3.css">
</head>
<body data-mode="light">
	<?php
		$pagename = 2;

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
		<div class="filters">
			<div class="thesect searchbox">
				<i class="fa fa-search"></i>
				<input type="text" placeholder="search uploaded files" id="searchnpt">
			</div>

			<div class="thesect filterbox w3-hide">
				<a>all</a>
				<a>documents</a>
				<a>videos</a>
			</div>
		</div>
		<div class="files_holder">
			<div class="file-card placeholder">
				<div class="loader"></div>
				<div>loading files</div>
			</div>
		</div>
	</div>

	<?php
		include 'actions/getfiles.php';
	?>

	<script>
		let files = JSON.parse(`<?=$filesdata?>`);

		let filesguy = document.querySelector(".files_holder");
		let searchnpt = document.querySelector("#searchnpt");

		let filtererror = "";

		function init() {
			files.forEach(el => {
				el.ftype = findfiletype(el.name);
			});

			let flist = filterfiles("*");

			renderfiles(flist);
		}

		function filterfiles(con) {
			let touse = [];

			// reset the filtererror flag
			filtererror = "";

			// code for allowing modifiers into the search
			let mod = "";
			let moddata = "";
			let validmod = false;
			let mods = [
				"title",
				"before",
				"after",
				"above",
				"w"
			];
			let modshelp = [
				"enter title to search",
				"list files uploaded before ...",
				"list files uploaded after ...",
				"list files above (enter size in KB)",
				"list files with ..."
			];

			if(con.includes(":")){
				mod = (((con.split(":")[0]).split(" ")).reverse()[0]).toLowerCase();

				// check if a modifier was picked up
				if(mod != ""){
					// check if its a valid modifier
					if(mods.indexOf(mod) >= 0){
						if(con.split(":").length <= 2){
							validmod = true;

							moddata = (con.split(`${mod}:`)[1]).trim();

							if(moddata != ""){
								// con = mod != "title" ? (con.split(`${mod}:`)[0]) : moddata;
								con = (con.split(`${mod}:`)[0]);

								// console.log(`modifier detected : [${mod}:] -> [${moddata}]`);
							} else {
								filtererror = modshelp[mods.indexOf(mod)];
							}
						} else {
							filtererror = "you cant have more than 2 modifiers";
						}
					} else {
						filtererror = "enter a valid modifier";
					}
				} else {
					filtererror = "the colon should only be used for search modifiers";
				}
			}

			// first do the default search
			touse = files;

			if(con == "*"){
				touse = files;
			} else if(con.includes("before:")){
				// code for files whose creation date is before the 
			} else if(con != "" || con != undefined){
				let tmparr_1 = files;
				let tmparr_2 = [];

				/*
					element template
					{"name":"7261_birds lyrics ref1.mp4","size":"17604.27","u_date":"April 29 25, 14:32","fpath":"uploads/7261_birds lyrics ref1.mp4","ftype":"video"}
				*/

				// using touse instead of files to prevent array mutation
				tmparr_1.forEach((el,id) => {
					if(el.name.toLowerCase().includes(con.toLowerCase())){
						tmparr_2.push(el);
					}
				})

				touse = tmparr_2;
			}

			// then apply the search modifiers to the result
			if(validmod){
				let tmparr_3 = touse;

				switch(mods.indexOf(mod)){
				case 0:
					// title mod
					tmparr_3 = filterfiles(moddata);

					if(tmparr_3.length == 0){
						filtererror = "no file has that title";
					}
					break;
				defaut:
					break;
				}

				touse = tmparr_3;
			}

			return touse;
		}

		function renderfiles(list,ifempty) {
			ifempty = ifempty == undefined ? "no uploads yet" : ifempty;

			filesguy.innerHTML = "";

			if(list.length == 0){
				filesguy.innerHTML = `
					<div class="file-card placeholder">
						<div><i>${ifempty}</i></div>
					</div>
				`;
			}

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
			});
		}

		function getsize(s) {
			// console.log(s);

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

		// event listeners
		window.onload = () => {
			setTimeout(() => {
				init();
			},1200);
		}

		searchnpt.addEventListener('input',e => {
			let val = searchnpt.value;
			let _mafiles = [];
			let errtext = "search not found";

			val = val == "" ? "*" : val;
			_mafiles = filterfiles(val);
			errtext = filtererror == "" ? errtext : filtererror;

			renderfiles(_mafiles,errtext);
		})
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
