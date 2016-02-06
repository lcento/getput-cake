USE getput;


DROP TABLE IF EXISTS getput_users_connect_chk;

CREATE TABLE getput_users_connect_chk
(
	users_connect_chk_num		int(11) AUTO_INCREMENT,
	users_connect_chk_id		int(11) NOT NULL, 
        users_connect_chk_name          varchar(50) NOT NULL,
	users_connect_chk_ip 		varchar(50) DEFAULT 0,
	users_connect_chk_sessid	varchar(255) NOT NULL DEFAULT '',
	users_connect_chk_datecon	int(11),
	PRIMARY KEY(users_connect_chk_num),
	KEY(users_connect_chk_sessid),
	FOREIGN KEY(users_connect_chk_id) REFERENCES getput_users(users_id) ON DELETE CASCADE ON UPDATE CASCADE
)
TYPE=InnoDB;


DROP TABLE IF EXISTS cake_sessions;

CREATE TABLE cake_sessions 
(
	id 		varchar(255) NOT NULL DEFAULT '',
	data		mediumtext,
	expires		int(11) DEFAULT NULL,
	PRIMARY KEY(id)
)
TYPE=InnoDB;
