DROP TABLE IF EXISTS getput_users;

USE getput;

CREATE TABLE getput_users
(
	users_id 			int(11) AUTO_INCREMENT,
	users_username 			varchar(50) NOT NULL, 	
	users_password 			varchar(50),
	users_username_realname		varchar(50), 	
	users_level 			int(1) NOT NULL DEFAULT 0,
	users_type			int(1) NOT NULL DEFAULT 0,
	users_type_access		int(1) NOT NULL DEFAULT 0, 
	users_type_access_realname	int(1) NOT NULL DEFAULT 0, 
	users_dirname_get		varchar(255) NOT NULL,
	users_dirname_put_art 		varchar(255) NOT NULL,
	users_dirname_put_pho 		varchar(255) NOT NULL,
	users_dirname_put_all		varchar(255),
	users_se_author			varchar(100) NOT NULL, 	
	PRIMARY KEY(users_id),
	UNIQUE KEY(users_username),
	UNIQUE KEY(users_se_author)
)
TYPE=InnoDB;

INSERT INTO getput_users (users_username,users_password,users_username_realname,users_level,users_type,users_type_access,users_type_access_realname,users_dirname_get,users_dirname_put_art,users_dirname_put_pho) VALUES ("lcento","Mnetwork",NULL,3,2,1,1,"/home/network_mg/pippo","/home/network_mg/pippo/art","/home/network_mg/pippo/pho");
INSERT INTO getput_users (users_username,users_password,users_username_realname,users_level,users_type,users_type_access,users_type_access_realname,users_dirname_get,users_dirname_put_art,users_dirname_put_pho) VALUES ("admin","czc320x",NULL,10,0,0,0,"/home/network_mg/pippo","/home/network_mg/pippo/art","/home/network_mg/pippo/pho");
INSERT INTO getput_users (users_username,users_password,users_username_realname,users_level,users_type,users_type_access,users_type_access_realname,users_dirname_get,users_dirname_put_art,users_dirname_put_pho) VALUES ("test1","Mnetwork",NULL,1,2,0,0,"/tmp","/tmp/art","/tmp/pho");
