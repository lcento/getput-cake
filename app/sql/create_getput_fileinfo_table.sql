USE getput;

DROP TABLE IF EXISTS getput_fileinfo;


CREATE TABLE getput_fileinfo
(
	fileinfo_id					varchar(200) NOT NULL,
	fileinfo_dirname			 	varchar(200) NOT NULL,
	fileinfo_filename				varchar(100) NOT NULL,
	fileinfo_absfilename				varchar(100) NOT NULL,
	fileinfo_ext					varchar(50),
	fileinfo_size					varchar(40) NOT NULL,
	fileinfo_filedate				int(11) NOT NULL,
	fileinfo_timenow				int(11) NOT NULL,
	PRIMARY KEY(fileinfo_id)
);
