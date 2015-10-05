# `valuesToLoopFirst` #
[Wiki](http://code.google.com/p/querytemplates/w/list) > [Syntax](Syntax.md) > [valuesTo](valuesToSyntax.md) > [valuesToLoopFirst](valuesToLoopFirstMethodPHP.md)
### Parameters ###
  * **$values** _Array|Object_
> > Associative array or Object.
  * **$rowCallback** _Callback|String_
> > Callback triggered for every inserted row. Should support following  parameters:
      * $dataRow mixed
      * $node phpQueryObject
      * $dataIndex mixed
  * **$targetNodeSelector** _String|phpQueryObject_
> > Selector or direct node used as relative point for inserting new node(s) for  each record. Defaults to last inserted node which has a parent.


### Description ###
Method loops provided $values on actually selected nodes. Each time new row  is inserted, provided callback is triggered with $dataRow, $node and $dataIndex.


Acts as valuesToLoop(), but loops only first node from stack. Rest is removed  from the DOM.


Method DOES change selected nodes stack. Returned is first node.

---


## See also ##
  * [valuesToLoop](valuesToLoopMethodPHP.md)


### Comments allowed ###