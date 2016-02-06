<div id="error_message">
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tr height="60px"></tr>
		<tr valign="center" align="center">
			<td>
				<table width="320px" height="180px" class="box_form1" align="center">
					<tr valign="center" align="center">
						<td>
							<table width="310px" height="170px" class="flash_form1" align="center" border="0">
								<tr height="20px" align="left" valign="top"></tr>
								<tr height="10px" align="left" valign="top">
									<td align="center" valign="middle" class="text_message1"><?php echo $message; ?></td>
								</tr>
								<tr height="10px" align="left" valign="top">
									<td align="center" valign="middle">
										<?php echo $html->link('Indietro', array('controller' => 'histories', 'action' => 'listfileput'), array('class' => 'link_message1'));?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div> <!-- end #error_messages -->


