CREATE TABLE post_types (
    post_type_name      VARCHAR(50) PRIMARY KEY,
    display_name        VARCHAR(70) NOT NULL,
    categories_allowed  BOOLEAN DEFAULT false,
    tags_allowed        BOOLEAN DEFAULT false,
    comments_allowed    BOOLEAN DEFAULT false
);