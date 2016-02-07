<?php

	$config = array(

	/* log file */
	'log_file' => 'getput',

	/* imap string connect */
	'imap_string_connect' => '{linux:143/imap4/notls}',

        /* the name of ldap server */
        'ldap_server' => 'linux',

        /* Set the base dn to search the entire directory */
        'ldap_base_dn' => 'dc=linux,dc=napoli,dc=edime,dc=ilmattino',

	/* max upload photo size */
	'max_upload_photosize' => 1500000,

	/* max size for upload art bytes */
	'max_upload_artsize' => 1500000,

	/* max size for upload items bytes */
	'max_upload_itemsize' => 10000000,

	/* allowed group connect */
	'allowed_group_connect' => array('ILMATTINO'),

	/* local_group_desc */
	'local_group_desc' => 'ILMATTINO',

	/* allower dirs */
	'allowed_dir' => array('/home/shared/inviati/get',
				'/home/shared/collab/get',
				'/home/shared/inviati/put/art',
				'/home/shared/inviati/put/pho',
				'/home/shared/inviati/put/all'),

	/* default put dir */
	'default_put_dir' => '/home/shared/inviati/put/all',

	/* default_get_dir */
	'default_get_dir' => '/home/shared/collab/get',

	/* default level */
	'default_level_user' => 'UPLOAD',

	/* allowed art ext */
	'allowedArtTypes' => array('txt', 'TXT'),

	/* allowed pho ext */
	'allowedPhoTypes' => array('jpg', 'JPG'),

	/* allowed all ext */
	'allowedAllTypes' => array('jpg', 'JPG', 'txt', 'TXT', 'pdf', 'PDF'),

	/* not_to_be_shown */
	'not_to_be_shown' => array("."),

	/* not_to_be_download */
	'deniedDownloadTypes' => array("htm", "html", "shtml", "dhtml", "php"),

	/* array of year */
	'year_list' => array( 1 => strftime("%Y"), 
			      2 => (strftime("%Y") - 1)),

	/* array of mounth */
	'mounth_list' => array( 1 => 'gennaio',
			        2 => 'febbraio',
			        3 => 'marzo',
			        4 => 'aprile',
			        5 => 'maggio',
			        6 => 'giugno',
			        7 => 'luglio',
			        8 => 'agosto',
			        9 => 'settembre',
			       10 => 'ottobre',
			       11 => 'novembre',
			       12 => 'dicembre'),

	/* array of day */
	'day_list' => array( 1 => '01',
			     2 => '02',
			     3 => '03',
			     4 => '04',
			     5 => '05',
			     6 => '06',
			     7 => '07',
			     8 => '08',
			     9 => '09',
			    10 => '10',
			    11 => '11',
			    12 => '12',
			    13 => '13',
			    14 => '14',
			    15 => '15',
			    16 => '16',
			    17 => '17',
			    18 => '18',
			    19 => '19',
			    20 => '20',
			    21 => '21',
			    22 => '22',
			    23 => '23',
			    24 => '24',
			    25 => '25',
			    26 => '26',
			    27 => '27',
			    28 => '28',
			    29 => '29',
			    30 => '30',
			    31 => '31'),

        /* array of hour */
	'hour_list' => array( 1 => '00:00',
			      2 => '01:00',
			      3 => '02:00',
			      4 => '03:00',
			      5 => '04:00',
			      6 => '05:00',
			      7 => '06:00',
			      8 => '07:00',
			      9 => '08:00',
			     10 => '09:00',
			     11 => '10:00',
			     12 => '11:00',
			     13 => '12:00',
			     14 => '13:00',
			     15 => '14:00',
			     16 => '15:00',
			     17 => '16:00',
			     18 => '17:00',
			     19 => '18:00',
			     20 => '19:00',
			     21 => '20:00',
			     22 => '21:00',
			     23 => '22:00',
			     24 => '23:00'),

	/* array of mounth short*/
	'mounth_list_short' => array( "01" => 'Gen',
			              "02" => 'Feb',
			              "03" => 'Mar',
			              "04" => 'Apr',
			              "05" => 'Mag',
			              "06" => 'Giu',
			              "07" => 'Lug',
			              "08" => 'Ago',
			              "09" => 'Set',
			              "10" => 'Ott',
			              "11" => 'Nov',
			              "12" => 'Dic'),

	/* array date search history */
	'date_list_hst' => array( 'T'=>' tutte',
				  'O'=> ' oggi',
				  'I'=>' intervallo'),

	/* array date search gestcollabs */
	'date_list_gstc' => array( 'T'=>' tutte',
				   'O'=> ' oggi',
				   'U'=>' mese-precedente',
				   'I'=>' intervallo'),

	/* max rows array for print pdf viewPutPdf */
	'max_count_viewPutPdf' => 6000,

	/* max rows array for print pdf viewGetPdf */
	'max_count_viewGetPdf' => 6000,

	/* max rows array for print pdf viewConPdf */
	'max_count_viewConPdf' => 6000,

	/* directory for generic download files */
	'get_gen_dir' => '/home/shared/dl',

	/* directory get inscollabs */
	'dirname_get_collab' => '/home/shared/inviati/get',

	/* directory put art inscollabs */
	'dirname_put_art_collab' => '/home/shared/inviati/put/art',

	/* directory put pho inscollabs */
	'dirname_put_pho_collab' => '/home/shared/inviati/put/pho',

	/* directory put all inscollabs */
	'dirname_put_all_collab' => '/home/shared/inviati/put/all',

	/* user type collab */
	'user_type_collab' => 'COLLAB',

        /* user type collab cms */
        'user_type_collab_cms' => 'COLLABCMS',

	/* user type access collab */
	'user_type_access_collab' => 'LOCAL',

	/* user type access realname collab */
	'user_type_access_real_collab' => 'LOCAL',

	/* agency group collab */
	'agency_group_collab' => 'ILMATTINO',

	/* disable collab level user admin */
	'user_level_disable_collab' => 10,

	/* disable collab agency addon */
	'user_agency_disable_collab' => 0,

	/* tipologia contributi */
	'type_contr' => array( '.txt' => 'Testi',
			       '.jpg' => 'Foto'),

	/* tipologia upload */
	'upload' => array( 'articoli' => 'put_art',
			   'foto' => 'put_pho',
			   'files' => 'put_all' ),

	/* tipologia download */
	'download' => array( 'files' => 'get_all',
			     'editor_software' => 'get_esw',
			     'editor_manual' => 'get_emn',
			     'cms_manual' => 'get_cmn' ),

	/* tipologia docs */
	'doc' => array( 'help_base' => 'hlp_all',
			'help_collaboratori' => 'hlp_clb' ),

	/* tipologia addon */
	'addon' => 'add_on',

	/* tipologia admin */
	'admin' => 'adm_gst',

	/* tipologia history */
	'history' => 'dta_hst',

	/* tipologia menu addon */
	'menu_addon' => array( 'agency' => 'Agenzie',
			       'collab' => 'Collaboratori',
			       'sendcms' => 'Invio cms',
			       'extern' => 'External')
 
	);
?>
