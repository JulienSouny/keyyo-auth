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
     * @Route("/client", name="client")
     * @Method({"GET", "POST"})
     */
    public function getClientInfo(Request $request)
    {
    	// included for test
    	require_once __DIR__ . '/../config.php';

		// Instantiate a Manager client (version 1.0 here)
		$keyyo_manager = new \Keyyo\Manager\Client('1.0', $access_token);

		// Retrieve all services from the authenticated customer
		$services = $keyyo_manager->services(33175430270);
        var_dump($services->name);
        die();

		$profiles = [];
		$i = 0;
		foreach ($services as $service) {
            var_dump($service);
            die();
    		$profiles[$i]["csi"]                = $service->csi;
			$profiles[$i]["name"]               = $service->name;
			$i++;
		}
		var_dump($profiles);
		die();


        return $this->render('client.html.twig', [
            'profiles' => $profiles,
        ]);
    }

}