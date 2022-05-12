<?php
// src/Controller/PlateController.php
namespace App\Controller;

use App\Service\FilterFood;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PlateController extends AbstractController
{
    /**
    * @Route("/", name="searchingFood")
    */
    public function searchingFood(Request $request,  FilterFood $filterFood, $searchString=''): Response
    {
        $pathUri='https://api.punkapi.com/v2/beers';
        $client = new \GuzzleHttp\Client();
        if(!$searchString){
            $searchString = $request->request->get("searchString", null);
        }
        if(!$searchString){
            $keyToSearch = array('id', 'name', 'description');
            $responseApi = $client->request('GET', $pathUri);
        }else{
            $keyToSearch = array('id', 'name', 'description', 'image_url', 'tagline', 'first_brewed');
            $responseApi = $client->request('GET', $pathUri.'?food='.$searchString); 
        }
        
        $response = new JsonResponse();
        if($responseApi->getStatusCode()==200){
            $dataArray = json_decode($responseApi->getBody(), true); 
            $dataResponse=$filterFood->changeToArray($dataArray, $keyToSearch);
        }else{
            $dataResponse =['message' => "Ha ocurrido un error"];
        }
        
        return $response = new JsonResponse($dataResponse);
    }
}