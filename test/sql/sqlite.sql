DROP TABLE IF EXISTS test;

CREATE TABLE test (
  id          INTEGER PRIMARY KEY NOT NULL,
  code        TEXT                NOT NULL,
  title       TEXT                NOT NULL,
  description TEXT,
  status1     INTEGER             NOT NULL,
  status2     INTEGER             NOT NULL,
  created     TEXT                NOT NULL,
  updated     TEXT                NOT NULL
);
CREATE UNIQUE INDEX test_code_ukey ON test (code);

INSERT INTO test (code, title, description, status1, status2, created, updated)
VALUES ('FIRST', 'First', 'descp 1', 1, 0, '2013-01-01 00:00:00.00', '2014-01-01 00:00:00.00');

INSERT INTO test (code, title, description, status1, status2, created, updated)
VALUES ('SECOND', 'SECOND', 'descp 2', 1, 1, datetime(), datetime());

INSERT INTO test (code, title, description, status1, status2, created, updated)
VALUES ('THIRD', 'THIRD', 'descp 3', 0, 0, '2014-12-31 13:45:32.44', '2014-12-31 23:59:59.99');


