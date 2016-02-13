<?php

namespace BlogBundle\Controller\Frontend;

use BlogBundle\Entity\Taxonomy;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SidebarController extends Controller
{
    public function blogListAction()
    {
          $date = date('Y-m-d'); // you can put any date you want
          $nbDay = date('N', strtotime($date));
          $monday = new \DateTime($date);
          $sunday = new \DateTime($date);
          $monday->modify('-'.($nbDay-1).' days');
          $sunday->modify('+'.(8-$nbDay).' days');
          $events = $this->get('app_repository_event')
              ->createQueryBuilder('c')
              ->where('c.startsAt >= :monday')
              ->andwhere('c.startsAt <= :sunday')
              ->setParameter('monday', $monday)
              ->setParameter('sunday', $sunday)
              ->getQuery()
              ->getResult();
          return $this->render('BlogBundle:Frontend/Blog:blog_sidebar.html.twig', array(
              'events' => $events
          ));
    }
}
