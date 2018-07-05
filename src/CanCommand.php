<?php
namespace Pantheon\TerminusCantilever;

//use Consolidation\OutputFormatters\StructuredData\RowsOfFields;
use Pantheon\Terminus\Commands\Site\SiteCommand;

class CanCommand extends SiteCommand
{
  /**
   * Grab all sites.
   *
   * @authorize
   *
   * @command can
   *
   * @option env filter; Choose site environment
   * @option level filter; Choose site service level (free,basic,pro,business,performance)
   * @option frame filter; Choose site framework (drupal,drupal8,wordpress)
   *
   * example: terminus can --env=live --level='pro,business,performance' --frame='drupal,drupal8' --command='pml|grep redis'
   *
   */
  public function cantilever($options = ['env' => 'dev', 'level' => null, 'frame' => null, 'command' => null])
  {
    //show initialize
    $this->log()->notice("Cantilever initializing...");

    //list sites
    $sites = $this->sites->serialize();

    if (empty($sites)) {
	    $this->log()->notice('You have no sites.');
    }

    foreach ($sites as $key => $site) {
	    if (isset($options['level'])) {
		    $level = explode(",",$options['level']);
		    if (!in_array($site['service_level'], $level, true)) {
			    unset($sites[$key]);
		    }
	    }

	    if (isset($options['frame'])) {
		    $frame = explode(",",$options['frame']);
		    if (!in_array($site['framework'], $frame, true)) {
			    unset($sites[$key]);
		    }
	    }

	    //print output
	    if (isset($sites[$key])) {
		    echo $site['name']."\n";
		    if (isset($options['command'])) {
		      echo "----------\n";
			    $query = "drush @".$site['name'].".".$options['env']." ".$options['command'];
			    $output = shell_exec($query);
			    if ($output == '') {
			      $output = "** no results **\n";
			    }
			    echo $output."\n";
		    }
	    }
    }
  }
}
