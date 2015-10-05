# `varsToLoopSeparate` #
[Wiki](http://code.google.com/p/querytemplates/w/list) > [Syntax](Syntax.md) > [varsTo](varsToSyntax.md) > [varsToLoopSeparate](varsToLoopSeparateMethodPHP.md)
### Parameters ###
  * **$varName** _String_
> > Variable which will be looped. Must contain $ at the beggining.
  * **$rowName** _String_
> > Name of variable being result of iteration.
  * **$indexName** _String_ = `null`
> > Optional. Use it when you want to have $varName's key available in the scope.


### Description ###
Wraps selected elements with executable code iterating $varName as $rowName.


Acts as varsToLoop(), but affects each selected element separately.


Method doesn't change selected nodes stack.

---


## See also ##
  * [varsToLoop](varsToLoopMethodPHP.md)


### Comments allowed ###