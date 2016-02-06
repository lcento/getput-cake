DROP TABLE IF EXISTS getput_users_addon;

USE getput;

CREATE TABLE getput_users_addon
(
	users_addon_num			int(11) NOT NULL AUTO_INCREMENT,
	users_addon_id 			int(11) NOT NULL,
	users_addon_level		int(1) NOT NULL,
	users_addon_status		tinyint(1) UNSIGNED DEFAULT 0, 	
	PRIMARY KEY(users_addon_num),
	KEY(users_addon_id),
	KEY(users_addon_level),
	FOREIGN KEY(users_addon_id) REFERENCES getput_users(users_id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(users_addon_level) REFERENCES getput_level_users_addon_desc(level_users_addon_num) ON DELETE CASCADE ON UPDATE CASCADE
)
TYPE=InnoDB;

INSERT INTO getput_users_addon (users_addon_id,users_addon_level,users_addon_status) VALUES (1,1,1);
INSERT INTO getput_users_addon (users_addon_id,users_addon_level,users_addon_status) VALUES (2,1,1);
INSERT INTO getput_users_addon (users_addon_id,users_addon_level,users_addon_status) VALUES (3,1,1);
