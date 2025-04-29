<?php
	$pagename = isset($pagename) ? $pagename : 0;
?>

<nav class="w3-hide-small w3-hide-medium">
	<div class="logo">
		<b>Uploader</b>
	</div>
	<div class="links">
		<a href="index.php">home</a>
		<a href="upload_file.php">upload</a>
		<a href="uploaded.php">files</a>
	</div>
</nav>

<script>
	let thenav = document.querySelector('nav');
	let thepage = '<?=$pagename?>';

	window.addEventListener('load',() => {
		let links = thenav.querySelectorAll('.links>a');

		links.forEach(el => {
			el.classList.remove("current");
		})

		links[Number(thepage)].classList.add("current");
	})
</script>