# `valuesToLoop` #
[Wiki](http://code.google.com/p/querytemplates/w/list) > [Syntax](Syntax.md) > [valuesTo](valuesToSyntax.md) > [valuesToLoop](valuesToLoopMethodJS.md)
### Parameters ###
  * **values** _Array|Object_
> > Associative array or Object.
  * **rowCallback** _Function_
> > Callback triggered for every inserted row. Should support following  parameters:
      * dataRow mixed
      * dataIndex mixed

> Callback is triggered in context (this variable) of looped nodes.
  * **targetNodeSelector** _String|jQuery_ = `null`
> > Selector or direct node used as relative point for inserting new node(s) for  each record. Defaults to last inserted node which has a parent.


### Description ###
Method loops provided values on actually selected nodes. Each time new row is inserted, provided callback is triggered with dataRow and dataIndex in context (this) of matched node.

Method doesn't change selected nodes stack.

## Example ##

### Markup ###
```
 <ul>
      <li class='row'>
          <span class='name'></span>
          <ul class='tags'>
              <li class='tag'>
                  <span class='tag'></span>
              </li>
          </ul>
      </li>
 </ul>
```

### Data ###
```
var data = [
     {
         'User': {'name': 'foo'},
         'Tags': [
             {'tag': 'php'},
             {'tag': 'js'}
         ],
     },
     {
         'User': {'name': 'bar'},
         'Tags': [
             {'tag': 'perl'}
         ],
     },
     {
         'User': {'name': 'fooBar'},
         'Tags': [
             {'tag': 'php'},
             {'tag': 'js'},
             {'tag': 'perl'}
         ],
     },
];
```

### `QueryTemplates` JavaScript formula ###
```
$('body > ul > li')
  .valuesToLoop(data, function(row) {
      this.valuesToSelector(row.User, 'span.%k')
          .find('> ul > li')
              .valuesToLoop(row.Tags, function(tag) {
                  this.valuesToSelector(tag);
              })
      ;
  });
```

### Template ###
```
 <ul>
 <li class="row">
          <span class="name">foo</span>
          <ul class="tags">
 <li class="tag">
                  <span class="tag">php</span>
              </li>
 <li class="tag">
                  <span class="tag">js</span>
              </li>
          </ul>
 </li>
 <li class="row">
          <span class="name">bar</span>
          <ul class="tags">
 <li class="tag">
                  <span class="tag">perl</span>
              </li>
          </ul>
 </li>
 <li class="row">
          <span class="name">fooBar</span>
          <ul class="tags">
 <li class="tag">
                  <span class="tag">php</span>
              </li>
 <li class="tag">
                  <span class="tag">js</span>
              </li>
 <li class="tag">
                  <span class="tag">perl</span>
              </li>
          </ul>
 </li>
 </ul>

```
### Template tree before ###
```
 ul
  - li.row
  -  - span.name
  -  - ul.tags
  -  -  - li.tag
  -  -  -  - span.tag

```
### Template tree after ###
```
 ul
  - li.row
  -  - span.name
  -  -  - Text:foo
  -  - ul.tags
  -  -  - li.tag
  -  -  -  - span.tag
  -  -  -  -  - Text:php
  -  -  - li.tag
  -  -  -  - span.tag
  -  -  -  -  - Text:js
  - li.row
  -  - span.name
  -  -  - Text:bar
  -  - ul.tags
  -  -  - li.tag
  -  -  -  - span.tag
  -  -  -  -  - Text:perl
  - li.row
  -  - span.name
  -  -  - Text:fooBar
  -  - ul.tags
  -  -  - li.tag
  -  -  -  - span.tag
  -  -  -  -  - Text:php
  -  -  - li.tag
  -  -  -  - span.tag
  -  -  -  -  - Text:js
  -  -  - li.tag
  -  -  -  - span.tag
  -  -  -  -  - Text:perl

```

---


### Comments allowed ###