DROP TABLE IF EXISTS getput_level_users_addon_desc;

USE getput;

CREATE TABLE getput_level_users_addon_desc
(
	level_users_addon_num 	int(1) PRIMARY KEY DEFAULT 0,
	level_users_addon_desc 	varchar(20) NOT NULL DEFAULT "DISABLED"
)
TYPE=InnoDB;

INSERT INTO getput_level_users_addon_desc (level_users_addon_num,level_users_addon_desc) VALUES (1,"AGENZIE");
