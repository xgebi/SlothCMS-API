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
* current theme

* current theme name

Example:

```JSON
{
  "sitename": "SlothCMS Showcase",
  "subtitle": "If use SlothCMS, you know what you're doing, I hope",
  "timezone": "Europe/Berlin",
  "timeDate": "n/d/Y G:i",
  "mainLanguage": "en",
  "languages": ["de", "et"],
  "currentTheme": "red-star"
}
```

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

### Meta information

SlothCMS needs to keep information about the posts. It keeps this information in ```sloth-content/content.json```.

```JSON
{
  "drafts": [
    {
      "slug": "String"
    }
  ],
  "scheduled": [
    {
      "slug": "String",
      "publishDate": "Long(miliseconds)"
    }
  ],
  "published": [
    {
      "slug": "String",
      "inUpdate": "Boolean",
      "publishDate": "Long(miliseconds)",
      "postType": "String"
    }
  ]
}
```

### Text

Since SlothCMS utilizes generated files which are served to visitors, there's little to no need to store content in JSON files in a place which is accessible through web server. Therefore **all text content** shall reside in a director ```content``` which will be in the same directory as other configuration files.

Every JSON file has following set of fields:
* uuid (optional)
* slug
* post type
* array of language objects
  * language shortcut
  * primary language indicator
  * array of fields
    * field name
    * field content

```JSON
{
  "uuid": "String",
  "slug": "String",
  "postType": "String",
  "post": [
    {
      "language": "String",
      "primaryLanguage": "Boolean",
      "state": "String(published|draft|scheduled|publishing|updating)",
      "publishedDate": "String(ISO format of date)",
      "fields": [
        {
          "name": "String",
          "content": "String"
        }
      ]
    }
  ]
}
```

### Images and other data

Images and other file do need to be accessible for visitors of the web site and therefore these files shall reside in ```sloth-content``` directory alongside ```sloth-admin``` and ```sloth-admin-api```. All three directory names are reserved in SlothCMS.