<?php
namespace Pantheon\TerminusCantilever;

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
   * @option env Choose site environment
   * @option level Choose site service level (free,basic,pro,business,performance)
   * @option frame Choose site framework (drupal,drupal8,wordpress)
   * @option tags Choose site tags (development,enterprise,terminated)
   * @option org Name of organization/membership site belongs to
   * @option command Add your command (using [site] to reference site)
   *
   * terminus can --env=live --level='pro,business,performance' --frame='drupal,drupal8' --command='terminus drush [site] pml|grep redis'
   * terminus can --env=live --frame='wordpress' --command='terminus wp [site] option get home'
   *
   */
    public function cantilever($options = ['env' => 'dev', 'level' => null, 'frame' => 'drupal', 'tags' => null, 'org' => null, 'command' => null])
    {
        //show initialize
        $this->log()->notice("Cantilever initializing...");
    
        //list sites
        $sites = $this->sites->serialize();
    
        if (empty($sites)) {
            $this->log()->notice('You have no sites.');
        }

        //site loop
        foreach ($sites as $key => $site) {
            //remove non selected sites
            //todo:: refactor explode routine
            if (isset($options['level'])) {
                $level = explode(",", $options['level']);
                if (!in_array($site['service_level'], $level, true)) {
                    unset($sites[$key]);
                }
            }
      
            if (isset($options['frame'])) {
                $frame = explode(",", $options['frame']);
                if (!in_array($site['framework'], $frame, true)) {
                    unset($sites[$key]);
                }
            }

		        if (isset($options['tags'])) {
			        $frame = explode(",", $options['tags']);
			        if (!in_array($site['tags'], $frame, true)) {
				        unset($sites[$key]);
			        }
		        }

		        if (isset($options['org'])) {
			        if (preg_match("/(\b".$options['org']."\b)(\n|,|$)/", $site['memberships']) == false) {
				        unset($sites[$key]);
			        }
		        }

            //run
            if (isset($sites[$key])) {
                //print site
                echo $site['name'];
		            if (isset($options['env'])) {
			            echo ".".$options['env'];
		            }
		            echo "\n";
		            if (isset($options['tags'])) {
			            echo $site['tags'] . "\n";
		            }
		            if (isset($options['org'])) {
			            echo $options['org'] . "\n";
		            }

                //compile command
                if (isset($options['command'])) {
                    $options['command'] = str_replace("[site]", $site['name'].".".$options['env'], $options['command']);

                    echo "----------\n";
                    $query = $options['command'];
                    $output = shell_exec($query);
                    if ($output == '') {
                        $output = "** no results **\n";
                    }

                    //print output
                    echo $output."\n";
                }
            }
        }
    }
}
