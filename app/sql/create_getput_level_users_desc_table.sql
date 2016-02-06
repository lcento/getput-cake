USE getput;

DROP TABLE IF EXISTS getput_level_users_desc;

CREATE TABLE getput_level_users_desc
(
	level_users_num 	int(1) PRIMARY KEY DEFAULT 0,
	level_users_desc 	varchar(20) NOT NULL DEFAULT "DISABLED"
);

INSERT INTO getput_level_users_desc (level_users_num,level_users_desc) VALUES (0,"DISABLED");
INSERT INTO getput_level_users_desc (level_users_num,level_users_desc) VALUES (1,"UPLOAD");
INSERT INTO getput_level_users_desc (level_users_num,level_users_desc) VALUES (2,"DOWNLOAD");
INSERT INTO getput_level_users_desc (level_users_num,level_users_desc) VALUES (3,"UPLOAD+DOWNLOAD");
INSERT INTO getput_level_users_desc (level_users_num,level_users_desc) VALUES (4,"OPUSER");
INSERT INTO getput_level_users_desc (level_users_num,level_users_desc) VALUES (10,"ADMIN");
