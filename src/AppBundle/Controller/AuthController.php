<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AuthController extends Controller
{
    /**
     * @Route("/auth", name="auth")
     * @Method({"GET", "POST"})
     */
    public function getAuth(Request $request)
    {
    	// authenticate endpoint
    	$keyyo_token_endpoint = "https://ssl.keyyo.com/oauth2/authorize.php";

    	$client_id = "5b261b47eba27";
		$client_secret = "44001c168b7fefdcc2b8420d";
    	$response_type = "code";
    	$state = md5(mt_rand());
    	$redirect_uri = "https://galsen-services.com/callback";

		var_dump("https://ssl.keyyo.com/oauth2/authorize.php?client_id=5b261b47eba27&response_type=code&state=". md5(mt_rand()) . "&scope=full_access&redirect_uri=https://galsen-services.com/callback");
		die();
    }



    /**
     * @Route("/token", name="token")
     * @Method({"GET", "POST"})
     */
    public function getToken(Request $request)
    {
    	require_once __DIR__ . '/../config.php';
    	// var_dump($refresh_token);
    	// die();

        try {
            $keyyo_token_endpoint = 'https://api.keyyo.com/oauth2/token.php';
  
            // Send a cURL request using request"s authorization code
            $curl = curl_init($keyyo_token_endpoint);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, array(
                "client_id"     => $client_id,
                "client_secret" => $client_secret,
                "grant_type"    => "refresh_token",
                "redirect_uri"  => $redirect_uri,
                "refresh_token" => $refresh_token
            ));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            $auth_data = curl_exec($curl);

            file_put_contents(__DIR__ . '/../access_token', json_decode($auth_data, 1)["access_token"]);

            $response = new Response(
                json_encode([
                    'status'  => 'success',
                    'message' => 'access token updated successfully'
                ]),
                200
            );
            return $response;
        }
        catch (Exception $e) {
            $response = new Response(
                json_encode([
                    'status'  => 'error',
                    'message' => $e->getMessage()
                ]),
                401
            );
        }
    }


    /**
     * @Route("/", name="Homepage")
     * @Method({"GET"})
     */
    public function indexAction()
    {
    	session_start();

		require_once __DIR__ . '/../config.php';

		$keyyo_authorize_endpoint = 'https://ssl.keyyo.com/oauth2/authorize.php';

		$_SESSION["oauth_state"] = uniqid();
		// Redirect the browser< to Keyyo's login/authorization form
		$authorize_url = sprintf("%s?client_id=%s&response_type=code&state=%s&redirect_uri=%s", $keyyo_authorize_endpoint, $client_id, $_SESSION["oauth_state"], $redirect_uri);

        $_SESSION["access_token"] = file_get_contents(__DIR__ . '/../access_token');

		header('Location: ' . $authorize_url);

		$_SESSION["status"] = "ok";
		
		die();
    }


    /**
     * @Route("/callback", name="callback")
     * @Method({"GET"})
     */
    public function callbackAction()
    {
    	//session_start();

		require_once __DIR__ . '/../config.php';

		var_dump('hello');

		$keyyo_authorize_endpoint = 'https://ssl.keyyo.com/oauth2/authorize.php';

		$_SESSION["oauth_state"] = uniqid();
		// Redirect the browser to Keyyo's login/authorization form
		$authorize_url = sprintf("%s?client_id=%s&response_type=code&state=%s&redirect_uri=%s", $keyyo_authorize_endpoint, $client_id, $_SESSION["oauth_state"], $redirect_uri);
		//var_dump($authorize_url);
		header('Location: ' . $authorize_url);
		
		// exit();
    	// Basic formular
        // return $this->render(
        //     'index.html.twig'
        // );   

    }


}