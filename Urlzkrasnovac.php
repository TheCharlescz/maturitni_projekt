<script>
		if (typeof window.history.pushState == 'function') {
			window.history.pushState({}, "Hide", '<?php echo $_SERVER['PHP_SELF']; ?>');
		}
</script>