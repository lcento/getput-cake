USE getput;

DROP TABLE IF EXISTS getput_menu_items;

CREATE TABLE getput_menu_items
(
        menu_items_id               	int(11) AUTO_INCREMENT,
        menu_items_main_id              int(11) DEFAULT 0,
	menu_items_orderid              int(11) DEFAULT 0,
        menu_items_desc                	varchar(255) NOT NULL,
        menu_items_controller           varchar(255),
        menu_items_action               varchar(255),
	menu_items_status		tinyint,
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
