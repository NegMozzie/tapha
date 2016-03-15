<?php
/**
 * Creat by Eton Digital.
 * User: Vladimir Mladenovic (vladimir.mladenovic@etondigital.com)
 * Date: 12.5.15.
 * Time: 10.45
 */

namespace BlogBundle\Controller\Frontend;

use BlogBundle\Handler\Pagination;
use BlogBundle\Entity\Taxonomy;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EventController extends Controller
{
    /**
     * @Route("/sport/events", name="ed_blog_event")
     * @Route("/sport/events/", name="ed_blog_frontend_events")
     */
    public function indexAction()
    {
        
        $events = $this->get('app_repository_season')->findActiveSeason();
        $paginator = $this->get('blog.paginator');
        return $this->render('BlogBundle:Frontend/Blog:events.html.twig', array(
              'season' => $events
          ));
    }
    


    /**
     * @Route("/sport/events/{eventName}/{type}", name="ed_frontend_blog_by_eventname")
     * @Route("/sport/events/{eventName}/{type}", name="frontend_blog_by_eventname")
     */
    public function singleEventAction($eventName, $type)
    {
        if ($type == "championnat")
          $event = $this->get('app_repository_championship')->findByName($eventName);
        if ($type == "grandprix")
          $event = $this->get('app_repository_grandprix')->findByName($eventName);
        if ($type == "course")
          $event = $this->get('app_repository_course')->findByName($eventName);

        if(!($event))
        {
            throw new NotFoundHttpException("Event not found.");
        }

        return $this->render("BlogBundle:Frontend/Blog:singleEvent.html.twig",
            array(
                'event' => $event,
                'type' => $type
                ));
    }

    /**
     * @Route("/sport/{categorySlug}/{type}", name="ed_frontend_blog_event_by_category")
     */
    public function byCategoryAction($categorySlug, $type)
    {
        $taxonomyType = Taxonomy::TYPE_CATEGORY;
        $taxonomy = $this->get('app_repository_taxonomy')->findBySlug($categorySlug);

        if(!($taxonomy && $taxonomy->getType()==$taxonomyType))
        {
            throw new NotFoundHttpException("Category not found.");
        }

        return $this->render("BlogBundle:Frontend/Blog:singleEvent.html.twig",
            array(
                'category' => $taxonomy,
                'type' => $type
                ));
    }

}


