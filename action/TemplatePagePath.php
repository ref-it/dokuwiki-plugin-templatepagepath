<?php
/**
 * DokuWiki Plugin templatepagepath (Action Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Michael Braun <michael-dev@fami-braun.de>
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

class action_plugin_templatepagepath_TemplatePagePath extends DokuWiki_Action_Plugin {

    public function register(Doku_Event_Handler $controller): void {
       $controller->register_hook('COMMON_PAGETPL_LOAD', 'BEFORE', $this, 'handle_common_pagetpl_load');
    }

    public function handle_common_pagetpl_load(Doku_Event &$event, $param = null): void {
	    global $conf;

	    // from here is it almost the same code as inc/common.php pageTemplate
	    // function (core dokuwiki) but vars name are adjusted to be used
	    // within the plugin.

	    $prefix = $this->getConf('tpl_path');

	    $path = dirname(wikiFN($prefix.":".$event->data['id']));

	    if(is_file($path.'.txt')){
		    $event->data['tplfile'] = $path.'.txt';
	    }else{
		    // search upper namespaces for templates
		    $len = strlen(rtrim($conf['datadir'],'/'));
		    while (strlen($path) >= $len){
			    if(is_file($path.'.txt')){
				    $event->data['tplfile'] = $path.'.txt';
				    break;
			    }
			    $path = substr($path, 0, strrpos($path, '/'));
		    }
	    }
    }

}

