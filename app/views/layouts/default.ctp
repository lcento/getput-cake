<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php __('Il Mattino Portale:'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('../js/extjs/resources/css/ext-all');
		echo $this->Html->css('../js/extjs/resources/icons');
		echo $this->Html->css('../js/jqueryui/css/smoothness/jquery-ui-1.8.23.custom.css');

		echo $this->Html->css('ilmattino');
	?>
	<!--[if lte IE 8]><?php echo $this->Html->css('ilmattino_ie_lte_8'); ?><![endif]-->
	<!--[if gte IE 9]><?php echo $this->Html->css('ilmattino_ie'); ?><![endif]-->
	<?php 
		/*echo $javascript->link(array('prototype','autofocus','autorefresh','submenu','scriptaculous'));*/
		echo $javascript->link(array('autofocus','autorefresh','submenu'));

		/* jquery base */
		/* echo $this->Html->script('jquery/jquery-1.7.2.js',array('charset' => 'utf-8')); */
		echo $this->Html->script('jquery/jquery-1.8.2.min.js',array('charset' => 'utf-8'));
		/* jquery base googleapis */
		/* echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js',array('charset' => 'utf-8'));*/

		/* jquery ui */
		echo $this->Html->script('jqueryui/js/jquery-1.8.0.min.js',array('charset' => 'utf-8'));
		echo $this->Html->script('jqueryui/js/jquery-ui-1.8.23.custom.min.js',array('charset' => 'utf-8'));
		/* jquery ui googleapis */
		/* echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js',array('charset' => 'utf-8'));*/

		/* jquery ui patch */
		echo $this->Html->script('jqueryui/patch/jquery.ui.dialog.patch.js',array('charset' => 'utf-8'));

		/* extjs */
		echo $this->Html->script('extjs/adapter/ext/ext-base.js',array('charset' => 'utf-8'));
		echo $this->Html->script('extjs/ext-all.js',array('charset' => 'utf-8'));
		/* extjs cachefly */
		/* echo $this->Html->script('http://extjs.cachefly.net/ext-3.4.0/adapter/ext/ext-base.js',array('charset' => 'utf-8'));*/
		/* echo $this->Html->script('http://extjs.cachefly.net/ext-3.4.0/ext-all.js',array('charset' => 'utf-8'));*/
	?>

	<script type="text/javascript" charset="utf-8">
		Ext.onReady(function() {
			Ext.BLANK_IMAGE_URL = '../js/extjs/resources/images/default/s.gif';
			Ext.chart.Chart.CHART_URL = '../js/extjs/resources/charts.swf';
			Ext.QuickTips.init();
		});
	</script>

	<!-- MAT Sub-framework JavaScript -->
	<?php	
		/* window namespace */
		echo $this->Html->script('MAT/window/UserLoginWindow.js',array('charset' => 'utf-8'));

		/* form namespace */
		echo $this->Html->script('MAT/form/FormPanelBaseCls.js',array('charset' => 'utf-8'));
		echo $this->Html->script('MAT/form/EmployeeForm.js',array('charset' => 'utf-8'));
		echo $this->Html->script('MAT/form/CollabForm.js',array('charset' => 'utf-8'));
		echo $this->Html->script('MAT/form/AgeUserForm.js',array('charset' => 'utf-8'));
		echo $this->Html->script('MAT/form/EmployeeFilterForm.js',array('charset' => 'utf-8'));
		echo $this->Html->script('MAT/form/AgeUserFilterForm.js',array('charset' => 'utf-8'));
		echo $this->Html->script('MAT/form/HstFileGetFilterForm.js',array('charset' => 'utf-8'));
		echo $this->Html->script('MAT/form/HstFilePutFilterForm.js',array('charset' => 'utf-8'));
		echo $this->Html->script('MAT/form/HstFileConFilterForm.js',array('charset' => 'utf-8'));
		echo $this->Html->script('MAT/form/HistoryClearableComboBox.js',array('charset' => 'utf-8'));
		echo $this->Html->script('MAT/form/ClbFilePutFilterForm.js',array('charset' => 'utf-8'));

		/* listpanel namespace */
		echo $this->Html->script('MAT/listpanel/ListPanelBaseCls.js',array('charset' => 'utf-8'));
		echo $this->Html->script('MAT/listpanel/EmployeeList.js',array('charset' => 'utf-8'));

		/* grid namespace */
		echo $this->Html->script('MAT/grid/EmployeeGridPanel.js',array('charset' => 'utf-8'));
		echo $this->Html->script('MAT/grid/AgeUserGridPanel.js',array('charset' => 'utf-8'));
		echo $this->Html->script('MAT/grid/HstFileGetGridPanel.js',array('charset' => 'utf-8'));
		echo $this->Html->script('MAT/grid/HstFilePutGridPanel.js',array('charset' => 'utf-8'));
		echo $this->Html->script('MAT/grid/HstFileConGridPanel.js',array('charset' => 'utf-8'));
		echo $this->Html->script('MAT/grid/ClbFilePutGridPanel.js',array('charset' => 'utf-8'));
		echo $this->Html->script('MAT/grid/DwnFileGridPanel.js',array('charset' => 'utf-8'));

		/* chartpanel namespace */
		echo $this->Html->script('MAT/chartpanel/ChartPanelBaseCls.js',array('charset' => 'utf-8'));
		echo $this->Html->script('MAT/chartpanel/ItemPutCurSnapshot.js',array('charset' => 'utf-8'));
		echo $this->Html->script('MAT/chartpanel/ItemPutOldSnapshot.js',array('charset' => 'utf-8'));
	?>
</head>
<body id="body">
	<div id="container">
		<div id="header"></div>
		<div id="header_sub" class="header_sub">
			<?php echo $this->Html->link('Home','/'); ?>
		</div><!-- end #header_sub -->
		<div id="header_sub_locale" class="header_sub_locale">
			<span><?php setlocale(LC_TIME, 'it_IT.UTF-8'); echo strftime("%A %d %B %Y"); ?>&nbsp;</span>
		</div><!-- end #header_sub_locale -->
		<div id="menu">
			<?php echo $this->element('menu'); ?>
        	</div> <!-- end #menu -->
        	<div id="center">
			<?php echo $this->element('user_info'); ?>
			<?php echo $session->flash();?>
			<?php echo $content_for_layout; ?>
		</div>
        	<div id="bottom"></div>
		<div if="bottom_sub">
			<div><hr class="hr_bottom_sub"></hr></div>
			<div><span class="bottom_piva"> &nbsp; &copy; 2011 &nbsp;<?php echo $html->image('gallo_big.jpg', array('width' => 15, 'alt' => 'mattino logo', 'align' => 'top', 'vspace' => '3')) ?>Il Mattino  -  C.F. 01136950639 - P. IVA 05317851003 </span></div><br />
		</div><!-- end #bottom_sub -->
	</div> <!-- end #container -->
	<!--<?php echo $this->element('sql_dump'); ?>-->

	<script>
		$(document).ready(function(){
			var height = $("#menu").height();
			$('#center').css('height', height);
		});
	</script>
</body>
</html>
