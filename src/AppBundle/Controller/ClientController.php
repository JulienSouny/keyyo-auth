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
    	// included for test
    	require_once __DIR__ . '/../config.php';

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



        /**
     * @Route("/client", name="updateclient")
     * @Method({"POST"})
     */
    public function postClientInfo(Request $request)
    {
        // included for test
        require_once __DIR__ . '/../config.php';

        var_dump(count($_POST) == 0);
        var_dump(count($_GET) == 0);


        if ($_POST["name"] != "") {

        };

        var_dump($services->name);

        $services->__set('name','Pierrot');

        var_dump($services->name);


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

}