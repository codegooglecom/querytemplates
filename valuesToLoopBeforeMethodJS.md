# `valuesToLoopBefore` #
[Wiki](http://code.google.com/p/querytemplates/w/list) > [Syntax](Syntax.md) > [valuesTo](valuesToSyntax.md) > [valuesToLoopBefore](valuesToLoopBeforeMethodJS.md)
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
Method loops provided values on actually selected nodes. Each time new row is inserted, provided callback is triggered with dataRow dataIndex, in context (this) of matched node. Acts as valuesToLoop(), but loops only first node from stack. Rest is removed from the DOM.

Acts as valuesToLoop(), but new nodes are inserted BEFORE target node.

Method DOES change selected nodes stack. Returned is first node.


---


## See also ##
  * [valuesToLoop](valuesToLoopMethodJS.md)

### Comments allowed ###