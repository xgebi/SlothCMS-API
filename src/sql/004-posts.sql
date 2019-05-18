CREATE TABLE posts (
    slug                VARCHAR(255) PRIMARY KEY,
    name                VARCHAR(300),
    comments_allowed    BOOLEAN,
    tags                text[],
    categories          text[],
    content             text
);