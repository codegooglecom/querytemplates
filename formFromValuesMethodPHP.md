# `formFromValues` #
[Wiki](http://code.google.com/p/querytemplates/w/list) > [Syntax](Syntax.md) > [formFrom](formFromSyntax.md) > [formFromValues](formFromValuesMethodPHP.md)
### Parameters ###
  * **$record** _Array_
> > TODO doc
  * **$structure** _Array_
> > Form structure information. This should be easily fetchable from ORM layer.  Possible types:
      * text (default)
      * password
      * hidden
      * checkbox
      * radio
      * textarea  Convention:
```
 'fieldName' => array(
   'fieldType', $fieldOptions
 )

```
> > Where $fieldOptions can be (`key => value` pairs):
      * label
      * id
      * multiple (only select)
      * values (only radio, MANDATORY)
      * value (only checkbox, optional)  There can be special field **`__form`**, which represents form element, as an array.  All values from it will be pushed as form attributes.  If you wrap fields' array within another array, it will represent **fieldsets**,  which value with index **`__label`** will be used as legend (optional).
  * **$errors** _Array_ = `null`
> > TODO doc
  * **$data** _Array_ = `null`
> > Additional data for fields. For now it's only used for populating select boxes.  Example:
```
 $defaultData = array(
     'select-field-optgroups' => array(
         array(    // 1st optgroup
             '__label' => 'optgroup 1 label',
             'group1_1' => 'group1_1 label',
             'group1_2' => 'group1_2 label',
         ),
         array(    // 2nd optgroup
             '__label' => 'optgroup 2 label',
             'group2_1' => 'group2_1 label',
             'group2_2' => 'group2_2 label',
         ),
         'bar' => 'Bar',    // no optgroup
     ),
 );

```

  * **$template** _Array|String_ = `null`
> > Input wrapper template. This template will be used for each field. Use array  to per field template, 'default' means default.  All types allowed in $structure can be used as per-type default template  when indexed like '$type' ex 'checkbox'.  To each input wrapper will be added a class which is field's type.  Example:
```
 $templates`['__checkbox']` = '
 <div class="input">
     <div>Checkbox field below</div>
   <label/>
   <input/>
 </div>';

```
> > Default template is:
```
 <div class="input">
   <label/>
   <input/>
   <ul class="errors">
     <li/>
   </ul>
 </div>

```

  * **$selectors** _Array_ = `null`
> > Array of selectors indexed by it's type. Allows to customize lookups inside  inputs wrapper. Possible values are:
      * error - selects field's error wrapper
        * dafault value is '.errors'
      * label - selects field's label node (can be div, span, etc)
        * default value is 'label:first'
        * use array to per field name selector, 'default' means default
      * input - selects field's input node: input, textarea or select
        * default value is 'input:first'
        * use array to per field name selector, 'default' means default
        * %t is replaced by field node type (use it with customized per field $template)
  * **$fieldCallback** _Array|String|Callback_ = `null`
> > Callback triggered after preparation of each field.


### Description ###
Method formFromVars acts as flexible form helper. It creates customized  pure-markup form without the need of suppling a line of markup.


Final form is available right after using this method.


Created form have following features:

  * shows data from record
  * shows errors
  * supports default values
  * supports radios and checkboxes
  * supports select elements with optgroups
  * supports select multiple
Created form can be customized using:

  * input wrapper template (per field name, per field type and default)
  * selectors (for input, label and errors)
  * callbacks (per field)
## Example ##
```
 $structure = array(
     '__form' => array('id' => 'myFormId'),
     array(
         '__label' => 'Fieldset 1 legend',
         'default-field' => array(    // 'text' is default
             'label' => 'default-field label',
             'id' => 'default-field-id',
         ),
         'text-field' => array('text',
             'label' => 'text-field label',
             'id' => 'text-field-id',
         ),
         'hidden-field' => 'hidden',
         'checkbox-field' => 'checkbox',
     ),
     array(
         '__label' => 'Fieldset 2 legend',
         'select-field' => array('select',
             'label' => 'select-field label',
         ),
         'radio-field' => array('radio',
             'values' => array('possibleValue1', 'possibleValue2')
         ),
         'textarea-field' => 'textarea',
     ),
 );
 $data = array(
     'select-field' => array(
         // no optgroup
         'bar1' => 'bar1 label',
         'bar2' => 'bar2 label',
         'bar3' => 'bar3 label',
     ),
 );
 $record = array(
   'text-field' => 'value from record',
 );
 $tempalte->
   formFromValues($record, $structure, null, $data)
 ;

```
### Result DOM tree ###
```
 form#myFormId
  - fieldset
  -  - input#myFormId_hidden-field[name="hidden-field"][value="new hidden-fiel"]
  -  - legend
  -  -  - Text:Fieldset 1 lege
  -  - div.input.text
  -  -  - label
  -  -  -  - Text:default-field l
  -  -  - input#default-field-id[name="default-field"]
  -  - div.input.text
  -  -  - label
  -  -  -  - Text:text-field labe
  -  -  - input#text-field-id[name="text-field"][value="new text-field "]
  -  -  - ul.errors
  -  -  -  - li
  -  -  -  -  - Text:text-field erro
  -  - div.input.checkbox
  -  -  - div
  -  -  -  - Text:Checkbox field
  -  -  - label
  -  -  -  - Text:Checkbox-field
  -  -  - input#myFormId_checkbox-field[name="checkbox-field"][value="1"][checked]
  - fieldset
  -  - legend
  -  -  - Text:Fieldset 2 lege
  -  - div.input.select
  -  -  - label
  -  -  -  - Text:select-field la
  -  -  - select[name="select-field"]
  -  -  -  - option[value="bar1"]
  -  -  -  -  - Text:bar1 label
  -  -  -  - option[value="bar2"]
  -  -  -  -  - Text:bar2 label
  -  -  -  - option[value="bar3"][selected]
  -  -  -  -  - Text:bar3 label
  -  - div.input.select
  -  -  - label
  -  -  -  - Text:select-field-op
  -  -  - select[name="select-field-optgroups-multiple"]
  -  -  -  - optgroup
  -  -  -  -  - option[value="group1_1"]
  -  -  -  -  -  - Text:group1_1 label
  -  -  -  -  - option[value="group1_2"]
  -  -  -  -  -  - Text:group1_2 label
  -  -  -  - optgroup
  -  -  -  -  - option[value="group2_1"][selected]
  -  -  -  -  -  - Text:group2_1 label
  -  -  -  -  - option[value="group2_2"]
  -  -  -  -  -  - Text:group2_2 label
  -  -  -  - option[value="bar"][selected]
  -  -  -  -  - Text:Bar
  -  -  - ul.errors
  -  -  -  - li
  -  -  -  -  - Text:error1
  -  -  -  - li
  -  -  -  -  - Text:error2
  -  - div.input.radio
  -  -  - label
  -  -  -  - Text:Radio-field
  -  -  - input[name="radio-field"][value="possibleValue1"]
  -  -  - input[name="radio-field"][value="possibleValue2"][checked]
  -  - div.input.textarea
  -  -  - label
  -  -  -  - Text:Textarea-field
  -  -  - textarea#myFormId_textarea-field

```

---


## See also ##
  * [formFromVars](formFromVarsMethodPHP.md)
  * [varsToForm](varsToFormMethodPHP.md)
  * [valuesToForm](valuesToFormMethodPHP.md)


### Comments allowed ###