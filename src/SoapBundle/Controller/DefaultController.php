<?php

namespace SoapBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class DefaultController extends Controller
{
    /**
     * @Route("/soap")
     */
    //SOAP SERVER
    public function indexAction()
    {
        $server = new \SoapServer('/var/www/sf_2_8/web/bundles/framework/XML/hello.wsdl');
        //$server = new \SoapServer('/var/www/sf_2_8/web/bundles/framework/XML/sender.wsdl');
        $server->setObject($this->get('sender_service'));
        $response = new Response();
        
        $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');

        ob_start(); //start buffering the STDOUT 
        $server->handle();
        $response->setContent(ob_get_clean()); 
        //ob_get_clean to dump the echoed output into the content of the response and clear the output buffer

        return $response;
    }
    
    /**
     * @Route("/test")
     */
    public function testAction()
    {
        
        $client = new \Soapclient('http://localhost/sf_2_8/web/app_dev.php/soap?wsdl');
        //$result = $client->__call('hello', array('name' => 'Scott'));
        $params = array();
        $result = $client->__call('sender',$params);
        echo $result;exit;
        
    }
}