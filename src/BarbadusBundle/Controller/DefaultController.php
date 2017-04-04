<?php

namespace BarbadusBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
    {
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $servicos = $em->getRepository('BarbadusBundle:Servico')
                ->findBy(array(), array('nome' => 'ASC'));
        
        return $this->render('BarbadusBundle:Default:index.html.twig', array(
            'servicos' => $servicos
        ));
    }
    
    /**
     * @Route("/profissionais")
     */
    public function profissionaisAction()
    {        
        $em = $this->getDoctrine()->getManager();
        
        $barbeiros = $em->getRepository('BarbadusBundle:Barbeiro')
                ->findBy(array(), array('nome' => 'ASC'));
        
        
        // forma opcional de passar Json
//        foreach($barbeiros as $barb)
//        {
//            $_novo["nome"] = $barb->getNome();
//            $novo[] = $_novo;
//        }
        
        return $this->json($barbeiros);
        
        
    }
}
