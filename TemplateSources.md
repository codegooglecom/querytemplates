Template can consist of several sources. All of them are lazy loaded (only when cache isn't up-to-date). Sources can be queried before parsing stage and during it. From one source there can be many collects (before parsing), which are used later as separate sources.

Source can be one of followings
  * HTML
  * XHTML
  * XML
  * PHP
    * PHP files are read as DOM, where PHP tags becomes `<php>code</php>` nodes
  * Callback
    * Callbacks as sources are used to lazy-execute some code