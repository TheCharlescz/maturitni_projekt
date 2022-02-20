<script>
	if (typeof window.history.pushState == 'function') {
		window.history.pushState({}, "Hide", '<?php  echo $_SERVER['REQUEST_URI']; ?>');
	}
</script>