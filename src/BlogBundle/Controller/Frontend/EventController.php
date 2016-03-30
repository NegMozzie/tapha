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
     * @Route("/category/{categorySlug}/events", name="ed_blog_events")
     * @Route("/category/{categorySlug}/events/", name="ed_blog_frontend_events")
     */
    public function indexAction($categorySlug)
    {
        $taxonomyType = Taxonomy::TYPE_CATEGORY;
        $taxonomy = $this->get('app_repository_taxonomy')->findBySlug($categorySlug);

        if(!($taxonomy && $taxonomy->getType()==$taxonomyType))
        {
            throw new NotFoundHttpException("Category not found.");
        }

        $criteria['type'] = $taxonomyType;
        $criteria['value'] = $taxonomy;

        $paginator = $this->get('_blog.paginator');
        $response = $paginator->paginate(
            $this->get('app_repository_championship')->findByTaxonomy($categorySlug,$taxonomyType),
            'BlogBundle:Frontend/Blog:calendrier',
            'BlogBundle:Frontend/Global:pagination',
            array("criteria" => $criteria),
            1,
            null,
            $paginationTemplate = 'BlogBundle:Frontend/Global:pagination.html.twig',
            array(),
            null
        );

        return $response;
    }

    /**
     * @Route("/category/{categorySlug}/classement", name="ed_blog_classements")
     * @Route("/category/{categorySlug}/classement/", name="ed_blog_frontend_classements")
     */
    public function classementAction($categorySlug)
    {
        $taxonomyType = Taxonomy::TYPE_CATEGORY;
        $taxonomy = $this->get('app_repository_taxonomy')->findBySlug($categorySlug);

        if(!($taxonomy && $taxonomy->getType()==$taxonomyType))
        {
            throw new NotFoundHttpException("Category not found.");
        }

        $criteria['type'] = $taxonomyType;
        $criteria['value'] = $taxonomy;

        $paginator = $this->get('_blog.paginator');
        $response = $paginator->paginate(
            $this->get('app_repository_championship')->findByTaxonomy($categorySlug,$taxonomyType),
            'BlogBundle:Frontend/Blog:pclassement',
            'BlogBundle:Frontend/Global:pagination',
            array("criteria" => $criteria),
            30,
            null,
            $paginationTemplate = 'BlogBundle:Frontend/Global:pagination.html.twig',
            array(),
            null
        );

        return $response;
    }


    /**
     * @Route("/category/events/{eventName}", name="ed_frontend_blog_by_eventname")
     * @Route("/category/events/{eventName}", name="frontend_blog_by_eventname")
     */
    public function singleeventAction($eventName)
    {
        $event = $this->get('app_repository_grandprix')->findByName($eventName);

        if(!($event))
        {
            throw new NotFoundHttpException("event not found.");
        }
        return $this->render("BlogBundle:Frontend/Blog:singleEvent.html.twig",
            array(
                'event' => $event,
                'type' => 'grandprix'
                ));
    }

}


