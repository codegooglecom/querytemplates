# `valuesToSelectorAttr` #
[Wiki](http://code.google.com/p/querytemplates/w/list) > [Syntax](Syntax.md) > [valuesToSelector](valuesToSelectorSyntax.md) > [valuesToSelectorAttrMethodJS ]
### Parameters ###
  * **values** _Array|Object_
> > Associative array or Object containing markup, text or instance of Callback.
  * **selectorPattern** _String_ = `'.%k'`
> > Defines pattern matching target nodes. %k represents key.  Defaults to ".%k", which matches nodes with class name equivalent to  data source key.  For example, to restrict match to nodes with additional class "foo" change  selectorPattern to ".foo.%k"
  * **skipFields** _Array_ = `null`
> > Array of fields from values which should be skipped.
  * **fieldCallback** _Function_ = `null`
> > Callback triggered after every insertion. Two parameters are passed to this callback:
      * field String
      * target String|array
> > Context (this) for the callback is node matched for a field.

### Description ###
Injects markup from values' content (rows or attributes)  nodes matched by selector. Method uses actually matched nodes as root for the query.

## Example ##

### Markup ###
```
<p class='field1'>lorem ipsum</p>
<p class='field2'>lorem ipsum</p>
```

### Data ###
```
var values = {
	'field1' => '<foo/>',
	'field2' => '<bar/>',
};
```

### `QueryTemplates` formula in JavaScript ###
```
$template
	.valuesToSelectorAttr(values)
```

### Template ###
```
<p class="field1" rel="&lt;foo/&gt;">lorem ipsum</p>
<p class="field2" rel="&lt;bar/&gt;">lorem ipsum</p>
```

### Template tree before ###
```
p.field1
 - Text:lorem ipsum
p.field2
 - Text:lorem ipsum
```

### Template tree after ###
```
p.field1
 - Text:lorem ipsum
p.field2
 - Text:lorem ipsum
```


---

See:
  * [valuesToStack](valuesToStackMethodJS.md)
  * [valuesToForm](valuesToFormMethodJS.md)

### Comments allowed ###