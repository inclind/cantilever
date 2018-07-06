## Cantilever is designed to

* isolate environments by framework (drupal, drupal8, wordpress)
* isolate enironments by service level (free, basic, pro, business, performance)
* run drush and/or wp-cli commands on all isolated *todo wp-cli support
* search results of drush or wp-cli output *todo wp-cli support
* provide organized report of operations on per site basis

## Installation

* Place cantilever folder inside of ~/.terminus/plugins
* CanCommand.php must be executable to run

## Example

```terminus can --env=live --level='pro,business,performance' --frame='drupal,drupal8' --command='pml|grep redis'```

## Todo
* Add wp-cli support
* Add flags for drush and wp-cli so all terminus plugins can be run as well
* Change all scripts to go through terminus with a flag to run a custom script outside of terminus