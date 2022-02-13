<script>
	if (typeof window.history.pushState == 'function') {
		window.history.pushState({}, "Hide", <?php $url = $_SERVER['SCRIPT_NAME'];
																					echo " 'http://infiltrated.com$url' "; ?>);
	}
		function preventSubmit(e) {
			e.preventDefault()
			return false
		}
</script>