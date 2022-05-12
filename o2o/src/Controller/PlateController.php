<?php
// src/Controller/PlateController.php
namespace App\Controller;

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
    public function searchingFood(Request $request,  $searchString=''): Response
    {
        
        $pathUri='https://api.punkapi.com/v2/beers';
        $client = new \GuzzleHttp\Client();
        if(!$searchString){
            $searchString = $request->request->get("searchString", null);
        }
        
        if(!$searchString)
        $responseApi = $client->request('GET', $pathUri);
        else
        $responseApi = $client->request('GET', $pathUri.'?food='.$searchString); 
        
        $response = new JsonResponse();
        if($responseApi->getStatusCode()==200)
            $dataResponse = json_decode($responseApi->getBody(), true); 
        else
             $dataResponse =['message' => "Ha ocurrido un error"];

        return $response = new JsonResponse($dataResponse);
    }
}