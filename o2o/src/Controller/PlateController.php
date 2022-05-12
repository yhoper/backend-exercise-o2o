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
    public function searchingFood(Request $request,  FilterFood $filterFood): Response
    {
        $pathUri='https://api.punkapi.com/v2/beers';
        $client = new \GuzzleHttp\Client();
        
        $keyToSearch = array('id', 'name', 'description');
        $statusApi = $client->request('GET', $pathUri);
        
        if($statusApi->getStatusCode()==200){
            $resApi = json_decode($statusApi->getBody(), true); 
            $dataResponse=$filterFood->changeToArray($resApi, $keyToSearch);
        }else{
            $dataResponse =['message' => "Ha ocurrido un error"];
        }
        return $response = new JsonResponse($dataResponse);
    }
    
    public function searchingFoodDetail(Request $request,  FilterFood $filterFood, $searchFood=''): Response
    {
        
        if(!$searchFood){
            $searchFood = $request->request->get("searchFood", null);
        } 
        if(!$searchFood){
            return $dataResponse = new JsonResponse(['message' => "Ha realizado una búsqueda vacía, por favor envíe un parametro valido"]);
        }else{
            $pathUri='https://api.punkapi.com/v2/beers';
            $client = new \GuzzleHttp\Client();
            $keyToSearch = array('id', 'name', 'description');
            $statusApi = $client->request('GET', $pathUri.'?food='.$searchFood);
            $response = new JsonResponse();
            if($statusApi->getStatusCode()==200){
                $resApi = json_decode($statusApi->getBody(), true); 
                $dataResponse=$filterFood->changeToArray($resApi, $keyToSearch);
            }else{
                $dataResponse =['message' => "Ha ocurrido un error"];
            }
            return $response = new JsonResponse($dataResponse);
        }
    }
}