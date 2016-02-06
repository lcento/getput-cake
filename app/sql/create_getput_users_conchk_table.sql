USE getput;

DROP TABLE IF EXISTS getput_users_conchk;


CREATE TABLE getput_users_conchk
(
	users_conchk_num		int(11) AUTO_INCREMENT,
	users_conchk_id			int(11) NOT NULL, 
	users_conchk_ip 		varchar(50) DEFAULT 0,
	users_conchk_sessid		varchar(50) NOT NULL,
	users_conchk_datecon		int(11),
	PRIMARY KEY(users_conchk_num),
	KEY(users_conchk_ip,users_conchk_sessid),
	FOREIGN KEY(users_conchk_id) REFERENCES getput_users(users_id) ON DELETE CASCADE ON UPDATE CASCADE
)
TYPE=InnoDB;
