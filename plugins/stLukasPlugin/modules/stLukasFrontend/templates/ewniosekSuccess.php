<script type="text/javascript">
 
		var mode = 0;
		var url = "<?php echo $url;?>";
	
		mode = /MSIE (\d+\.\d+);/.test(navigator.userAgent) == true ? 1 : 0;
	
		function loaded(mode)
		{
			if(mode == 0)
			{
				top.location.href = url;
			}
			else
			{
				document.getElementById('mf').action = url;
				document.getElementById('mf').submit();
			}
		}
</script>
<form id="mf" action="" method="post"></form>
<script type="text/javascript">
	loaded(mode);
</script>