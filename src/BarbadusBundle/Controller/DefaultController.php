<?php

namespace BarbadusBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

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
        
        
        $dtInicio = new \DateTime("+1 Day");
        $dtFim = new \DateTime("+11 Day");
        $intervalo = new \Dateinterval("P1D");  
        $periodo = new \DatePeriod($dtInicio, $intervalo, $dtFim);        
        
        return $this->render('BarbadusBundle:Default:index.html.twig', array(
            'servicos' => $servicos,
            'datas' => $periodo
        ));
    }
    
    /**
     * @Route("/profissionais")
     */
    public function profissionaisAction(Request $request)
    {   
        $idServico = $request->get("servico");
        $em = $this->getDoctrine()->getManager();
        
        $barbeiros = $em->getRepository('BarbadusBundle:Barbeiro')
                ->findBy(array("servico" => $idServico), array('nome' => 'ASC'));
        
        
        // forma opcional de passar Json
//        foreach($barbeiros as $barb)
//        {
//            $_novo["nome"] = $barb->getNome();
//            $novo[] = $_novo;
//        }
        
        return $this->json($barbeiros);
        
        
    }
    
    /**
     * @Route("/horarios")
     */
    public function horariosAction(Request $request)
    {
        $dtSelecionada = $request->get('dia');
        
        $dtInicio = new \DateTime($dtSelecionada);
        $dtInicio->setTime(9,  0, 0);
        $dtFim = new \DateTime($dtSelecionada);
        $dtFim->setTime(18,  0, 0);
        
        $intervalo = new \Dateinterval("PT30M");  
        $periodo = new \DatePeriod($dtInicio, $intervalo, $dtFim);
        
        foreach ($periodo as $dia)
        {
            $dias["hora"] = $dia->format('H:i');
            $dias["disponivel"] = true;
            $listaHorarios[] = $dias;
        }
        
        return $this->json($listaHorarios);
    }
}
