USE getput;

DROP TABLE IF EXISTS getput_ip_permit;

CREATE TABLE getput_ip_permit
(
        ip_permit_id               	int(11) AUTO_INCREMENT,
	ip_permit_address		varchar(255) NOT NULL,
        ip_permit_alias			varchar(255),	
        PRIMARY KEY(ip_permit_id),
	UNIQUE KEY(ip_permit_address)
)
TYPE=InnoDB;

INSERT INTO getput_ip_permit (ip_permit_id,ip_permit_address,ip_permit_alias) VALUES (1,"191.200.30.210","ntnetmg");
INSERT INTO getput_ip_permit (ip_permit_id,ip_permit_address,ip_permit_alias) VALUES (2,"191.200.30.92","gestori_2");
INSERT INTO getput_ip_permit (ip_permit_id,ip_permit_address,ip_permit_alias) VALUES (3,"191.200.30.234","gestori_5");
INSERT INTO getput_ip_permit (ip_permit_id,ip_permit_address,ip_permit_alias) VALUES (4,"191.200.30.222","gestori_1");
INSERT INTO getput_ip_permit (ip_permit_id,ip_permit_address,ip_permit_alias) VALUES (5,"85.18.214.164","workmess");
