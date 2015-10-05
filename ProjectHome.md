# `QueryTemplates` #
**DOM and CSS driven template engine**

PHP based templating engine converting **[pure markup sources](http://code.google.com/p/querytemplates/wiki/TemplateSources) (HTML, XML, XHTML)** into native **("_compiled_") PHP and `JavaScript` template files**, while source files remains untouched.

Library uses popular web 2.0 pattern _load-traverse-modify_ thou **[jQuery](http://jquery.com)-like chainable API** (using [phpQuery](http://code.google.com/p/phpquery/)) and provides **several rapid [data injection methods](http://code.google.com/p/querytemplates/wiki/DataInjectionMethods)**.

### [Download](http://code.google.com/p/querytemplates/downloads/list) ###
  * [QueryTemplates 1.0 Beta4 for PHP](http://querytemplates.googlecode.com/files/querytemplates-1.0-beta4.zip)
  * [QueryTemplates Light 1.0 Beta 2 for JavaScript](http://querytemplates.googlecode.com/files/querytemplates-js-1.0-beta2.zip) (**[live demo](http://sandbox.meta20.net/querytemplates-js/)**)

### [News](http://querytemplates.wordpress.com/) ###
  * [QuertyTemplates 1.0 Beta3 released](http://querytemplates.wordpress.com/2009/02/22/quertytemplates-10-beta3-released/)
  * [First public release: QueryTemplates 1.0 Beta1](http://querytemplates.wordpress.com/2008/12/03/first-public-release-querytemplates-10-beta1/)

# Getting Started #
  * **[Syntax reference](Syntax.md)** Extensive syntax reference with 6-part example for each method.
  * **[Examples bundle](Examples.md)** Tutorial-style examples with explanation in comments.
  * **[Blog implementation](BlogImplementation.md)** Working blog application based on [CakePHP framework](http://www.cakephp.org/) and `QueryTemplates` 1.0 Beta2.

# Features #
  * **True markup and logic separation** Not like most MVC frameworks and Smarty claims. Markup separation to pure HTML file. No additional syntax.
  * **Loosely coupled** CSS selectors, callbacks and [events](http://tobiasz123.wordpress.com/2009/01/25/events-in-css-selector-driven-markup-templates-make-them-highly-reusable/) allows you to attach to specific DOM parts from the outside.
  * **Portable** Multi-language support for final templates. PHP and `JavaScript` [as for today](http://code.google.com/p/querytemplates/issues/detail?id=4&can=1).
  * **Compiled** Creates plain vanilla PHP and JS, standalone files, exacutable anywhere without any library.
  * **Maintainable**  Sources editable in any HTML editor. No formula change needed for layout change. See next features for more examples.
  * **Rapid** For example you can write n lines (3, 300, 3000...) with 1 line when inserting row containing n fields into document with proper class names structure.
  * **Fast as possible** As templates are compiled into native code, you can execute them with maximum speed of environment.
  * **Client friendly** Show actual templates (working files) to the client, full of "lorem ipsum" dummy content, looking just like final page.
  * **Designer friendly** Designer only creates mentioned before "lorem ipsum" templates. Just HTML and CSS. No new language.
  * **Workflow friendly** Seamless work of designer and developer (in same time), separate files (no version control problems), cache autorefresh (for sources and formula), HTTP sources supported.
  * **Integration-friendly** Compiled templates can be used with any MVC framework which can execute PHP code.
  * **Reusable** Use same template formulas to produce client-side and server-side templates. Use same DOM part in many templates or create one template from many different files.
  * **Scalable** Events support, service-friendly, 2-phrase process, XML support with namespaces.
  * **Flat learning curve** You only need to know CSS, jQuery, HTML and about ~10 types of `QueryTemplates` methods. Most of it you probably already know. NO need to directly manipulate the DOM.
  * **Self-describing API** Most of main methods follow self-describing, easy to remember convention.

## [Syntax](Syntax.md) ##
`QueryTemplates` introduces following method types to jQuery syntax:
  * ### [varPrint](varPrintSyntax.md) ###
  * ### [varsTo](varsToSyntax.md) ###
  * ### [valuesTo](valuesToSyntax.md) ###
  * ### [codeTo](codeToSyntax.md) ###
  * ### [ToStack](ToStackSyntax.md) ###
  * ### [ToSelector](ToSelectorSyntax.md) ###
  * ### [ToLoop](ToLoopSyntax.md) ###
  * ### [if](ifSyntax.md) ###
  * ### [else](elseSyntax.md) ###
  * ### [ToForm](ToFormSyntax.md) ###
  * ### [formFrom](formFromSyntax.md) ###
  * ### [varsFrom](varsFromSyntax.md) ###

## Documentation ##
  * [Syntax reference](Syntax.md)
  * [Manual](Manual.md) (work in progress)
  * [API reference](http://meta20.net/querytemplates-api/)
  * phpQuery
    * [phpQuery Manual](http://code.google.com/p/phpquery/wiki/Manual)
    * [phpQuery API reference](http://meta20.net/phpquery-api/)
  * [Google Group](http://groups.google.com/group/querytemplates)

## Wiki ##
  * [Getting Started](GettingStarted.md)
  * [Examples](Examples.md)
  * [Blog Implementation](BlogImplementation.md)
  * [Pure HTML Templates Theory](PureHTMLTemplatesTheory.md)
  * [Dependencies](Dependencies.md)
  * [Manual](Manual.md) (work in progress)
    * Preparing environment
    * [Template Structure](TemplateStructure.md)
    * [Template Sources](TemplateSources.md)
    * [Data Injection Methods](DataInjectionMethods.md)
    * Code Injection Methods
    * Other Methods
    * Final Template
    * Supported Languages
    * jQuery API extensions
    * [Events](Events.md)
    * [Integration](Integration.md)
    * Template side includes
    * [Extending QueryTemplates](ExtendingQueryTemplates.md)
    * [Debugging](Debugging.md)
  * Plugins
    * [CakeForms](CakeForms.md)

# Example #

**Instead of writing this way in PHP** ([Smarty example](http://www.smarty.net/sampleapp/sampleapp_p5.php))
```
{if $error ne ""}
  <tr>
    <td bgcolor="yellow" colspan="2">
      {if $error eq "name_empty"}You must supply a name.
      {elseif $error eq "comment_empty"} You must supply a comment.
      {/if}
    </td>
  </tr>
{/if}
```

**Instead of writing in same-typeof-way in `JavaScript`** ([micro-templating by John Resig](http://ejohn.org/blog/javascript-micro-templating/))
```
<script type="text/html" id="user_tmpl">
  <% for ( var i = 0; i < users.length; i++ ) { %>
    <li><a href="<%=users[i].url%>"><%=users[i].name%></a></li>
  <% } %>
</script>
```
**You can just get pure _lorem ipsum_ template from designer**
```
<div>
  <div class='my-div'>
    <ul>
      <li>
        <span class='fieldFoo'>lorem ipsum</span> 
        <span class='fieldBar'>lorem ipsum</span> 
        <span class='field3'>lorem ipsum</span> 
        <span class='field4'>lorem ipsum</span> 
        <span class='long-name-field5'>lorem ipsum</span> 
      </li>
      <li>lorem ipsum 2</li>
    </ul>
  </div>
</div>
```
**And write down all logic and [data](http://code.google.com/p/querytemplates/wiki/DataInjectionMethods) injections in reusable chain**
```
template()->parse('input.html')->
  find('.my-div')->
    ifVar('showMyDiv')->
    find('ul > li')->
      varsToLoopFirst('data', 'row')->
        // line below will rapidly populate template with data from $row
        varsToSelector('row', $rowFields)
;
```
**This will create native ("_compiled_") language templates**. Native means using only standard language base. **No external library is needed to execute them**. This also includes `QueryTemplates`.

**PHP result of above chain**
```
<div>
  <?php  if (isset(showMyDiv) && showMyDiv) {  ?><div class="my-div">
    <ul>
<?php  if (isset($data) && (is_array($data) || is_object($data))) { foreach($data as $row):  ?><li>
        <span class="fieldFoo"><?php  if (isset($row['fieldFoo'])) print $row['fieldFoo'];
else if (isset($row->{'fieldFoo'})) print $row->{'fieldFoo'};  ?></span> 
        <span class="fieldBar"><?php  if (isset($row['fieldBar'])) print $row['fieldBar'];
else if (isset($row->{'fieldBar'})) print $row->{'fieldBar'};  ?></span> 
        <span class="field3"><?php  if (isset($row['field3'])) print $row['field3'];
else if (isset($row->{'field3'})) print $row->{'field3'};  ?></span> 
        <span class="field4"><?php  if (isset($row['field4'])) print $row['field4'];
else if (isset($row->{'field4'})) print $row->{'field4'};  ?></span> 
        <span class="long-name-field5"><?php  if (isset($row['long-name-field5'])) print $row['long-name-field5'];
else if (isset($row->{'long-name-field5'})) print $row->{'long-name-field5'};  ?></span> 
      </li>
<?php  endforeach; }  ?>
      
    </ul>
</div>
<?php  }  ?>
</div>
```
**For better reading experience, a tree representation**
```
div
 - PHP
 - div.my-div
 -  - ul
 -  -  - PHP
 -  -  - li
 -  -  -  - span.fieldFoo
 -  -  -  -  - PHP
 -  -  -  - span.fieldBar
 -  -  -  -  - PHP
 -  -  -  - span.field3
 -  -  -  -  - PHP
 -  -  -  - span.field4
 -  -  -  -  - PHP
 -  -  -  - span.long-name-field5
 -  -  -  -  - PHP
 -  -  - PHP
 - PHP
```
**From the same chain, a `JavaScript` template**
```
function templateoutput(__data) {
	if (typeof __data != 'undefined')
		for (__dataRow in __data)
			eval('var '+__dataRow+' = __data[__dataRow]');
	var __template = '';
	var print = function(value) {
		__template += value;
	}
	__template += '<div>\


  ';
 if (typeof showMyDiv != undefined && showMyDiv) { ;
	__template += '<div class="my-div">\
    <ul>\
';
 for (__key50ad3 in data) {
		var row = data[__key50ad3]; 
		if (row instanceof Function)
			continue; ;
	__template += '<li>\
        <span class="fieldFoo">';
 print(row['fieldFoo']); ;
	__template += '</span> \
        <span class="fieldBar">';
 print(row['fieldBar']); ;
	__template += '</span> \
        <span class="field3">';
 print(row['field3']); ;
	__template += '</span> \
        <span class="field4">';
 print(row['field4']); ;
	__template += '</span> \
        <span class="long-name-field5">';
 print(row['long-name-field5']); ;
	__template += '</span> \
      </li>\
';
 } 
	__template += '\
      \
    </ul>\
</div>\
';
 } 
	__template += '\
</div>';

	return __template;
}
```

**Read more examples on [Examples bundle page](Examples.md) or directly on [Syntax reference pages](Syntax.md).**


---


## Source-oriented API diagram ##
<img src='http://meta20.net/images/api-diagram.png' alt='API diagram' />

Diagram covers following classes (linked with API reference)
  * [QueryTemplatesTemplate](http://meta20.net/querytemplates-api/QueryTemplates/QueryTemplatesTemplate.html)
  * [QueryTemplatesSourceQuery](http://meta20.net/querytemplates-api/QueryTemplates/QueryTemplatesSourceQuery.html)
  * [QueryTemplatesParse](http://meta20.net/querytemplates-api/QueryTemplates/QueryTemplatesParse.html)
  * [QueryTemplatesSource](http://meta20.net/querytemplates-api/QueryTemplates/QueryTemplatesSource.html)