# Theme Structure

Every theme has to have a meta information file ```info.json```.

## Meta information file

```info.json``` is a file where all important information about theme is stored. The following items are considered as important:
* name of the theme (String)
* display name of the theme (String)
* version (String)
* licence (String)
* Toe template files (Object)
* CSS files (Object)
* JavaScript files (Object)
* regions (Array of Strings)

### Versioning

The only rule around versioning is that the new version has to be bigger than the previous one. Basically if you want your final version number to be 0, you need to start with a negative number.

### Toe template files

```JSON
{
  "templates": {
    "folder": "templates",
    "defaultTemplate": "index.toe",
    "regions": [
      "header",
      "body",
      "footer"
    ],
    "specialTemplates": {
      "postTypeName": "page",
      "template": "page.toe",
      "regions": ["sidebar"]
    }
  }
}
```

### Styles and Script files

Styles and Script files both contain name of the folder where they are located and list of styles in the order in which they will load.

```JSON
"styles" : {
  "folder": "css", // this is a folder on the same level as info.json
  "styles": ["styles.css"] // file inside the css folder; css/styles.css
}
```

For Scripts file the it analogous.