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


