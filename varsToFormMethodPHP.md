# `varsToForm` #
[Wiki](http://code.google.com/p/querytemplates/w/list) > [Syntax](Syntax.md) > [varsTo](varsToSyntax.md) > [varsToForm](varsToFormMethodPHP.md)
### Parameters ###
  * **$varName** _String_
> > Variable avaible in scope of type Array or Object.  $varName should NOT start with $.
  * **$varFields** _Array|Object_

  * **$selectorPattern** _String_ = `"[name*='%k']"`
> > Defines pattern matching form fields.  Defaults to "`[name*='%k']`", which matches fields containing variable's key in  their names. For example, to match only names starting with "foo`[bar]`" change  $selectorPattern to "`[name^='foo[bar]`']`[name*='%k']`"


### Description ###
Injects executable code which toggles form fields values and selection  states according to value of variable $varName.


This includes:

  * `input[type=radio][checked]`
  * `input[type=checkbox][checked]`
  * `select > option[selected]`
  * `input[value]`
  * `textarea`
Inputs are selected according to $selectorPattern, where %k represents  variable's key.


## Example ##


### Markup ###
```
 <form>
   <input name='input-example'>
   <input name='array[array-example]'>
   <textarea name='textarea-example'></textarea>
   <select name='select-example'>
     <option value='first' selected='selected'></option>
   </select>
   <input type='radio' name='radio-example' value='foo'>
   <input type='checkbox' name='checkbox-example' value='foo'>
 </form>

```
### Data ###
```
 $data = array(
   'input-example' => 'foo',
   'array-example' => 'foo',
   'textarea-example' => 'foo',
   'select-example' => 'foo',
   'radio-example' => 'foo',
   'checkbox-example' => 'foo',
 );

```
### `QueryTemplates` formula ###
```
 $template->
     varsToForm('data', $data)
 ;

```
### Template ###
```
 <form>
   <input name="input-example" value="<?php  if (isset($data['input-example'])) print $data['input-example'];
 else if (isset($data->{'input-example'})) print $data->{'input-example'};  ?>"><input name="array[array-example]" value="<?php  if (isset($data['array-example'])) print $data['array-example'];
 else if (isset($data->{'array-example'})) print $data->{'array-example'};  ?>"><textarea name="textarea-example"><?php  if (isset($data['textarea-example'])) print $data['textarea-example'];
 else if (isset($data->{'textarea-example'})) print $data->{'textarea-example'};  ?></textarea><select name="select-example"><?php  if ((isset($data['select-example']) && $data['select-example'] == 'first')
     || (isset($data->{'select-example'}) && $data->{'select-example'} == 'first')) {  ?><option value="first" selected></option>
 <?php  }    else {  ?><option value="first"></option>
 <?php  }  ?></select><?php  if ((isset($data['radio-example']) && $data['radio-example'] == 'foo')
     || (isset($data->{'radio-example'}) && $data->{'radio-example'} == 'foo')) {  ?><input type="radio" name="radio-example" value="foo" checked><?php  }    else {  ?><input type="radio" name="radio-example" value="foo"><?php  }    if ((isset($data['checkbox-example']) && $data['checkbox-example'] == 'foo')
     || (isset($data->{'checkbox-example'}) && $data->{'checkbox-example'} == 'foo')) {  ?><input type="checkbox" name="checkbox-example" value="foo" checked><?php  }    else {  ?><input type="checkbox" name="checkbox-example" value="foo"><?php  }  ?>
 </form>

```
### Template tree before ###
```
 form
  - input[name="input-example"]
  - input[name="array[array-example]"]
  - textarea[name="textarea-example"]
  - select[name="select-example"]
  -  - option[value="first"][selected]
  - input[name="radio-example"][value="foo"]
  - input[name="checkbox-example"][value="foo"]

```
### Template tree after ###
```
 form
  - input[name="input-example"][value=PHP]
  - input[name="array[array-example]"][value=PHP]
  - textarea[name="textarea-example"]
  -  - PHP
  - select[name="select-example"]
  -  - PHP
  -  - option[value="first"][selected]
  -  - PHP
  -  - PHP
  -  - option[value="first"]
  -  - PHP
  - PHP
  - input[name="radio-example"][value="foo"][checked]
  - PHP
  - PHP
  - input[name="radio-example"][value="foo"]
  - PHP
  - PHP
  - input[name="checkbox-example"][value="foo"][checked]
  - PHP
  - PHP
  - input[name="checkbox-example"][value="foo"]
  - PHP

```

---


## See also ##
  * [valuesToForm](valuesToFormMethodPHP.md)
  * [formFromVars](formFromVarsMethodPHP.md)


### Comments allowed ###