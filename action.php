<?php
/**
 * DokuWiki Plugin grouphome (Action Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Andreas Gohr <gohr@cosmocode.de>
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

if (!defined('DOKU_LF')) define('DOKU_LF', "\n");
if (!defined('DOKU_TAB')) define('DOKU_TAB', "\t");
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');

require_once DOKU_PLUGIN.'action.php';

class action_plugin_grouphome extends DokuWiki_Action_Plugin {

    public function register(Doku_Event_Handler $controller) {

       $controller->register_hook('ACTION_ACT_PREPROCESS', 'BEFORE', $this, 'handle_hook');

    }

    public function handle_hook(Doku_Event $event, $param) {
        global $INFO;
        global $ID;
        global $conf;

        if($ID != $conf['start']) return;
        if(act_clean($event->data) != 'show') return;

        $grps = (array) $INFO['userinfo']['grps'];
        if(!count($grps)) return;

        $pages = $this->getConf('grouppages');

        foreach($grps as $grp){
            $page = cleanID(sprintf($pages,$grp));
            if(page_exists($page)){
                send_redirect(wl($page,'',true));
            }
        }
    }
}

// vim:ts=4:sw=4:et:
