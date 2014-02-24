<?php
/**
 *Created by Konstantin Kolodnitsky
 * Date: 21.02.14
 * Time: 19:07
 */
namespace KonstantinKolodnitsky\fullcalendar;
class View_Fullcalendar extends \View{
    public $model;
    public $calendar;
    function init(){
        parent::init();

        $l = $this->api->locate('addons',__NAMESPACE__,'location');
        $addon_location = $this->api->locate('addons',__NAMESPACE__);

        $this->api->pathfinder->addLocation($addon_location,array(
//            'php'=>array('lib'),
            'css'=>array('public'),
        ))->setParent($l);//->setBaseURL($this->api->pm->base_path);

        $this->loadPlugin();
        $this->getCalendar();
    }
    function loadPlugin(){
        $this->calendar = $this->js(true)->_load('fullcalendar/fullcalendar.min');
        $this->js(true)->_css('fullcalendar');
//        $this->api->jui->addStaticStylesheet('fullcalendar');
    }
    private function getCalendar() {
        $count = 0;
        $j_str = '[';
        if(!$this->model){
            throw $this->exception('You have not specified model');
        }
        foreach ($this->model as $element) {
//            var_dump($v); echo '<hr>';
            if ($count>0)$j_str.=',';
            $count++;
            $t_start_arr = explode ("-", $element['DATE_LISTED']);
            $t_start = $t_start_arr[1]."/".$t_start_arr[2]."/".$t_start_arr[0];
            $t_end_arr = explode ("-", $element['DATE_REQUIRED']);
            $t_end = $t_end_arr[1]."/".$t_end_arr[2]."/".$t_end_arr[0];
            if(!$element['DATE_REQUIRED']){
                $t_end = $t_start;
            }
            $j_str = $j_str.'
                {
                    title: "N'.$element['id'].'",'.'
                    start: "'.$t_start.'",'.'
                    end: "'.$t_end.'",'.'
                    color: "#'.dechex(rand(0x000000,0xffffff)).'",
                    allDay: true,
                   '.(($element['id'])?' url: "'.$this->api->url('jobs/info').'\x26job_id='.$element['id'].'",':'').'
                }';
        }
        $j_str .= ']';
        $this->calendar->fullCalendar(array(
            'events'=>$j_str,
            'd' => date('d'),
            'm' => date('m'),
            'y' => date('Y')
        ));
    }
}