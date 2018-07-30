# Data Management

All data by default is stored in a parent folder of slothcms which shall not be accessible through web server, only through filesystem.

## Configuration management

The main configuration file is called ```sloth.conf.json``` and contains fields:
* sitename
* subtitle/motto
* timezone
* time and date format
* main language
* secondary languages

## User management

The user data is stored in file ```sloth.users.json``` and contains fields:
* username
* password
* display name
* email

There are only four fields at the moment and due to GDPR there are no plans at the moment to expand it. For the same reason term "display name" instead of "full name" will be used throughout SlothCMS.

## Content Type management

The content types date is stored in file ```sloth.content.types.json``` and contains fields:
* content type slug
* content type name
* supported languages
* if tags are allowed
* if categories are allowed
* if post type has archive
* if RSS feed should be generated
* if the posts of the post type can have children 
* optional fields
  * name of the field
  * display name of the field
  * type of the field

## Content Management


