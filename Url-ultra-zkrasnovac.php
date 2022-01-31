<script>
	if (typeof window.history.pushState == 'function') {
		window.history.pushState({}, "Hide", <?php $url = $_SERVER['REQUEST_URI'];
																					echo " 'http://infiltrated.com$url' "; ?>);
	}
</script>