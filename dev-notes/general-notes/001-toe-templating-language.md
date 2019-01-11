# Toe templating language
"Toe" for short

## Starting and closing tags

Toe template syntax starts with ```<#``` because working with *twig*, *jsp* and *ftl* I found a need to distinguish *toe* template from them. The ending sign is reverted starting sign ```#>```.

## Printing

There are two ways how to print a string.
* Long version: ```<# print "This will be printed" #>```
* Short version: ```<#= "This will be printed" #>```

When printing a variable:
* Long version: ```<# print variable #>```
* Short version: ```<#= variable #>```

## Conditions

Basic condition syntax starts is based on ```if``` from programming languages and its basic syntax is as follows:

```<# if condition: #>```

```<# endif #>```

There's also a possibility of ```else```:

```<# if condition: #>```

```<# else: #>```

```<# endif #>```

## Loops

*Toe*s at the moment have ```while``` and ```foreach``` loop. The first one:

```<# while condition: #>```

```<# endwhile #>```

And the second one:

```<# foreach item in items #>```

```<# endforeach #>```

## Importing

Importing is an important feature for every templating system. To import another template use:

```<# import template.toe #>``` or ```<# import folder/template.toe #>```

## Variables

Variables are defined by special character '#' and their name. An example would be: ```#variable```

Assiging a value to the variable looks like:
 
```#variable = 1```

Variables in Toe templating language don't have types.