CREATE TABLE settings (
    settings_name       VARCHAR(40) PRIMARY KEY,
    display_name        VARCHAR(100) NOT NULL,
    settings_value      VARCHAR(255) NOT NULL,
    section_id          VARCHAR(40) NOT NULL
);

ALTER TABLE settings ADD COLUMN setting_type VARCHAR(100)  NOT NULL DEFAULT "core";
ALTER TABLE settings ADD COLUMN section_name VARCHAR(60) NOT NULL;