# `valuesToLoop` #
[Wiki](http://code.google.com/p/querytemplates/w/list) > [Syntax](Syntax.md) > [valuesTo](valuesToSyntax.md) > [valuesToLoop](valuesToLoopMethodPHP.md)
### Parameters ###
  * **$values** _Array|Object_
> > Associative array or Object.
  * **$rowCallback** _Callback|String_
> > Callback triggered for every inserted row. Should support following  parameters:
      * $dataRow mixed
      * $node phpQueryObject
      * $dataIndex mixed
  * **$targetNodeSelector** _String|phpQueryObject_ = `null`
> > Selector or direct node used as relative point for inserting new node(s) for  each record. Defaults to last inserted node which has a parent.


### Description ###
Method loops provided $values on actually selected nodes. Each time new row  is inserted, provided callback is triggered with $dataRow, $node and $dataIndex.


Method doesn't change selected nodes stack.


## Example ##


This example requires PHP 5.3. For versions before, degradate closures to normal functions.


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
 $data = array(
      array(
          'User' => array('name' => 'foo'),
          'Tags' => array(
              array('tag' => 'php'),
              array('tag' => 'js'),
          ),
      ),
      array(
          'User' => array('name' => 'bar'),
          'Tags' => array(
              array('tag' => 'perl'),
          ),
      ),
      array(
          'User' => array('name' => 'fooBar'),
          'Tags' => array(
              array('tag' => 'php'),
              array('tag' => 'js'),
              array('tag' => 'perl'),
          ),
      ),
 );

```
### `QueryTemplates` formula ###
```
 $template
      ->find('> ul > li')
          ->valuesToLoop($data, function($row, $li1) {
              $li1->valuesToSelector($row['User'], 'span.%k')
                  ->find('> ul > li')
                      ->valuesToLoop($row['Tags'], function($tag, $li2) {
                          $li2->valuesToSelector($tag);
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


## See also ##
  * [varsToLoop](varsToLoopMethodPHP.md)


### Comments allowed ###