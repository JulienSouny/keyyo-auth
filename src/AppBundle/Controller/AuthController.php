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
    	// authenticate endpoint
    	$keyyo_token_endpoint = "https://ssl.keyyo.com/oauth2/token.php";

    	$client_id = "5b261b47eba27";
		$client_secret = "44001c168b7fefdcc2b8420d";
    	$grant_type = "authorization_code";
    	//$state = "05db09c4a4cada2b4e87568d81f3bbc4";
    	$redirect_uri = "https://galsen-services.com/callback";
    	//$code = "7e559e8c45cff1ba8ad5645c85d9add4a4bc2381";
    	$refresh_token = "7421e2f4486e4ddb6b02014bf9af25511954c59a";
    	$token = "HY3ZCsIwFET/Jc8FTW6qRvChrRUEpS6NolYkjd20KjaJC+K/G3ybmXNgPugotEB9tEuQm5IOTmk3SwXpJsixS4+0Af4xN3V9EFJmStmOXcKghwEzhxIg2CFWkUbp2yVrLL9ae48cpKriKrRpMvswDefBOKBnricsMgsVRqNwsWxP/W3wekP55PHaPzfsWHl65UHaeJV3UuqtZWx4XNJhVN3gwcp4RnTO65Ny4T4TJmklLSrFhheDAfr+AA==";
    
  
		// Send a cURL request using request"s authorization code
		$curl = curl_init($keyyo_token_endpoint);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, array(
			"client_id"     => $client_id,
			"client_secret" => $client_secret,
			"grant_type"    => "refresh_token",
			"redirect_uri"	=> $redirect_uri,
			"refresh_token"	=> $refresh_token
		));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

		$auth_data = curl_exec($curl);


		// Retrieve the access token

		var_dump(json_decode($auth_data));
		die();
    }



    $token = "HY3ZCsIwFET/Jc8FTW6qRvChrRUEpS6NolYkjd20KjaJC+K/G3ybmXNgPugotEB9tEuQm5IOTmk3SwXpJsixS4+0Af4xN3V9EFJmStmOXcKghwEzhxIg2CFWkUbp2yVrLL9ae48cpKriKrRpMvswDefBOKBnricsMgsVRqNwsWxP/W3wekP55PHaPzfsWHl65UHaeJV3UuqtZWx4XNJhVN3gwcp4RnTO65Ny4T4TJmklLSrFhheDAfr+AA==";
    $refresh_token = "7421e2f4486e4ddb6b02014bf9af25511954c59a";


    /**
     * @Route("/", name="Homepage")
     * @Method({"GET"})
     */
    public function indexAction()
    {
    	// Basic formular
        return $this->render(
            'index.html.twig'
        );   

    }


}