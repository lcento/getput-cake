USE getput;

DROP TABLE IF EXISTS getput_filedest;

CREATE TABLE getput_filedest
(
	id_num                  int(11) AUTO_INCREMENT,
	filedest_id	 	char(3),
	filedest_desc	 	varchar(20) NOT NULL,
        PRIMARY KEY(id_num),
        UNIQUE KEY(filedest_id)
);

INSERT INTO getput_filedest (filedest_id,filedest_desc) VALUES ("ALL","GENERICA");
INSERT INTO getput_filedest (filedest_id,filedest_desc) VALUES ("ATT","ATTUALITA");
INSERT INTO getput_filedest (filedest_id,filedest_desc) VALUES ("AVE","AVELLINO");
INSERT INTO getput_filedest (filedest_id,filedest_desc) VALUES ("BEN","BENEVENTO");
INSERT INTO getput_filedest (filedest_id,filedest_desc) VALUES ("CAM","CAMPANIA");
INSERT INTO getput_filedest (filedest_id,filedest_desc) VALUES ("CAS","CASERTA");
INSERT INTO getput_filedest (filedest_id,filedest_desc) VALUES ("CRO","CRONACA");
INSERT INTO getput_filedest (filedest_id,filedest_desc) VALUES ("CUL","CULTURA");
INSERT INTO getput_filedest (filedest_id,filedest_desc) VALUES ("ECO","ECONOMIA");
INSERT INTO getput_filedest (filedest_id,filedest_desc) VALUES ("GNA","GRANDE NAPOLI");
INSERT INTO getput_filedest (filedest_id,filedest_desc) VALUES ("RUB","RUBRICHE");
INSERT INTO getput_filedest (filedest_id,filedest_desc) VALUES ("MON","MONDO");
INSERT INTO getput_filedest (filedest_id,filedest_desc) VALUES ("NOR","NORD");
INSERT INTO getput_filedest (filedest_id,filedest_desc) VALUES ("POL","POLITICA");
INSERT INTO getput_filedest (filedest_id,filedest_desc) VALUES ("PRP","PRIMA PAGINA");
INSERT INTO getput_filedest (filedest_id,filedest_desc) VALUES ("SAL","SALERNO");
INSERT INTO getput_filedest (filedest_id,filedest_desc) VALUES ("SPT","SPETTACOLI");
INSERT INTO getput_filedest (filedest_id,filedest_desc) VALUES ("SPO","SPORT");
INSERT INTO getput_filedest (filedest_id,filedest_desc) VALUES ("SPL","SPORT DEL LUNEDI");
INSERT INTO getput_filedest (filedest_id,filedest_desc) VALUES ("ROM","ROMA");
INSERT INTO getput_filedest (filedest_id,filedest_desc) VALUES ("SUD","SUD");
INSERT INTO getput_filedest (filedest_id,filedest_desc) VALUES ("XSC","TIPOGRAFIA");
