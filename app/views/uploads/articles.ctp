<div id="articles">
	<?php echo $form->create('Uploads', array('action' => 'articles', 'type' => 'file')); ?>
		<table width="100%" cellspacing="0" cellpadding="0">
			<tr height="60px"></tr>
			<tr valign="center" align="center">
				<td>
					<table width="580px" height="180px" class="box_form1" align="center">
						<tr height="20px" valign="top" align="center">
							<td>
								<table height="16px" width="100%" class="header_form1" align="center" cellspacing="0" cellpadding="0">
									<tr align="center" valign="center">
										<td align="center" valign="middle">Invia Articoli</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr valign="top" align="center">
							<td>
								<table width="100%" class="table_form1" align="center">
									<tr height="40px" align="left" valign="top"></tr>
									<tr height="22x" align="left" valign="top">
										<td width="10px" align="left"></td>
										<td class="table_label_text1" align="left" valign="middle"><span class="label_legend2">&nbsp;&nbsp;Data Ultimo Invio : &nbsp;&nbsp;&nbsp;&nbsp;<?php if ( !empty($lastput) ) echo date("d-m-Y H:i", $lastput); else echo ""; ?></span></td>
										<td width="10px" align="left"></td>
									</tr>
									<tr height="10px" align="left" valign="top"></tr>
									<tr height="22x" align="left" valign="top">
										<td width="10px" align="left"></td>
										<td class="table_label_text1" align="left" valign="middle"><span class="label_legend2">&nbsp;&nbsp;Ultimo File Inviato : &nbsp;&nbsp;<?php if ( !empty($lastfileput) ) echo $lastfileput; else echo ""; ?></span></td>
										<td width="10px" align="left"></td>
									</tr>
									<tr height="40px" align="left" valign="bottom"></tr>
								</table>
							</td>
						</tr>
						<tr valign="top" align="center">
							<td>
								<table width="100%" class="table_form3" align="center" cellspacing="0" cellpadding="0">
									<tr align="left" valign="center"><td align="center"><div><hr class="hr_form2"></hr></div></td></tr>
								</table>
							</td>
						</tr>
						<tr height="100%" valign="top" align="center">
							<td>
								<table width="100%" class="table_form2" align="center">
									<tr height="50x" align="left" valign="top"></tr>
									<tr height="22x" align="left" valign="top">
										<td width="10px" align="left"></td>
										<td width="100px" class="table_label_text1" align="left" valign="middle"><label for="txfileupload"> Seleziona il file :</label></td>
										<td align="left" valign="middle"><?php echo  $form->file('txfileupload', array('type' => 'text/plain', 'id' => 'txfileupload', 'size' => 50, 'maxlength' => 50, 'class' => 'table_form_text1', 'label' => false)); ?></td>
										<td width="10px" align="left"></td>
									</tr>
									<tr height="10px" align="left" valign="top"></tr>
									<tr height="22x" align="left" valign="top">
										<td width="10px" align="left"></td>
										<td width="100px" class="table_label_text1" align="left" valign="middle"><label for="file_dest">Destinazione :</label></td>
										<td align="left" valign="middle"><?php echo $form->select('file_dest', $fileDest, "ALL", array('id' => 'file_dest', 'class' => 'table_form_text1', 'label' => false, 'empty'=> false)); ?></td>
										<td width="10px" align="left"></td>
									</tr>
									<tr height="20px" align="left" valign="top"></tr>
									<tr height="22x" align="left" valign="top">
										<td width="10px" align="left"></td>
										<td width="100px" class="table_label_text1" align="left" valign="middle"></td>
										<td class="submit" valign="bottom" align="right"><div class="submit"><input class="button_form1" onmouseover="this.style.color='#FFFFFF';" onmouseout="this.style.color='black';" type="submit" value="Invia" /></div></td>
										<td width="10px" align="left"></td>
									</tr>
									<tr height="20px" align="left" valign="top"></tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
                </table>
	</form>
</div> <!-- end articles -->
