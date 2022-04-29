<?php

namespace Mailery\Sender\Controller;

use Mailery\Widget\Search\Form\SearchForm;
use Mailery\Widget\Search\Model\SearchByList;
use Mailery\Sender\Search\SenderSearchBy;
use Mailery\Sender\Filter\SenderFilter;
use Mailery\Sender\Repository\SenderRepository;
use Mailery\Sender\Form\SenderForm;
use Mailery\Sender\Model\SenderTypeByChannelTypeMap;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Yiisoft\Yii\View\ViewRenderer;
use Psr\Http\Message\ResponseFactoryInterface as ResponseFactory;
use Mailery\Brand\BrandLocatorInterface;
use Mailery\Sender\Model\SenderTypeList;
use Yiisoft\Validator\ValidatorInterface;
use Yiisoft\Http\Method;
use Yiisoft\Http\Status;
use Yiisoft\Http\Header;
use Yiisoft\Router\UrlGeneratorInterface as UrlGenerator;

class DefaultController
{
    private const PAGINATION_INDEX = 10;

    /**
     * @param ViewRenderer $viewRenderer
     * @param ResponseFactory $responseFactory
     * @param SenderRepository $senderRepo
     * @param BrandLocatorInterface $brandLocator
     */
    public function __construct(
        private ViewRenderer $viewRenderer,
        private ResponseFactory $responseFactory,
        private UrlGenerator $urlGenerator,
        private SenderRepository $senderRepo,
        BrandLocatorInterface $brandLocator
    ) {
        $this->viewRenderer = $viewRenderer
            ->withController($this)
            ->withViewPath(dirname(dirname(__DIR__)) . '/views');

        $this->senderRepo = $senderRepo->withBrand($brandLocator->getBrand());
    }

    /**
     * @param Request $request
     * @param SenderTypeList $senderTypeList
     * @return Response
     */
    public function index(Request $request, SenderTypeList $senderTypeList): Response
    {
        $queryParams = $request->getQueryParams();
        $pageNum = (int) ($queryParams['page'] ?? 1);
        $searchBy = $queryParams['searchBy'] ?? null;
        $searchPhrase = $queryParams['search'] ?? null;

        $searchForm = (new SearchForm())
            ->withSearchByList(new SearchByList([
                new SenderSearchBy(),
            ]))
            ->withSearchBy($searchBy)
            ->withSearchPhrase($searchPhrase);

        $filter = (new SenderFilter())
            ->withSearchForm($searchForm);

        $paginator = $this->senderRepo->getFullPaginator($filter)
            ->withPageSize(self::PAGINATION_INDEX)
            ->withCurrentPage($pageNum);

        return $this->viewRenderer->render('index', compact('searchForm', 'paginator', 'senderTypeList'));
    }

    /**
     * @param Request $request
     * @param ValidatorInterface $validator
     * @param SenderForm $form
     * @param SenderTypeByChannelTypeMap $map
     * @return Response
     */
    public function create(Request $request, ValidatorInterface $validator, SenderForm $form, SenderTypeByChannelTypeMap $map): Response
    {
        $body = $request->getParsedBody();

        if ($request->getMethod() === Method::POST && $form->load($body) && $validator->validate($form)->isValid()) {
            if (($channel = $form->getChannel()) !== null) {
                $senderType = $map->get($channel);

                return $this->responseFactory
                    ->createResponse(Status::TEMPORARY_REDIRECT)
                    ->withHeader(Header::LOCATION, $this->urlGenerator->generate($senderType->getCreateRouteName(), $senderType->getCreateRouteParams()));
            }
        }

        return $this->viewRenderer->render('create', compact('form'));
    }
}
