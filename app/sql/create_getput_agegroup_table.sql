USE getput;

DROP TABLE IF EXISTS getput_agegroup;

CREATE TABLE getput_agegroup
(
	group_id		int(11) NOT NULL,
	group_desc		varchar(255) NOT NULL DEFAULT '',
	PRIMARY KEY(group_id),
	UNIQUE KEY(group_desc)
)
TYPE=InnoDB;

INSERT INTO getput_agegroup (group_id, group_desc) VALUES (1, "ILMATTINO");
INSERT INTO getput_agegroup (group_id, group_desc) VALUES (2, "ILMESSAGGERO");
INSERT INTO getput_agegroup (group_id, group_desc) VALUES (3, "QDIPUGLIA");
INSERT INTO getput_agegroup (group_id, group_desc) VALUES (4, "LEGGO");
