# Theme Structure

Every theme has to have a meta information file ```info.json```.

## Meta information file

```info.json``` is a file where all important information about theme is stored. The following items are considered as important:
* name of the theme (String)
* display name of the theme (String)
* version (String)
* licence (String)
* Toe templates folder (String)
* CSS folder (String)
* JavaScript folder (String)
* regions (Array of Strings)

### Versioning

The only rule around versioning is that the new version has to be bigger than the previous one. Basically if you want your final version number to be 0, you need to start with a negative number.