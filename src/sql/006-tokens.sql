CREATE TABLE tokens (
    token VARCHAR(255) UNIQUE,
    login_name  VARCHAR(50) NOT NULL,
    expiration TIMESTAMP NOT NULL
)