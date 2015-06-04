<?php
namespace FDevs\TagBundle\Controller;

use FDevs\Tag\Form\Type\TagType;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Util\Codes;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Rest\RouteResource("Tag")
 * @ApiDoc(
 *  statusCodes={
 *      404="Returned when the tag is not found",
 *      200="Returned when successful"
 *  }
 * )
 */
class RestController extends FOSRestController
{
    /**
     * @ApiDoc(
     *  resource=true,
     *  resourceDescription="get Tag list",
     *  description="get Tag list",
     *  statusCodes={
     *      200="Returned when successful"
     *  },
     *  requirements={
     *      {"name"="limit", "dataType"="integer", "required"=false, "description"="limit"},
     *      {"name"="offset", "dataType"="integer", "required"=false, "description"="skip"}
     *  },
     *  filters={
     *      {"name"="filter", "dataType"="string", "default"="full", "description"="filter"},
     *      {"name"="type", "dataType"="string", "default"="", "description"="tag type"}
     *  },
     *  output={"class"="FDevs\Tag\Model\Tag","parsers" = {"Nelmio\ApiDocBundle\Parser\JmsMetadataParser"}}
     * )
     * @Rest\QueryParam(name="limit", strict=true, default="1000", requirements="\d+", description="limit")
     * @Rest\QueryParam(name="offset", strict=true, default="0", requirements="\d+", description="skip")
     * @Rest\QueryParam(name="type", default="", requirements="[\d\w-]{0,}", description="tag Type")
     * @Rest\QueryParam(name="filter", key="filter", default="base", requirements="full|base|small")
     */
    public function cgetAction(ParamFetcher $paramFetcher)
    {
        $limit = (int) $paramFetcher->get('limit');
        $offset = (int) $paramFetcher->get('offset');
        $this->setSerializerGroups($paramFetcher->get('filter'));
        $query = [];
        if ($type = $paramFetcher->get('type')) {
            $query['type'] = $type;
        }
        $data = $this->getManager()->setLimit($limit)->setOffset($offset)->findBy($query);

        return $this->handleView($this->view($data, Codes::HTTP_OK));
    }

    /**
     * @ApiDoc(
     *  resourceDescription="get Tag by Id",
     *  description="get Tag by Id",
     *  requirements={
     *      {"name"="id", "dataType"="string", "required"=true, "description"="Tag id"}
     *  },
     *  statusCodes={
     *      404="Returned when the Tag is not found",
     *      200="Returned when successful"
     *  },
     *  filters={
     *      {"name"="filter", "dataType"="string", "description"="filter"}
     *  },
     *  output={"class"="FDevs\Tag\Model\Tag","parsers" = {"Nelmio\ApiDocBundle\Parser\JmsMetadataParser"}}
     * )
     * @Rest\QueryParam(name="filter", strict=false, key="filter", default="full", requirements="full|base")
     */
    public function getAction(ParamFetcher $paramFetcher, $id)
    {
        $this->setSerializerGroups($paramFetcher->get('filter'));
        $tag = $this->getManager()->find($id);
        if (!$tag) {
            throw new NotFoundHttpException('tag not found');
        }

        return $this->handleView($this->view($tag, Codes::HTTP_OK));
    }

    /**
     * @ApiDoc(
     *  description="Create a new Tag",
     *  resourceDescription="Create a new Tag",
     *  input="FDevs\Tag\Form\Type\TagType",
     *  statusCodes={
     *      400="Bad Request",
     *      201="Tag created"
     *  },
     *  responseMap={
     *      201={"class"="FDevs\Tag\Model\Tag"},
     *      400={"class"="FDevs\Tag\Form\Type\TagType","parsers"={"Nelmio\ApiDocBundle\Parser\JmsMetadataParser"}}
     *  },
     *  output={"class"="FDevs\Tag\Model\Tag"}
     * )
     */
    public function postAction(Request $request)
    {
        $manager = $this->getManager();
        $tag = $manager->createTag();
        $form = $this->createForm($this->container->getParameter('f_devs_tag.form'), $tag, ['csrf_protection' => false]);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $manager->updateTag($tag);

            return $this->handleView($this->view($tag, Codes::HTTP_CREATED));
        }

        return $this->handleView($this->view($form, Codes::HTTP_BAD_REQUEST));
    }

    /**
     * @param string $group
     *
     * @return $this
     */
    private function setSerializerGroups($group)
    {
        $this->getViewConfig()->setSerializerGroups($group);

        return $this;
    }

    /**
     * @return \FOS\RestBundle\Controller\Annotations\View
     */
    private function getViewConfig()
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $view = $request->attributes->get('_view', new \FOS\RestBundle\Controller\Annotations\View([]));
        $request->attributes->set('_view', $view);

        return $view;
    }

    /**
     * @return \FDevs\Tag\TagManagerInterface
     */
    private function getManager()
    {
        return $this->container->get('f_devs_tag.manager');
    }
}
