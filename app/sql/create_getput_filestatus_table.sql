DROP TABLE IF EXISTS getput_filestatus;

USE getput;

CREATE TABLE getput_filestatus
(
	filestatus_id 					int(11) NOT NULL AUTO_INCREMENT, 
	filestatus_fileinfo_key				varchar(255) NOT NULL,
	filestatus_status				varchar(15),
	filestatus_users_id				int(11) NOT NULL,
	filestatus_timenow				int(11) NOT NULL,
	PRIMARY KEY(filestatus_id),
	KEY(filestatus_users_id),
	FOREIGN KEY(filestatus_users_id) REFERENCES getput_users(users_id) ON DELETE CASCADE ON UPDATE CASCADE
)
TYPE=InnoDB;
