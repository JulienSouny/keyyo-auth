<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ClientController extends Controller
{
    /**
     * @Route("/client", name="getclient")
     * @Method({"GET"})
     */
    public function getClientInfo(Request $request)
    {
        try {
            // included for test
            require_once __DIR__ . '/../config.php';

            $access_token = $_SESSION["access_token"];

            // Instantiate a Manager client (version 1.0 here)
            $keyyo_manager = new \Keyyo\Manager\Client('1.0', $access_token);

            // // Retrieve all services from the authenticated customer
            $services = $keyyo_manager->services();

            $profiles = [];
            $i = 0;
            foreach ($services as $service) {
                $profiles[$i]["csi"] = $service->csi;
                $profiles[$i]["name"] = $service->name;
                $i++;
            }

            return $this->render('client.html.twig', [
                'profiles' => $profiles,
            ]);            
        }
        catch (Exception $e) {
            $response = new Response(
                json_encode([
                    'status'  => 'error',
                    'message' => $e->getMessage()
                ]),
                400
            );
        }

    }



        /**
     * @Route("/client", name="updateclient")
     * @Method({"POST"})
     */
    public function postClientInfo(Request $request)
    {
        require_once __DIR__ . '/../config.php';
        ini_set('display_errors', 1);
        $access_token = $_SESSION["access_token"];


        // Instantiate a Manager client (version 1.0 here)
        $keyyo_manager = new \Keyyo\Manager\Client('1.0', $access_token);

        if ($_POST["name"] != "") {
            $keyyo_manager->services($_POST["csi"])->__set('name', $_POST["name"]);
        }

        // Retrieve all services from the authenticated customer
        $services = $keyyo_manager->services();


        //var_dump($services);
        //die();

        $profiles = [];
        $i = 0;

        // var_dump($services);
        // die();

        foreach ($services as $service) {
            $profiles[$i]["csi"] = $service->csi;
            $profiles[$i]["name"] = $service->name;
            $i++;
        }


        return $this->render('client.html.twig', [
            'profiles' => $profiles,
        ]);
    }

}