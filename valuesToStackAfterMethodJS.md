# `valuesToSelectorAfter` #
[Wiki](http://code.google.com/p/querytemplates/w/list) > [Syntax](Syntax.md) > [valuesToStack](valuesToStackSyntax.md) > [MethodJS ]
### Parameters ###
  * **values** _Array|Object_
> > Associative array or Object containing markup, text or instance of Callback.
  * **skipFields** _Array_ = `null`
> > Array of fields from values which should be skipped.
  * **fieldCallback** _Function_ = `null`
> > Callback triggered after every insertion. Two parameters are passed to this callback:
      * field String
      * target String|Array
> > Context (this) for the callback is node matched for a field.

### Description ###
Injects markup from values' content (rows or attributes)  actually matched nodes.

## Example ##

### Markup ###
```
<node1>
	<node2></node2>
</node1>
<node1>
	<node2></node2>
</node1>
```

### Data ###
```
var values = ['<foo/>', '<bar/>'];
```

### `QueryTemplates` formula in JavaScript ###
```
$template.find('node1')
	.valuesToStackAfter(values)
```

### Template ###
```
<node1><node2></node2></node1><foo></foo><node1><node2></node2></node1><bar></bar>
```

### Template tree before ###
```
node1
 - node2
node1
 - node2
```

### Template tree after ###
```
node1
 - node2
foo
node1
 - node2
bar
```


---

See:
  * [valuesToSelector](valuesToStackMethodJS.md)
  * [valuesToForm](valuesToFormMethodJS.md)

### Comments allowed ###