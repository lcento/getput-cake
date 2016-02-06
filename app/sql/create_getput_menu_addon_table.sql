USE getput;

DROP TABLE IF EXISTS getput_menu_addon;

CREATE TABLE getput_menu_addon
(
	menu_addon_id			int(11) NOT NULL AUTO_INCREMENT,
	menu_addon_main_id 		int(11) DEFAULT 0,
	menu_addon_user_id		int(11) NOT NULL,
	menu_addon_status               tinyint DEFAULT 1,
	PRIMARY KEY(menu_addon_id),
	UNIQUE KEY(menu_addon_main_id,menu_addon_user_id),
	FOREIGN KEY(menu_addon_user_id) REFERENCES getput_users(users_id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(menu_addon_main_id) REFERENCES getput_menu_main(menu_main_id) ON DELETE CASCADE ON UPDATE CASCADE 
)
TYPE=InnoDB;

#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (1,11,1);
