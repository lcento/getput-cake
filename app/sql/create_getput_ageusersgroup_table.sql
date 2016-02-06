USE getput;

DROP TABLE IF EXISTS getput_ageusersgroup;

CREATE TABLE getput_ageusersgroup
(
	users_id		int(11) NOT NULL,
	group_id		int(11) NOT NULL,
	PRIMARY KEY(users_id),
	FOREIGN KEY(users_id) REFERENCES getput_users(users_id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(group_id) REFERENCES getput_agegroup(group_id) ON DELETE CASCADE ON UPDATE CASCADE
)
TYPE=InnoDB;
