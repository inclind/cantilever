## Cantilever is designed to

* isolate environments by framework (d7, d8, wp)
* isolate enironments by service level (pro, basic, etc)
* run drush and/or wp-cli commands on all isolated *todo wp-cli support
* search results of drush or wp-cli output *todo wp-cli support
* provide organized report of operations on per site basis

## Installation

* Place cantilever folder inside of ~/.terminus/plugins
* CanCommand.php must be executable to run

## Example:

```terminus can --env=live --level='pro,business,performance' --frame='drupal,drupal8' --command='pml|grep redis'```