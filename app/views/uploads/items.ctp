<div id="items">
	<?php echo $form->create('Uploads', array('action' => 'items', 'type' => 'file')); ?>
		<table width="100%" cellspacing="0" cellpadding="0">
			<tr height="60px"></tr>
			<tr valign="center" align="center">
				<td>
					<table width="580px" height="180px" class="box_form1" align="center">
						<tr height="20px" valign="top" align="center">
							<td>
								<table height="16px" width="100%" class="header_form1" align="center" cellspacing="0" cellpadding="0">
									<tr align="center" valign="center">
										<td align="center" valign="middle">Invia Files</td>
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
									<tr height="40px" align="left" valign="top"></tr>
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
										<?php if ( $this->Session->read('Item.fname1') == 0 ): ?>
											<td width="100px" class="table_label_text1" align="left" valign="middle"><label for="fileupload1"> Seleziona file1 :</label></td>
										<?php else: ?>
											<td width="100px" class="table_label_text2" align="left" valign="middle"><label for="fileupload1"> Seleziona file1 :</label></td>
										<?php endif; ?>
										<td align="left" valign="middle"><?php echo  $form->file('fileupload1', array('type' => 'image/jpeg', 'id' => 'fileupload1', 'size' => 50, 'maxlength' => 50, 'class' => 'table_form_text1', 'label' => false)); ?></td>
										<td width="10px" align="left"></td>
									</tr>
									<tr height="22x" align="left" valign="top">
										<td width="10px" align="left"></td>
										<?php if ( $this->Session->read('Item.fname2') == 0 ): ?>
											<td width="100px" class="table_label_text1" align="left" valign="middle"><label for="fileupload2"> Seleziona file2 :</label></td>
										<?php else: ?>
											<td width="100px" class="table_label_text2" align="left" valign="middle"><label for="fileupload2"> Seleziona file2 :</label></td>
										<?php endif; ?>
										<td align="left" valign="middle"><?php echo  $form->file('fileupload2', array('id' => 'fileupload2', 'size' => 50, 'maxlength' => 50, 'class' => 'table_form_text1', 'label' => false)); ?></td>
										<td width="10px" align="left"></td>
									</tr>
									<tr height="22x" align="left" valign="top">
										<td width="10px" align="left"></td>
										<?php if ( $this->Session->read('Item.fname3') == 0 ): ?>
											<td width="100px" class="table_label_text1" align="left" valign="middle"><label for="phfileupload3"> Seleziona file3 :</label></td>
										<?php else: ?>
											<td width="100px" class="table_label_text2" align="left" valign="middle"><label for="fileupload3"> Seleziona file3 :</label></td>
										<?php endif; ?>
										<td align="left" valign="middle"><?php echo  $form->file('fileupload3', array('id' => 'fileupload3', 'size' => 50, 'maxlength' => 50, 'class' => 'table_form_text1', 'label' => false)); ?></td>
										<td width="10px" align="left"></td>
									</tr>
									<tr height="22x" align="left" valign="top">
										<td width="10px" align="left"></td>
										<?php if ( $this->Session->read('Item.fname4') == 0 ): ?>
											<td width="100px" class="table_label_text1" align="left" valign="middle"><label for="fileupload4"> Seleziona file4 :</label></td>
										<?php else: ?>
											<td width="100px" class="table_label_text2" align="left" valign="middle"><label for="fileupload4"> Seleziona file4 :</label></td>
										<?php endif; ?>
										<td align="left" valign="middle"><?php echo  $form->file('fileupload4', array('id' => 'fileupload4', 'size' => 50, 'maxlength' => 50, 'class' => 'table_form_text1', 'label' => false)); ?></td>
										<td width="10px" align="left"></td>
									</tr>
									<tr height="22x" align="left" valign="top">
										<td width="10px" align="left"></td>
										<?php if ( $this->Session->read('Item.fname5') == 0 ): ?>
											<td width="100px" class="table_label_text1" align="left" valign="middle"><label for="fileupload5"> Seleziona file5 :</label></td>
										<?php else: ?>
											<td width="100px" class="table_label_text2" align="left" valign="middle"><label for="phfileupload5"> Seleziona file5 :</label></td>
										<?php endif; ?>
										<td align="left" valign="middle"><?php echo  $form->file('fileupload5', array('id' => 'fileupload5', 'size' => 50, 'maxlength' => 50, 'class' => 'table_form_text1', 'label' => false)); ?></td>
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
</div> <!-- end items -->