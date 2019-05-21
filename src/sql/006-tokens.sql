CREATE TABLE tokens (
    token VARCHAR(255) UNIQUE,
    login_name  VARCHAR(50),
    expiration TIMESTAMP
)