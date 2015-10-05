Methods listed below are intended to **inject data** (from DB, localization strings, etc) into template's structure. You can read more about types of data **sources** and **targets** on [Getting Started](GettingStarted.md) page.

## Example of dynamic data injection ##
### Markup source ###
```
<p class='field1'>lorem ipsum</p>
<p class='field2'>lorem ipsum</p>
```
### Dynamic data ###
```
$foo = array(
  'field1' => 'foo',
  'field2' => 'bar'
);
```
### Code ###
```
$template->varsToSelector('foo', $foo);
```
### Result ###
```
<p class='field1'><?php print $foo['field1'] ?></p>
<p class='field2'><?php print $foo['field2'] ?></p>
```

## Data insertion methods ##
  * ### [varsTo - inserting dynamic data](varsToSyntax.md) ###
  * ### [valuesTo - inserting static data](valuesToSyntax.md) ###