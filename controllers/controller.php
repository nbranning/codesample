<?php
date_default_timezone_set('America/Denver');
require('connection.php');



class controller{
    
    
    
    public function twentyfourHourReport(){
        $connect = new connection();
        //get earthquakes for the last 24 hours
        $startDate = date('Y-m-dTH:i:s', strtotime('-24 hours'));
        $endDate = date('Y-m-dTH:i:s');
        $params = 'format=geojson&starttime='.$startDate.'&endtime='.$endDate;
        $data = json_decode($connect->connect($params), true);
        
        return $data;
    }
    
    //index page function
    public function index(){}
    
    
    //map page function
    public function map(){
        $last24hr = $this->twentyfourHourReport();
        $last24hr['error'] = false;
        return array('data' => $last24hr, 'filter' => array('startDate' => '24 hours'));
    }
    
    //data page function
    public function data(){
        //get form input first else get default dataset
        if(!empty($_POST)){
            //var_dump($_POST);
            $connect = new connection();
            //get earthquakes for the last 24 hours
            $startDate = date('Y-m-dT00:00:00', strtotime($_POST['startDate']));
            $endDate = date('Y-m-dT23:59:59', strtotime($_POST['endDate']));
            $params = 'format=geojson&starttime='.$startDate.'&endtime='.$endDate;
            
            $data = $connect->connect($params);
            //check for errors
            if(!isset($data['error'])){
                $data = json_decode($data, true);
                $data['error'] = false;
            }
            return array('data' => $data, 'filter' => $_POST);
            
        }else{
            $last24hr = $this->twentyfourHourReport();
            $last24hr['error'] = false;
            return array('data' => $last24hr, 'filter' => array('startDate' => '24 hours'));
        }
        
    }
    
    
    
}