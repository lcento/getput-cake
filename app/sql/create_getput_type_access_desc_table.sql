DROP TABLE IF EXISTS getput_type_access_desc;

USE getput;

CREATE TABLE getput_type_access_desc
(
	type_access_num 	int(1) PRIMARY KEY DEFAULT 0,
	type_access_desc 	varchar(20) NOT NULL DEFAULT "LOCAL"
);

INSERT INTO getput_type_access_desc (type_access_num,type_access_desc) VALUES (0,"LOCAL");
INSERT INTO getput_type_access_desc (type_access_num,type_access_desc) VALUES (1,"IMAP");
