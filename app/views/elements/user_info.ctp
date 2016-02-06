<div id="user_info">
	<?php if (!$session->check('User')): ?>
		<h1 class="menu_h2">&nbsp;</h1>
	<?php else: ?>
		<?php
			$user_connect = $this->requestAction(array('controller' => 'UsersConnect', 'action' => 'infoUserConnect'));

			if ( !empty($user_connect) ) 
			{
				$usercon = $user_connect['UserConnect']['users_connect_username'];

				if ( $user_connect['UserConnect']['users_connect_lastcon'] != 0 )
					$userlastcon = date("d-m-Y H:i", $user_connect['UserConnect']['users_connect_lastcon']);
				else
					$userlastcon = "";
			}
		?>

		<h1 class="menu_h2">&nbsp;&nbsp;Utente : <?php echo $usercon ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ultima connessione : <?php echo $userlastcon ?></h1>

	<?php endif; ?>
</div>