DROP TABLE IF EXISTS getput_type_users_desc;

USE getput;

CREATE TABLE getput_type_users_desc
(
	type_users_num 		int(1) PRIMARY KEY DEFAULT 0,
	type_users_desc 	varchar(20) NOT NULL DEFAULT "LOCAL"
);

INSERT INTO getput_type_users_desc (type_users_num,type_users_desc) VALUES (0,"LOCAL");
INSERT INTO getput_type_users_desc (type_users_num,type_users_desc) VALUES (1,"COLLAB");
INSERT INTO getput_type_users_desc (type_users_num,type_users_desc) VALUES (2,"INVIATO");
INSERT INTO getput_type_users_desc (type_users_num,type_users_desc) VALUES (3,"COLLABCMS");
