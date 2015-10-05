# `codeToSelectorPrepend` #
[Wiki](http://code.google.com/p/querytemplates/w/list) > [Syntax](Syntax.md) > [codeTo](codeToSyntax.md) > [codeToSelectorPrepend](codeToSelectorPrependMethodPHP.md)
### Parameters ###
  * **$codeArray** _String_
> > Array of raw code, where key is the field.
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
Injects raw executable code at the beggining of nodes matched by selector.


Method uses actually matched nodes as root for the query.


Method doesn't change selected elements stack.


## Example ##


### Markup ###
```
 <p class='field1'>lorem ipsum</p>
 <p class='field2'>lorem ipsum</p>

```
### Data ###
```
 $code = array(
     'field1' => 'print "abba";',
     'field2' => 'foreach(array(1, 2, 3) as $i) print $i'
 );

```
### `QueryTemplates` formula ###
```
 $template->
     codeToSelectorPrepend($code)
 ;

```
### Template ###
```
 <p class="field1"><?php  print "abba";  ?>lorem ipsum</p>
 <p class="field2"><?php  foreach(array(1, 2, 3) as $i) print $i  ?>lorem ipsum</p>

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
  - Text:lorem ipsum
 p.field2
  - PHP
  - Text:lorem ipsum

```

---


## See also ##
  * [varsToStack](varsToStackMethodPHP.md)


### Comments allowed ###