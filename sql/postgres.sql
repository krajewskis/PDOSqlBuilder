DROP TABLE IF EXISTS test;

CREATE TABLE test (
	id          SERIAL,
	code        VARCHAR(20)                NOT NULL UNIQUE,
	title       VARCHAR(255)               NOT NULL,
	description TEXT,
	status1      BOOLEAN DEFAULT FALSE     NOT NULL,
	status2      BOOLEAN DEFAULT TRUE      NOT NULL,
	created     TIMESTAMP(2) DEFAULT now() NOT NULL,
	updated     TIMESTAMP(2) DEFAULT now() NOT NULL
);

INSERT INTO test (code, title, description, status1, status2, created, updated)
VALUES
	('FIRST', 'First', 'descp 1', TRUE, FALSE, '2013-01-01', '2014-01-01'),
	('SECOND','SECOND', 'descp 2', TRUE, TRUE, now(), now()),
	('THIRD', 'THIRD', 'descp 3', FALSE, FALSE, '2014-12-31 13:45:32.44', '2014-12-31 23:59:59.99');
