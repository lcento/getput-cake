USE getput;

DROP TABLE IF EXISTS getput_ctrl_act_permit;
DROP TABLE IF EXISTS getput_menu_addon;
DROP TABLE IF EXISTS getput_menu_items;
DROP TABLE IF EXISTS getput_menu_main;

CREATE TABLE getput_menu_main
(
        menu_main_id                    int(11) AUTO_INCREMENT,
        menu_main_orderid               int(11) DEFAULT 0,
        menu_main_desc                  varchar(255) NOT NULL,
        menu_main_controller            varchar(255),
        menu_main_action                varchar(255),
        menu_main_items                 tinyint,
        menu_main_addon                 tinyint,
        menu_main_type                  varchar(255),
        menu_main_status                tinyint,
        PRIMARY KEY(menu_main_id),
        UNIQUE KEY(menu_main_desc)
)
TYPE=InnoDB;

INSERT INTO getput_menu_main (menu_main_id,menu_main_orderid,menu_main_desc,menu_main_controller,menu_main_action,menu_main_items,menu_main_addon,menu_main_type,menu_main_status) VALUES (1,0,"Preleva files","downloads","items",0,0,"get_all",1);
INSERT INTO getput_menu_main (menu_main_id,menu_main_orderid,menu_main_desc,menu_main_controller,menu_main_action,menu_main_items,menu_main_addon,menu_main_type,menu_main_status) VALUES (2,1,"Invia articoli","uploads","articles",0,0,"put_art",1);
INSERT INTO getput_menu_main (menu_main_id,menu_main_orderid,menu_main_desc,menu_main_controller,menu_main_action,menu_main_items,menu_main_addon,menu_main_type,menu_main_status) VALUES (3,2,"Invia foto","uploads","photo",0,0,"put_pho",1);
INSERT INTO getput_menu_main (menu_main_id,menu_main_orderid,menu_main_desc,menu_main_controller,menu_main_action,menu_main_items,menu_main_addon,menu_main_type,menu_main_status) VALUES (4,3,"Invia files","uploads","items",0,0,"put_all",1);
INSERT INTO getput_menu_main (menu_main_id,menu_main_orderid,menu_main_desc,menu_main_controller,menu_main_action,menu_main_items,menu_main_addon,menu_main_type,menu_main_status) VALUES (5,10,"Administration","menus","menuStatus",1,0,"adm_gst",1);
INSERT INTO getput_menu_main (menu_main_id,menu_main_orderid,menu_main_desc,menu_main_controller,menu_main_action,menu_main_items,menu_main_addon,menu_main_type,menu_main_status) VALUES (6,11,"Data History","menus","menuStatus",1,0,"dta_hst",1);
INSERT INTO getput_menu_main (menu_main_id,menu_main_orderid,menu_main_desc,menu_main_controller,menu_main_action,menu_main_items,menu_main_addon,menu_main_type,menu_main_status) VALUES (7,4,"Editor download","downloads","getgen/Editor2.exe",0,0,"get_esw",1);
INSERT INTO getput_menu_main (menu_main_id,menu_main_orderid,menu_main_desc,menu_main_controller,menu_main_action,menu_main_items,menu_main_addon,menu_main_type,menu_main_status) VALUES (8,5,"Editor manual","downloads","getgen/Editor.pdf",0,0,"get_emn",1);
INSERT INTO getput_menu_main (menu_main_id,menu_main_orderid,menu_main_desc,menu_main_controller,menu_main_action,menu_main_items,menu_main_addon,menu_main_type,menu_main_status) VALUES (9,9,"Help","suppdocs","help",0,0,"hlp_all",1);
INSERT INTO getput_menu_main (menu_main_id,menu_main_orderid,menu_main_desc,menu_main_controller,menu_main_action,menu_main_items,menu_main_addon,menu_main_type,menu_main_status) VALUES (10,12,"Collaboratori","menus","menuStatus",1,1,"add_on",1);
INSERT INTO getput_menu_main (menu_main_id,menu_main_orderid,menu_main_desc,menu_main_controller,menu_main_action,menu_main_items,menu_main_addon,menu_main_type,menu_main_status) VALUES (11,8,"Agenzie","supplinks","agenzie",0,1,"add_on",1);
INSERT INTO getput_menu_main (menu_main_id,menu_main_orderid,menu_main_desc,menu_main_controller,menu_main_action,menu_main_items,menu_main_addon,menu_main_type,menu_main_status) VALUES (12,13,"External","menus","menuStatus",1,1,"add_on",1);
INSERT INTO getput_menu_main (menu_main_id,menu_main_orderid,menu_main_desc,menu_main_controller,menu_main_action,menu_main_items,menu_main_addon,menu_main_type,menu_main_status) VALUES (13,7,"Invio cms","supplinks","sendcms",0,1,"add_on",1);
INSERT INTO getput_menu_main (menu_main_id,menu_main_orderid,menu_main_desc,menu_main_controller,menu_main_action,menu_main_items,menu_main_addon,menu_main_type,menu_main_status) VALUES (14,6,"Cms manual","downloads","getgen/ManualeCms.pdf",0,0,"get_cmn",1);

CREATE TABLE getput_menu_items
(
        menu_items_id                   int(11) AUTO_INCREMENT,
        menu_items_main_id              int(11) DEFAULT 0,
        menu_items_orderid              int(11) DEFAULT 0,
        menu_items_desc                 varchar(255) NOT NULL,
        menu_items_controller           varchar(255),
        menu_items_action               varchar(255),
        menu_items_status               tinyint,
        PRIMARY KEY(menu_items_id),
        UNIQUE KEY(menu_items_desc),
        FOREIGN KEY(menu_items_main_id) REFERENCES getput_menu_main(menu_main_id) ON DELETE CASCADE ON UPDATE CASCADE
)
TYPE=InnoDB;

INSERT INTO getput_menu_items (menu_items_id,menu_items_main_id,menu_items_orderid,menu_items_desc,menu_items_controller,menu_items_action,menu_items_status) VALUES (1,5,0,"Gestione utenti","admins","gestusers",1);
INSERT INTO getput_menu_items (menu_items_id,menu_items_main_id,menu_items_orderid,menu_items_desc,menu_items_controller,menu_items_action,menu_items_status) VALUES (2,5,2,"Lista utenti","admins","listusers",1);
INSERT INTO getput_menu_items (menu_items_id,menu_items_main_id,menu_items_orderid,menu_items_desc,menu_items_controller,menu_items_action,menu_items_status) VALUES (3,6,0,"Files prelevati","histories","listfileget",1);
INSERT INTO getput_menu_items (menu_items_id,menu_items_main_id,menu_items_orderid,menu_items_desc,menu_items_controller,menu_items_action,menu_items_status) VALUES (4,6,1,"Files inviati","histories","listfileput",1);
INSERT INTO getput_menu_items (menu_items_id,menu_items_main_id,menu_items_orderid,menu_items_desc,menu_items_controller,menu_items_action,menu_items_status) VALUES (5,6,2,"Connessioni","histories","connusers",1);
INSERT INTO getput_menu_items (menu_items_id,menu_items_main_id,menu_items_orderid,menu_items_desc,menu_items_controller,menu_items_action,menu_items_status) VALUES (6,10,0,"Gestione collab","gestcollabs","gestcollabs",1);
INSERT INTO getput_menu_items (menu_items_id,menu_items_main_id,menu_items_orderid,menu_items_desc,menu_items_controller,menu_items_action,menu_items_status) VALUES (7,10,1,"Contributi inviati","gestcollabs","listcontrput",1);
INSERT INTO getput_menu_items (menu_items_id,menu_items_main_id,menu_items_orderid,menu_items_desc,menu_items_controller,menu_items_action,menu_items_status) VALUES (8,10,2,"Grafico contr. inv.","gestcollabs","graphitemput",1);
INSERT INTO getput_menu_items (menu_items_id,menu_items_main_id,menu_items_orderid,menu_items_desc,menu_items_controller,menu_items_action,menu_items_status) VALUES (9,12,0,"Gestione utenti age.","gestexternal","gestusers",1);
INSERT INTO getput_menu_items (menu_items_id,menu_items_main_id,menu_items_orderid,menu_items_desc,menu_items_controller,menu_items_action,menu_items_status) VALUES (10,12,1,"Lista utenti age.","gestexternal","listusers",1);



CREATE TABLE getput_menu_addon
(
        menu_addon_id                   int(11) NOT NULL AUTO_INCREMENT,
        menu_addon_main_id              int(11) DEFAULT 0,
        menu_addon_user_id              int(11) NOT NULL,
	menu_addon_status               tinyint DEFAULT 1,
        PRIMARY KEY(menu_addon_id),
        KEY(menu_addon_main_id),
        KEY(menu_addon_user_id),
        FOREIGN KEY(menu_addon_user_id) REFERENCES getput_users(users_id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY(menu_addon_main_id) REFERENCES getput_menu_main(menu_main_id) ON DELETE CASCADE ON UPDATE CASCADE 
)
TYPE=InnoDB;

#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (1,11,1);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (2,11,2);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (3,11,3);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (4,11,4);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (5,11,8);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (6,11,9);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (7,11,12);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (8,11,14);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (9,11,15);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (10,11,16);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (11,11,24);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (12,11,27);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (13,11,28);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (14,11,30);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (15,11,31);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (16,11,32);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (17,11,37);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (18,11,43);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (19,11,46);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (20,11,47);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (21,11,51);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (22,11,53);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (23,11,55);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (24,11,57);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (25,11,60);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (26,11,62);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (27,11,65);
###INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (28,11,69);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (29,11,75);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (30,11,78);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (31,11,79);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (32,11,80);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (33,11,87);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (34,11,88);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (35,11,91);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (36,11,92);
###INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (37,11,93);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (38,11,96);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (39,11,97);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (40,11,99);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (41,11,107);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (42,11,108);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (43,11,109);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (44,11,110);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (45,11,112);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (46,11,114);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (47,11,115);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (48,11,116);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (49,11,117);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (50,11,118);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (51,11,119);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (52,11,120);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (53,11,122);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (54,11,123);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (55,11,124);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (56,11,125);
###INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (57,11,126);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (58,11,127);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (59,11,128);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (60,11,129);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (61,11,130);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (62,11,132);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (63,11,133);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (64,11,134);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (65,11,135);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (66,11,136);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (67,11,137);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (68,11,139);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (69,11,140);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (70,11,141);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (71,11,142);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (72,11,143);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (73,11,144);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (74,11,145);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (75,11,146);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (76,11,147);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (77,11,148);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (78,11,149);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (79,11,154);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (80,11,155);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (81,11,156);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (82,11,157);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (83,11,158);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (84,11,159);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (85,11,161);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (86,11,162);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (87,11,163);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (88,11,164);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (89,11,165);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (90,11,166);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (91,11,167);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (92,11,168);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (93,11,169);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (94,11,170);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (95,11,171);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (96,11,172);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (97,11,173);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (98,11,174);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (99,11,175);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (100,11,176);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (101,11,177);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (102,11,178);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (103,11,179);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (104,11,180);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (105,11,181);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (106,11,182);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (107,11,183);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (108,11,184);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (109,11,185);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (110,11,186);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (111,11,187);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (112,11,188);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (113,11,189);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (114,11,190);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (115,11,191);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (116,11,192);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (117,11,193);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (118,11,194);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (119,11,195);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (120,11,196);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (121,11,197);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (122,11,198);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (123,11,199);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (124,11,200);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (125,11,201);
###INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (126,11,202);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (127,11,203);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (128,11,204);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (129,11,205);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (130,11,206);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (131,11,207);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (132,11,208);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (133,11,209);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (134,11,210);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (135,11,211);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (136,11,212);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (137,11,213);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (138,11,215);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (139,11,216);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (140,11,217);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (141,11,218);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (142,11,219);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (143,11,220);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (144,11,221);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (145,11,222);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (146,11,223);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (147,11,224);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (148,11,225);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (149,11,226);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (150,11,227);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (151,11,228);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (152,11,229);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (153,11,230);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (154,11,231);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (155,11,234);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (156,11,235);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (157,11,1372);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (158,11,1380);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (159,11,1382);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (160,11,1383);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (161,11,1384);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (162,11,1400);
###INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (163,11,1401);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (164,11,1457);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (165,11,1511);
#INSERT INTO getput_menu_addon (menu_addon_id,menu_addon_main_id,menu_addon_user_id) VALUES (166,11,1512);


CREATE TABLE getput_ctrl_act_permit 
(
        ctrl_act_id                     int(11) NOT NULL AUTO_INCREMENT,
        ctrl_act_menu_id                int(11) DEFAULT 0,
        ctrl_act_desc                   varchar(255) NOT NULL,
        ctrl_act_controller             varchar(255),
        ctrl_act_action                 varchar(255),
        ctrl_act_type                   varchar(255),
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
