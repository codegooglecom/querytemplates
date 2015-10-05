# `varsToSelector` #
[Wiki](http://code.google.com/p/querytemplates/w/list) > [Syntax](Syntax.md) > [varsTo](varsToSyntax.md) > [varsToSelector](varsToSelectorMethodPHP.md)
### Parameters ###
  * **$varName** _String_
> > Variable avaible in scope of type Array or Object.  $varName should NOT start with $.
  * **$varFields** _Array|Object_
> > Variable value with all fields (keys) OR array of variable fields (keys).
  * **$selectorPattern** _String_ = `'.%k'`
> > Defines pattern matching target nodes. %k represents key.  Defaults to ".%k", which matches nodes with class name equivalent to  variables key (field).  For example, to restrict match to nodes with additional class "foo" change  $selectorPattern to ".foo.%k"
  * **$skipFields** _Array_ = `null`
> > Array of keys from $varValue which should be skipped.
  * **$fieldCallback** _Callback|string_ = `null`
> > Callback triggered after every insertion. Three parameters are passed to  this callback:
      * $node phpQueryObject
      * $field String
      * $target String|array


### Description ###
Injects executable code printing variable's fields inside nodes matched by  selector. Method uses actually matched nodes as root for the query.


Method doesn't change selected elements stack.


## Example ##


### Markup ###
```
 <p class='field1'>lorem ipsum</p>
 <p class='field2'>lorem ipsum</p>

```
### Data ###
```
 $foo = new stdClass();
 $foo->field1 = 'foo';
 $foo->field2 = 'bar';

```
### `QueryTemplates` formula ###
```
 $template->
     varsToSelector('foo', $foo)
 ;

```
### Template ###
```
 <p class="field1"><?php  if (isset($foo['field1'])) print $foo['field1'];
 else if (isset($foo->{'field1'})) print $foo->{'field1'};  ?></p>
 <p class="field2"><?php  if (isset($foo['field2'])) print $foo['field2'];
 else if (isset($foo->{'field2'})) print $foo->{'field2'};  ?></p>

```
### Template tree before ###
```
 p.field1
  - Text:lorem ipsum
 p.field2
  - Text:lorem ipsum

```
### Template tree after ###
```
 p.field1
  - PHP
 p.field2
  - PHP

```

---


## See also ##
  * [varsToStack](varsToStackMethodPHP.md)
  * [varsToForm](varsToFormMethodPHP.md)


### Comments allowed ###