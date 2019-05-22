# Settings

Settings for both CMS and themes are stored in table `settings`. Each settings has to be uniquely named and theme settings cannot start with `sloth_` prefix.

Columns in settings table are:
- settings_name
  - primary key
- display_name
- settings_value
- section_id
- settings_type