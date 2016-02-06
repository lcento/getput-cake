DROP TABLE IF EXISTS getput_users_connect;

USE getput;

CREATE TABLE getput_users_connect
(
	users_connect_id		int(11) NOT NULL, 
	users_connect_username 		varchar(50) NOT NULL, 	
	users_connect_lastcon		int(11) DEFAULT 0,
	users_connect_nowcon		int(11) NOT NULL DEFAULT 0,
	PRIMARY KEY(users_connect_id),
	FOREIGN KEY(users_connect_id) REFERENCES getput_users(users_id) ON DELETE CASCADE ON UPDATE CASCADE
)
TYPE=InnoDB;;
