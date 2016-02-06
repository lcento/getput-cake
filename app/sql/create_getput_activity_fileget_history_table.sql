USE getput;

DROP TABLE IF EXISTS getput_activity_fileget_history;

CREATE TABLE getput_activity_fileget_history
(
        activity_fileget_history_num_id                 int(11) AUTO_INCREMENT,
	activity_fileget_history_users_id 		int(11),
	activity_fileget_history_users_realname		varchar(50),
	activity_fileget_history_filename		varchar(100),
	activity_fileget_history_absfilename		varchar(100),
	activity_fileget_history_date			int(11),
	PRIMARY KEY(activity_fileget_history_num_id,activity_fileget_history_users_id,activity_fileget_history_date),
	FOREIGN KEY(activity_fileget_history_users_id) REFERENCES getput_activity(activity_users_id) ON DELETE CASCADE ON UPDATE CASCADE
)
TYPE=InnoDB;
