USE getput;

DROP TABLE IF EXISTS getput_ctrl_act_permit;

CREATE TABLE getput_ctrl_act_permit 
(
	ctrl_act_id			int(11) NOT NULL AUTO_INCREMENT,
	ctrl_act_menu_id 		int(11) DEFAULT 0,
	ctrl_act_desc			varchar(255) NOT NULL,
	ctrl_act_controller		varchar(255),
	ctrl_act_action			varchar(255),
	ctrl_act_type			varchar(255),
	PRIMARY KEY(ctrl_act_id),
	KEY(ctrl_act_controller),
	KEY(ctrl_act_action),
	FOREIGN KEY(ctrl_act_menu_id) REFERENCES getput_menu_main(menu_main_id) ON DELETE CASCADE ON UPDATE CASCADE 
)
TYPE=InnoDB;


INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (1,1,"Preleva files","downloads","items","get_all");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (2,2,"Invia articoli","uploads","articles","put_art");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (3,3,"Invia foto","uploads","photo","put_pho");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (4,4,"Invia files","uploads","items","put_all");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (5,5,"Gestione utenti","admins","gestusers","adm_gst");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (6,5,"Lista utenti","admins","listusers","adm_gst");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (7,6,"Files prelevati","histories","listfileget","dta_hst");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (8,6,"Files inviati","histories","listfileput","dta_hst");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (9,6,"Connessioni","histories","connusers","dta_hst");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (10,7,"Editor download","downloads","getgen","get_esw");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (11,8,"Editor manual","downloads","getgen","get_emn");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (12,9,"Help","suppdocs","help","hlp_all");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (13,10,"Gestione collab","gestcollabs","gestcollabs","add_on");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (14,10,"Contributi inviati","gestcollabs","listcontrput","add_on");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (15,10,"Grafico contr. inv.","gestcollabs","graphitemput","add_on");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (16,11,"Agenzie","supplinks","agenzie","add_on");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (17,5,"JsonOper","admins","jsonGetAgencyGroup","adm_gst");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (18,5,"JsonOper","admins","jsonGetLevelUser","adm_gst");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (19,5,"JsonOper","admins","jsonGetTypeUser","adm_gst");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (20,5,"JsonOper","admins","jsonGetDefUser","adm_gst");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (21,5,"JsonOper","admins","jsonGetAccessRealnameUser","adm_gst");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (22,5,"JsonOper","admins","jsonGetListUser","adm_gst");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (23,5,"JsonOper","admins","jsonGetAccessUser","adm_gst");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (24,5,"JsonOper","admins","jsonGetListViewUser","adm_gst");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (25,5,"JsonOper","admins","jsonGetUser","adm_gst");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (26,5,"JsonOper","admins","jsonSaveUserIfValid","adm_gst");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (27,5,"JsonOper","admins","jsonPrintPdf","adm_gst");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (28,5,"JsonOper","admins","viewPdf","adm_gst");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (29,5,"JsonOper","admins","jsonDelUser","adm_gst");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (30,6,"JsonOper","histories","jsonGetTypeUser","dta_hst");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (31,6,"JsonOper","histories","jsonGetListViewUser","dta_hst");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (32,6,"JsonOper","histories","jsonGetAgencyGroup","dta_hst");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (33,6,"JsonOper","histories","jsonGetDefFilter","dta_hst");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (34,6,"JsonOper","histories","jsonPutListViewUser","dta_hst");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (35,6,"JsonOper","histories","jsonGetFileDest","dta_hst");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (36,6,"JsonOper","histories","jsonConListViewUser","dta_hst");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (37,10,"JsonOper","gestcollabs","jsonGetListUser","add_on");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (38,10,"JsonOper","gestcollabs","jsonGetLevelUser","add_on");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (39,10,"JsonOper","gestcollabs","jsonGetAgencyGroup","add_on");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (40,10,"JsonOper","gestcollabs","jsonGetTypeUser","add_on");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (41,10,"JsonOper","gestcollabs","jsonGetAccessUser","add_on");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (42,10,"JsonOper","gestcollabs","jsonGetDefUser","add_on");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (43,10,"JsonOper","gestcollabs","jsonGetAccessRealnameUser","add_on");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (44,10,"JsonOper","gestcollabs","jsonPutListContrib","add_on");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (45,10,"JsonOper","gestcollabs","jsonGetDefFilter","add_on");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (46,10,"JsonOper","gestcollabs","jsonGetTypeContrib","add_on");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (47,10,"JsonOper","gestcollabs","jsonGetItemPutCur","add_on");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (48,10,"JsonOper","gestcollabs","jsonGetItemPutOld","add_on");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (49,14,"Cms manual","downloads","getgen","get_cmn");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (50,13,"Invio cms","supplinks","sendcms","add_on");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (51,12,"JsonOper","gestexternal","jsonGetListUser","add_on");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (52,12,"JsonOper","gestexternal","jsonGetDefUser","add_on");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (53,12,"JsonOper","gestexternal","jsonGetAgencyGroup","add_on");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (54,12,"JsonOper","gestexternal","jsonGetListViewUser","add_on");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (55,12,"Gestione utenti age.","gestexternal","gestusers","add_on");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (56,12,"Lista utenti age.","gestexternal","listusers","add_on");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (57,12,"JsonOper","gestexternal","jsonGetUser","add_on");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (58,12,"JsonOper","gestexternal","jsonSaveUserIfValid","add_on");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (59,12,"JsonOper","gestexternal","jsonPrintPdf","add_on");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (60,12,"JsonOper","gestexternal","viewPdf","add_on");
INSERT INTO getput_ctrl_act_permit (ctrl_act_id,ctrl_act_menu_id,ctrl_act_desc,ctrl_act_controller,ctrl_act_action,ctrl_act_type) VALUES (61,12,"JsonOper","gestexternal","jsonDelUser","add_on");
