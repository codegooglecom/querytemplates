# `varsToLoopFirst` #
[Wiki](http://code.google.com/p/querytemplates/w/list) > [Syntax](Syntax.md) > [varsTo](varsToSyntax.md) > [varsToLoopFirst](varsToLoopFirstMethodPHP.md)
### Parameters ###
  * **$varName** _String_
> > Variable which will be looped. Must contain $ at the beggining.
  * **$rowName** _String_
> > Name of variable being result of iteration.
  * **$indexName** _String_ = `null`
> > Optional. Use it when you want to have $varName's key available in the scope.


### Description ###
Wraps selected elements with executable code iterating $varName as $rowName.


Acts as varsToLoop(), but loops only first node from stack. Rest is removed  from the DOM.


Method DOES change selected nodes stack. Returned is first node.

---


## See also ##
  * [varsToLoop](varsToLoopMethodPHP.md)


### Comments allowed ###