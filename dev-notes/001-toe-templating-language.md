# Toe templating language
"Toe" for short

## Starting and closing tags

Toe template syntax starts with ```<#``` because working with *twig*, *jsp* and *ftl* I found a need to distinguish *toe* template from them. The ending sign is reverted starting sign ```#>```.

## Conditions

Basic condition syntax starts is based on ```if``` from programming languages and its basic syntax is as follows:

```<# if condition: #>```

```<# endif #>```

There's also a possibility of ```else```:

```<# if condition: #>```

```<# else: #>```

```<# endif #>```

## Loops

*Toe*s at the moment have only ```while``` type loop with syntax:

```<# while condition: #>```

```<# endwhile #>```