<?php
/**
 * Creat by Eton Digital.
 * User: Vladimir Mladenovic (vladimir.mladenovic@etondigital.com)
 * Date: 12.5.15.
 * Time: 10.45
 */

namespace BlogBundle\Controller\Frontend;

use BlogBundle\Handler\Pagination;
use BlogBundle\Entity\Article;
use BlogBundle\Entity\Taxonomy;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BlogController extends Controller
{
    /**
     * @Route("/", name="ed_blog_homepage")
     * @Route("/blogview", name="homepage")
     * @Route("/blog", name="ed_blog_frontend_index")
     * @Route("/blog/")
     */
    public function indexAction()
    {

        $paginator = $this->get('blog.paginator');
        $response = $paginator->paginate(
            $this->get('app_repository_article')->getActiveArticles(),
            'BlogBundle:Frontend/Blog:index',
            'BlogBundle:Frontend/Global:pagination',
            array(),
            20,
            null,
            $paginationTemplate = 'BlogBundle:Frontend/Global:pagination.html.twig',
            array(),
            null
        );

        return $response;
    }

    /**
     * @Route("/blog/{slug}", name="ed_frontend_blog_single_article")
     * @ParamConverter("article", class="BlogBundle\Entity\Article", converter="abstract_converter")
     */
    public function singleArticleAction($article)
    {
        if($article->getStatus() != Article::STATUS_PUBLISHED  || !$article->getPublishedAt() || strtotime($article->getPublishedAt()->format("Y-m-d H:i:s") ) > strtotime(date("Y-m-d H:i:s")))
        {
            throw new NotFoundHttpException("Sorry, request article is not longer available or your URL is wrong!");
        }

        $commentClass = $this->container->getParameter('blog_comment_class');
        $newComment = new $commentClass();
        $newComment
            ->setArticle($article);

        $form = $this->createForm('edcomment', $newComment);
        $comments =  $this->get("app_repository_comment")->findByArticle($article, $this->get("blog_settings")->getCommentsDisplayOrder());
        $commentsCount = $this->get("app_repository_comment")->findCountByArticle($article);

        return $this->render("BlogBundle:Frontend/Blog:singleArticle.html.twig",
            array(
                'article' => $article,
                'form' => $form->createView(),
                'comments' => $comments,
                'commentsCnt' => $commentsCount
                ));
    }

    /**
     * @Route("/blog/category/{categorySlug}", name="ed_frontend_blog_by_category")
     */
    public function byCategoryAction($categorySlug)
    {
        $taxonomyType = Taxonomy::TYPE_CATEGORY;
        $taxonomy = $this->get('app_repository_taxonomy')->findBySlug($categorySlug);

        if(!($taxonomy && $taxonomy->getType()==$taxonomyType))
        {
            throw new NotFoundHttpException("Category not found.");
        }

        $criteria['type'] = $taxonomyType;
        $criteria['value'] = $taxonomy;

        $paginator = $this->get('blog.paginator');
        $response = $paginator->paginate(
            $this->get('app_repository_article')->getActiveArticlesByTaxonomy($categorySlug,$taxonomyType),
            'BlogBundle:Frontend/Blog:index',
            'BlogBundle:Frontend/Global:pagination',
            array("criteria" => $criteria),
            20,
            null,
            $paginationTemplate = 'BlogBundle:Frontend/Global:pagination.html.twig',
            array(),
            null
        );

        return $response;
    }

    /**
     * @Route("/blog/category/{categorySlug}", name="ed_frontend_blog_by_categorytag")
     * @Route("/blog/category/{categorySlug}", name="frontend_blog_by_categorytag")
     */
    public function byCategorytagAction($categorySlug)
    {
        $taxonomyType = Taxonomy::TYPE_CATEGORY;
        $taxonomy = $this->get('app_repository_taxonomy')->findBySlug($categorySlug);

        if(!($taxonomy && $taxonomy->getType()==$taxonomyType))
        {
            throw new NotFoundHttpException("Category not found.");
        }

        $criteria['type'] = $taxonomyType;
        $criteria['value'] = $taxonomy;

        $paginator = $this->get('app_repository_article')->getActiveArticlesByTaxonomy($categorySlug,$taxonomyType);
        return $this->render("BlogBundle:Frontend/Blog:Navbar.html.twig", array(
                'pagination' => $paginator,
                ));
    }

    /**
     * @Route("/blog/tag/{tagSlug}", name="ed_frontend_blog_by_tag")
     */
    public function byTagAction($tagSlug)
    {
        $taxonomyType = Taxonomy::TYPE_TAG;

        $taxonomy = $this->get('app_repository_taxonomy')->findBySlug($tagSlug);

        if(!($taxonomy && $taxonomy->getType()==$taxonomyType))
        {
            throw new NotFoundHttpException("Tag not found.");
        }

        $criteria['type'] = $taxonomyType;
        $criteria['value'] = $taxonomy;

        $paginator = $this->get('blog.paginator');
        $response = $paginator->paginate(
            $this->get('app_repository_article')->getActiveArticlesByTaxonomy($tagSlug,$taxonomyType),
            'BlogBundle:Frontend/Blog:index',
            'BlogBundle:Frontend/Global:pagination',
            array("criteria" => $criteria),
            Pagination::SMALL,
            null,
            $paginationTemplate = 'BlogBundle:Frontend/Global:pagination.html.twig',
            array(),
            null
        );

        return $response;
    }

    /**
     * @Route("/blog/author/{username}", name="ed_frontend_blog_by_author")
     * @ParamConverter("user", class="BlogBundle\Entity\User", converter="abstract_converter")
     */
    public function byAuthorAction($user)
    {
        $criteria['type'] = "author";
        $criteria['value'] = $user;

        $paginator = $this->get('blog.paginator');
        $response = $paginator->paginate(
            $this->get('app_repository_article')->getActiveArticlesByAuthor($user),
            'BlogBundle:Frontend/Blog:index',
            'BlogBundle:Frontend/Global:pagination',
            array("criteria" => $criteria),
            Pagination::SMALL,
            null,
            $paginationTemplate = 'BlogBundle:Frontend/Global:pagination.html.twig',
            array(),
            null
        );

        return $response;
    }

    /**
     * @Route("/blog/author/{username}", name="ed_frontend_blog_by_authorbar")
     * @Route("/blog/author/{username}", name="frontend_blog_by_authorbar")
     * @ParamConverter("user", class="BlogBundle\Entity\User", converter="abstract_converter")
     */
    public function byAuthorbarAction($user)
    {
        $criteria['type'] = "author";
        $criteria['value'] = $user;

        $paginator = $this->get('app_repository_article')->getActiveArticlesByAuthor($user);
        return $this->render("BlogBundle:Frontend/Blog:Articlebar.html.twig", array(
                'pagination' => $paginator,
                ));
    }

    /**
     * @Route("/blog/archive/{yearMonth}", name="ed_frontend_blog_archive")
     */
    public function archiveAction($yearMonth)
    {
        $archive=explode('-',$yearMonth);
        $year=$archive[0];
        $month=(count($archive) > 1) ? $archive[1]: null ;

        if(!((int)$year == $year && (int)$year > 0 && $month && (int)$month == $month && (int)$month > 0 && (int)$month <= 12))
        {
            throw new NotFoundHttpException("Invalid archive period.");
        }

        $criteria['type'] = "archive";
        $criteria['value'] = array('year' => $year, 'month' => $month);

        $paginator = $this->get('blog.paginator');
        $response = $paginator->paginate(
            $this->get('app_repository_article')->getArticlesInOneMonth($year,$month),
            'BlogBundle:Frontend/Blog:index',
            'BlogBundle:Frontend/Global:pagination',
            array("criteria" => $criteria),
            Pagination::SMALL,
            null,
            $paginationTemplate = 'BlogBundle:Frontend/Global:pagination.html.twig',
            array(),
            null
        );

        return $response;
    }
}


