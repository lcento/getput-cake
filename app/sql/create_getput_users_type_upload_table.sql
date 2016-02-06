DROP TABLE IF EXISTS getput_users_type_upload;

USE getput;

CREATE TABLE getput_users_type_upload
(
	users_type_upload_id 		int(11) NOT NULL,
	users_type_upload_art		tinyint(1) UNSIGNED DEFAULT 0, 	
	users_type_upload_pho		tinyint(1) UNSIGNED DEFAULT 0, 	
	users_type_upload_all		tinyint(1) UNSIGNED DEFAULT 0, 	
	PRIMARY KEY(users_type_upload_id),
	FOREIGN KEY(users_type_upload_id) REFERENCES getput_users(users_id) ON DELETE CASCADE ON UPDATE CASCADE
)
TYPE=InnoDB;

INSERT INTO getput_users_type_upload (users_type_upload_id,users_type_upload_art,users_type_upload_pho,users_type_upload_all) VALUES (1,1,1,1);
INSERT INTO getput_users_type_upload (users_type_upload_id,users_type_upload_art,users_type_upload_pho,users_type_upload_all) VALUES (2,1,1,1);
INSERT INTO getput_users_type_upload (users_type_upload_id,users_type_upload_art,users_type_upload_pho,users_type_upload_all) VALUES (3,1,1,1);
