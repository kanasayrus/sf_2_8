<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Product;

class DefaultController extends Controller
{
     /**
     * @Route("/product/new", name="blog_new")
     */
    public function newAction()
    {
        $product = new Product();
        $product->setName('Keyboard');
        $product->setPrice(19.99);
        $product->setDescription('Ergonomic and stylish!');
        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();
        return $this->render('default/new.html.twig', array(
            'id' => $product->getId()
        ));
    }
    
    /**
     * @Route("/product/list/{item}", name="blog_list", requirements={"item": "\d+"})
     */
    public function listAction() {
        //PURE DQL QUERIES
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                'SELECT p FROM AppBundle:Product p 
                WHERE p.price >= :price 
                ORDER BY p.price ASC'
                )->setParameter('price',19.99);
        $products = $query->getResult();
        dump("DQL QUERIES #### ".count($products));
        
        //DOCTRINE QUERY BUILDER
        $repository = $this->getDoctrine()->getRepository('AppBundle:Product');
        $query = $repository->createQueryBuilder('p')
                            ->where('p.price >= :price')
                            ->setParameter('price',19.99)
                            ->orderBy('p.price','ASC')
                            ->getQuery();
        $products = $query->getResult();
        dump("SQL ### ".$query->getSql());
        
        dump("DOCTRINE Query builder #### ".count($products));
        
        $productId = 18;
        $product = $this->getDoctrine()
                        ->getRepository('AppBundle:Product')
                        ->find($productId);
        $category = $this->getDoctrine()->getRepository('AppBundle:Category')->find(1);
        $product->setCategory($category);
        $category = $product->getCategory();
        dump(get_class($category));
        die();
    }
    
    /**
     * @Route("/admin")
     */
    public function adminAction()
    {
        return new Response('<html><body>Admin page!</body></html>');
    }
    
}
