<div id="sendcms">
        <?php echo $form->create('Sendcms', array(
                                        'url' => 'http://cms.ilmattino.it/collab/auth.php',
                                        'type' => 'post',
                                        'name' => 'auth',
                                        'target' => '_blank'));
        ?>

        <?php echo $this->Form->input('userweb', array('type' => 'hidden','name' => 'userweb','value' => $session->read('User.username'))); ?>

        <?php echo $this->Form->input('testataweb', array('type' => 'hidden','name' => 'testataweb','value' => '4')); ?>

                <table width="100%" cellspacing="0" cellpadding="0">
                        <tr height="60px"></tr>
                        <tr valign="center" align="center">
                                <td>
                                        <table width="580px" height="180px" class="box_form1" align="center">
                                                <tr height="20px" valign="top" align="center">
                                                        <td>
                                                                <table height="16px" width="100%" class="header_form1" align="center" cellspacing="0" cellpadding="0">
                                                                        <tr align="center" valign="center">
                                                                                <td align="center" valign="middle">Invia Contributi Cms</td>
                                                                        </tr>
                                                                </table>
                                                        </td>
                                                </tr>
                                                <h5 valign="top" align="center">
                                                        <td>
                                                                <table width="100%" class="table_form1" align="center">
                                                                        <tr><td><h5 style="text-align:left;margin:25px;font-size:13px;">
                                                                                Questo sistema consente ai collaboratori esterni di inviare testi e foto alla redazione internet del Mattino, collocandoli in un'area di appoggio temporanea denominata "collaborazioni".
                                                                                Tale sistema non consente invece di pubblicare contenuti sul sito del Mattino, essendo compito esclusivo della Redazione scegliere gli articoli da pubblicare, titolarli e impaginarli.
                                                                        </h5></td></tr>
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
                                                                        <tr height="5px" align="left" valign="top"></tr>
                                                                        <tr height="10px" align="left" valign="top">
                                                                                <td width="10px" align="left"></td>
                                                                                <td width="100px" class="table_label_text1" align="left" valign="middle"></td>
                                                                                <td class="submit" valign="bottom" align="right"><div class="submit"><input class="button_form1" onmouseover="this.style.color='#FFFFFF';" onmouseout="this.style.color='black';" type="submit" name="cmdLogin" value="Invia" /></div></td>
                                                                                <td width="10px" align="left"></td>
                                                                        </tr>
                                                                        <tr height="5px" align="left" valign="top"></tr>
                                                                </table>
                                                        </td>
                                                </tr>
                                        </table>
                                </td>
                        </tr>
                </table>
        </form>
</div> <!-- end articles -->
