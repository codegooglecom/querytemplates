# `valuesToSelectorAppend` #
[Wiki](http://code.google.com/p/querytemplates/w/list) > [Syntax](Syntax.md) > [valuesTo](valuesToSyntax.md) > [valuesToSelectorAppend](valuesToSelectorAppendMethodPHP.md)
### Parameters ###
  * **$values** _Array|Object_
> > Associative array or Object containing markup, text or instance of Callback.
  * **$selectorPattern** _String_ = `'.%k'`
> > Defines pattern matching target nodes. %k represents key.  Defaults to ".%k", which matches nodes with class name equivalent to  data source key.  For example, to restrict match to nodes with additional class "foo" change  $selectorPattern to ".foo.%k"
  * **$skipFields** _Array_ = `null`
> > Array of fields from $values which should be skipped.
  * **$fieldCallback** _Callback|string_ = `null`
> > Callback triggered after every insertion. Three parameters are passed to  this callback:
      * $node phpQueryObject
      * $field String
      * $target String|array


### Description ###
Injects markup from $values' content (rows or attributes) at the end of  nodes matched by selector. Method uses actually matched nodes as root  for the query.


Method doesn't change selected elements stack.


## Example ##


### Markup ###
```
 <p class='field1'>lorem ipsum</p>
 <p class='field2'>lorem ipsum</p>

```
### Data ###
```
 $values = array(
     'field1' => '<foo/>',
     'field2' => '<bar/>'
 );

```
### `QueryTemplates` formula ###
```
 $template->
     valuesToSelectorAppend($values)
 ;

```
### Template ###
```
 <p class="field1">lorem ipsum<foo></foo></p>
 <p class="field2">lorem ipsum<bar></bar></p>

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
  - Text:lorem ipsum
  - foo
 p.field2
  - Text:lorem ipsum
  - bar

```

---


## See also ##
  * [valuesToStack](valuesToStackMethodPHP.md)
  * [valuesToForm](valuesToFormMethodPHP.md)


### Comments allowed ###