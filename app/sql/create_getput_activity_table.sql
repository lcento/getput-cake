DROP TABLE IF EXISTS getput_activity;

USE getput;

CREATE TABLE getput_activity
(
	activity_users_id 		int(11),
	activity_lastget		int(11) DEFAULT 0,
	activity_lastput		int(11) DEFAULT 0,
	PRIMARY KEY(activity_users_id),
	FOREIGN KEY(activity_users_id) REFERENCES getput_users(users_id) ON DELETE CASCADE ON UPDATE CASCADE
)
TYPE=InnoDB;
