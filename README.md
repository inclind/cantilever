## Cantilever is designed to

* isolate environments by framework (drupal, drupal8, wordpress)
* isolate enironments by service level (free, basic, pro, business, performance)
* run drush and/or wp-cli commands
* provide organized report of operations on per site basis

## Installation

* Clone or copy cantilever inside of ~/.terminus/plugins
* CanCommand.php must be executable to run

## Examples

```terminus can --env=live --level='pro,business,performance' --frame='drupal,drupal8' --command='pml|grep redis' -d```

```terminus can --env=live --frame='wordpress' --command='option get home' -w```