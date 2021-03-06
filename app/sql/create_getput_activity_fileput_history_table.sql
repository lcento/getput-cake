DROP TABLE IF EXISTS getput_activity_fileput_history;

USE getput;

CREATE TABLE getput_activity_fileput_history
(
	activity_fileput_history_num_id			int(11) AUTO_INCREMENT,
	activity_fileput_history_users_id 		int(11),
	activity_fileput_history_users_realname		varchar(50),
	activity_fileput_history_filename		varchar(100),
	activity_fileput_history_absfilename		varchar(100),
	activity_fileput_history_filedest		varchar(20),
	activity_fileput_history_date			int(11),
	PRIMARY KEY(activity_fileput_history_num_id,activity_fileput_history_users_id,activity_fileput_history_date),
	FOREIGN KEY(activity_fileput_history_users_id) REFERENCES getput_activity(activity_users_id) ON DELETE CASCADE ON UPDATE CASCADE
)
TYPE=InnoDB;
