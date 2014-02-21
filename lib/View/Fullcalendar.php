<?php
/**
 *Created by Konstantin Kolodnitsky
 * Date: 21.02.14
 * Time: 19:07
 */
namespace KonstantinKolodnitsky\fullcalendar;
class View_Fullcalendar extends \View{
    public $m;
    function init(){
        parent::init();

        $l = $this->api->locate('addons',__NAMESPACE__,'location');
        $addon_location = $this->api->locate('addons',__NAMESPACE__);
        $this->api->pathfinder->addLocation($addon_location,array(
            'php'=>array('lib','vendor'),
            'js'=>array('fullcalendar'),
            'css'=>array('vendor'),
        ))->setParent($l);

        $this->loadPlugin();
    }
    function loadPlugin(){
        $this->js(true)->_load('fullcalendar/fullcalendar.min');
        $this->js(true)->_css('fullcalendar/fullcalendar');
    }
}