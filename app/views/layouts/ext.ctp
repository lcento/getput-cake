<html>
	<head>
		<?php echo $this->Html->charset(); ?>

		<title>
			<?php __('Il Mattino Portale ExtJs:'); ?>
			<?php echo $title_for_layout; ?>
		</title>

		<?php
			echo $this->Html->css('../js/extjs/resources/css/ext-all');
			echo $javascript->link('extjs/adapter/ext/ext-base-debug.js');
			echo $javascript->link('extjs/ext-all-debug.js');
		?>
		<!-- MAT Sub-framework JavaScript -->
		<?php	
			echo $javascript->link('MAT/window/UserLoginWindow.js');
		?>
	</head>
<body>
	<script type="text/javascript">
		Ext.onReady(function(){
			Ext.BLANK_IMAGE_URL = 'extjs/resources/images/default/s.gif';
			Ext.QuickTips.init();
		});
	</script>

	<?php echo $content_for_layout; ?>
</body>
</html>