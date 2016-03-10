<?php

namespace BlogBundle\Controller\Frontend;

use BlogBundle\Entity\Taxonomy;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SidebarController extends Controller
{
    public function blogListAction()
    {
          $paginator = $this->get('blog.paginator');
          $events = $this->get('app_repository_event')->getWeekEvents();
          return $this->render('BlogBundle:Frontend/Blog:blog_sidebar.html.twig', array(
              'events' => $events
          ));
    }
}
