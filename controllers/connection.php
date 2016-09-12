<?php 
//this class makes the connection and get the data source
class connection{
    
    public function connect($params){
        
        $json = @file_get_contents('http://earthquake.usgs.gov/fdsnws/event/1/query?'.$params);
        //error handling
        if ($json === false) {
            $json['error'] = true;
            $json['errorMessage'] = 'There was an error retriving the data. Please limit your search criteria and try again.';
        }
        return $json;
        
    }
}

