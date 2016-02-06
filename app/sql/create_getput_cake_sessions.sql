USE getput;

DROP TABLE IF EXISTS cake_sessions;

CREATE TABLE cake_sessions
(
        id              varchar(255) NOT NULL DEFAULT '',
        data            mediumtext,
        expires         int(11) DEFAULT NULL,
        PRIMARY KEY(id)
)
TYPE=InnoDB;
