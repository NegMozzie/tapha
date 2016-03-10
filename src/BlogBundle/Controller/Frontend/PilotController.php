<?php
/**
 * Creat by Eton Digital.
 * User: Vladimir Mladenovic (vladimir.mladenovic@etondigital.com)
 * Date: 12.5.15.
 * Time: 10.45
 */

namespace BlogBundle\Controller\Frontend;

use BlogBundle\Handler\Pagination;
use BlogBundle\Entity\Pilot;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PilotController extends Controller
{
    /**
     * @Route("/blog/pilots", name="ed_blog_pilot")
     * @Route("/blog/pilots/", name="ed_blog_frontend_pilots")
     */
    public function indexAction()
    {
        $date = date('Y-m-d'); // you can put any date you want
          $nbDay = date('N', strtotime($date));
          $monday = new \DateTime($date);
          $sunday = new \DateTime($date);
          $monday->modify('-'.($nbDay-1).' days');
          $sunday->modify('+'.(8-$nbDay).' days');
          $pilots = $this->get('app_repository_pilot')
              ->createQueryBuilder('c')
              ->where('c.startsAt >= :monday')
              ->andwhere('c.parent IS NULL')
              ->setParameter('monday', $monday)
              ->getQuery()
              ->getResult();

        $paginator = $this->get('blog.paginator');
        $response = $paginator->paginate(
            $pilots,
            'BlogBundle:Frontend/Blog:pilots',
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
     * @Route("/blog/pilot/{pilotName}", name="ed_frontend_blog_by_pilotname")
     * @Route("/blog/pilot/{pilotName}", name="frontend_blog_by_pilotname")
     */
    public function singlePilotAction($pilotName)
    {
        $pilot = $this->get('app_repository_pilot')->findByName($pilotName);

        if(!($pilot))
        {
            throw new NotFoundHttpException("Pilot not found.");
        }
        return $this->render("BlogBundle:Frontend/Blog:singlePilot.html.twig",
            array(
                'pilot' => $pilot
                ));
    }

}


