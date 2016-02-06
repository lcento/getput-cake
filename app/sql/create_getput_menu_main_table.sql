USE getput;

DROP TABLE IF EXISTS getput_menu_main;

CREATE TABLE getput_menu_main
(
        menu_main_id             	int(11) AUTO_INCREMENT,
        menu_main_orderid             	int(11) DEFAULT 0,
        menu_main_desc                	varchar(255) NOT NULL,
	menu_main_controller		varchar(255),
	menu_main_action		varchar(255),
	menu_main_items			tinyint,
	menu_main_addon			tinyint,
	menu_main_type			varchar(255),
	menu_main_status               	tinyint,
        PRIMARY KEY(menu_main_id),
	UNIQUE KEY(menu_main_desc)
)
TYPE=InnoDB;

INSERT INTO getput_menu_main (menu_main_id,menu_main_orderid,menu_main_desc,menu_main_controller,menu_main_action,menu_main_items,menu_main_addon,menu_main_type,menu_main_status) VALUES (1,0,"Preleva files","downloads","items",0,0,"get_all",1);
INSERT INTO getput_menu_main (menu_main_id,menu_main_orderid,menu_main_desc,menu_main_controller,menu_main_action,menu_main_items,menu_main_addon,menu_main_type,menu_main_status) VALUES (2,1,"Invia articoli","uploads","articles",0,0,"put_art",1);
INSERT INTO getput_menu_main (menu_main_id,menu_main_orderid,menu_main_desc,menu_main_controller,menu_main_action,menu_main_items,menu_main_addon,menu_main_type,menu_main_status) VALUES (3,2,"Invia foto","uploads","photo",0,0,"put_pho",1);
INSERT INTO getput_menu_main (menu_main_id,menu_main_orderid,menu_main_desc,menu_main_controller,menu_main_action,menu_main_items,menu_main_addon,menu_main_type,menu_main_status) VALUES (4,3,"Invia files","uploads","items",0,0,"put_all",1);
INSERT INTO getput_menu_main (menu_main_id,menu_main_orderid,menu_main_desc,menu_main_controller,menu_main_action,menu_main_items,menu_main_addon,menu_main_type,menu_main_status) VALUES (5,10,"Administration","menus","menuStatus",1,0,"adm_gst",1);
INSERT INTO getput_menu_main (menu_main_id,menu_main_orderid,menu_main_desc,menu_main_controller,menu_main_action,menu_main_items,menu_main_addon,menu_main_type,menu_main_status) VALUES (6,11,"Data History","menus","menuStatus",1,0,"dta_hst",1);
INSERT INTO getput_menu_main (menu_main_id,menu_main_orderid,menu_main_desc,menu_main_controller,menu_main_action,menu_main_items,menu_main_addon,menu_main_type,menu_main_status) VALUES (7,4,"Editor download","downloads","getgen/Editor2.exe",0,0,"get_esw",1);
INSERT INTO getput_menu_main (menu_main_id,menu_main_orderid,menu_main_desc,menu_main_controller,menu_main_action,menu_main_items,menu_main_addon,menu_main_type,menu_main_status) VALUES (8,5,"Editor manual","downloads","getgen/Editor.pdf",0,0,"get_emn",1);
INSERT INTO getput_menu_main (menu_main_id,menu_main_orderid,menu_main_desc,menu_main_controller,menu_main_action,menu_main_items,menu_main_addon,menu_main_type,menu_main_status) VALUES (9,9,"Help","suppdocs","help",0,0,"hlp_all",1);
INSERT INTO getput_menu_main (menu_main_id,menu_main_orderid,menu_main_desc,menu_main_controller,menu_main_action,menu_main_items,menu_main_addon,menu_main_type,menu_main_status) VALUES (10,12,"Collaboratori","menus","menuStatus",1,1,"add_on",1);
INSERT INTO getput_menu_main (menu_main_id,menu_main_orderid,menu_main_desc,menu_main_controller,menu_main_action,menu_main_items,menu_main_addon,menu_main_type,menu_main_status) VALUES (11,8,"Agenzie","supplinks","agenzie",0,1,"add_on",1);
INSERT INTO getput_menu_main (menu_main_id,menu_main_orderid,menu_main_desc,menu_main_controller,menu_main_action,menu_main_items,menu_main_addon,menu_main_type,menu_main_status) VALUES (12,13,"External","menus","menuStatus",1,1,"add_on",1);
INSERT INTO getput_menu_main (menu_main_id,menu_main_orderid,menu_main_desc,menu_main_controller,menu_main_action,menu_main_items,menu_main_addon,menu_main_type,menu_main_status) VALUES (13,7,"Invio cms","supplinks","sendcms",0,1,"add_on",1);
INSERT INTO getput_menu_main (menu_main_id,menu_main_orderid,menu_main_desc,menu_main_controller,menu_main_action,menu_main_items,menu_main_addon,menu_main_type,menu_main_status) VALUES (14,6,"Cms manual","downloads","getgen/ManualeCms.pdf",0,0,"get_cmn",1);
