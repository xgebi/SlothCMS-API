CREATE TABLE sloth_users (
    id              BIGINT  PRIMARY KEY,
    login_name      VARCHAR(50) UNIQUE,
    display_name    VARCHAR(100),
    password        VARCHAR(500),
    email           VARCHAR(350)
);