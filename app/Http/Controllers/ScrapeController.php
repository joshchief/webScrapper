<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;

class ScrapeController extends Controller
{

    private $states = [];
    private $bd_states = [];
    public function get_data(){

        $client = new Client();

        $url = 'http://www.worldometers.info/coronavirus/';

        $page = $client->request('GET', $url);

        $page->filter('.maincounter-number')->each(function($item){
            array_push($this->states, $item->text());
        });

        $page_bd = $client->request('GET', 'http://www.worldometers.info/coronavirus/country/bangladesh');
     
        $page_bd->filter('.maincounter-number')->each(function($item){
            array_push($this->states, $item->text());
        });


        $result = $this->returnResult();
        return response($result, 200);
        
    } 

    private function returnResult(){
        $output = [];
        $output['total_affected'] = $this->states[0];
        $output['total_death'] = $this->states[1];
        $output['total_recovered'] = $this->states[2];

        $output['total_affected_bd'] = $this->states[0];
        $output['total_death_bd'] = $this->states[1];
        $output['total_recovered_bd'] = $this->states[2];

        return $output;
    }
    
} 
