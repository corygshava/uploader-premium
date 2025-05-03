<div class="options w3-hide-large">
	<div class="menu">
		<a href="upload_file.php"><i class="fa fa-upload"></i> uploader</a>
		<a href="uploaded.php"><i class="fa fa-list"></i> uploaded files</a>
	</div>
</div>

<script type="text/javascript">
	var menu = document.querySelector('.menu');
	var _mypage = document.title;

	var isuploader = (_mypage.indexOf('upload') > 0) ? 0 : 1;
	menu.querySelectorAll('a')[isuploader].className = "current";
</script>