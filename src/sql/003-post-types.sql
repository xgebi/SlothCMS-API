CREATE TABLE post_types (
    post_type_name      VARCHAR(50) PRIMARY KEY,
    display_name        VARCHAR(70),
    categories_allowed  BOOLEAN,
    tags_allowed        BOOLEAN,
    comments_allowed    BOOLEAN
);