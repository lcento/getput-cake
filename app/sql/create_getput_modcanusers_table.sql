DROP TABLE IF EXISTS getput_modcanusers;

USE getput;

CREATE TABLE getput_modcanusers
(
	modcanusers_id 			int(11),
	modcanusers_username 		varchar(50) NOT NULL, 	
	PRIMARY KEY(modcanusers_id),
	UNIQUE KEY(modcanusers_username)
)
