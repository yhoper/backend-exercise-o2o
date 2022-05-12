<?php
// src/Service/FilterFood.php
namespace App\Service;

class FilterFood
{
    public function changeToArray(array $data_response, array $keyToSearch):array
    {
        $newArray = array();
        for($index=0; $index < count($data_response); $index++){
            foreach($keyToSearch as $key){
                if(isset($data_response[$index][$key])){
                    $newArray[$index][$key] = $data_response[$index][$key];
                }
            }
        }
        return  $newArray;
    }
}   