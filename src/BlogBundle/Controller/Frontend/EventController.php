<?php
/**
 * Creat by Eton Digital.
 * User: Vladimir Mladenovic (vladimir.mladenovic@etondigital.com)
 * Date: 12.5.15.
 * Time: 10.45
 */

namespace BlogBundle\Controller\Frontend;

use BlogBundle\Handler\Pagination;
use BlogBundle\Entity\Event;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EventController extends Controller
{
    /**
     * @Route("/blog/events", name="ed_blog_event")
     * @Route("/blog/events/", name="ed_blog_frontend_events")
     */
    public function indexAction()
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
              ->andwhere('c.parent IS NULL')
              ->setParameter('monday', $monday)
              ->getQuery()
              ->getResult();

        $paginator = $this->get('blog.paginator');
        $response = $paginator->paginate(
            $events,
            'BlogBundle:Frontend/Blog:events',
            'BlogBundle:Frontend/Global:pagination',
            array(),
            Pagination::SMALL,
            null,
            $paginationTemplate = 'BlogBundle:Frontend/Global:pagination.html.twig',
            array(),
            null
        );

        return $response;
    }


    /**
     * @Route("/blog/event/{eventName}", name="ed_frontend_blog_by_eventname")
     * @Route("/blog/event/{eventName}", name="frontend_blog_by_eventname")
     */
    public function singleEventAction($eventName)
    {
        $event = $this->get('app_repository_event')->findByName($eventName);

        if(!($event))
        {
            throw new NotFoundHttpException("Category not found.");
        }
        return $this->render("BlogBundle:Frontend/Blog:singleEvent.html.twig",
            array(
                'event' => $event
                ));
    }

}


