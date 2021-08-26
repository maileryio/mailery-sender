<?php

namespace Mailery\Sender\Controller;

use Mailery\Widget\Search\Form\SearchForm;
use Mailery\Widget\Search\Model\SearchByList;
use Mailery\Sender\Search\SenderSearchBy;
use Mailery\Sender\Filter\SenderFilter;
use Mailery\Sender\Repository\SenderRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Yiisoft\Yii\View\ViewRenderer;
use Psr\Http\Message\ResponseFactoryInterface as ResponseFactory;
use Mailery\Brand\BrandLocatorInterface;
use Yiisoft\Router\UrlGeneratorInterface as UrlGenerator;
use Mailery\Sender\Service\SenderCrudService;
use Mailery\Sender\Model\SenderTypeList;

class DefaultController
{
    private const PAGINATION_INDEX = 10;

    /**
     * @var SenderRepository
     */
    private SenderRepository $senderRepo;

    /**
     * @param ViewRenderer $viewRenderer
     * @param ResponseFactory $responseFactory
     * @param BrandLocatorInterface $brandLocator
     * @param SenderRepository $senderRepo
     */
    public function __construct(
        ViewRenderer $viewRenderer,
        ResponseFactory $responseFactory,
        BrandLocatorInterface $brandLocator,
        SenderRepository $senderRepo
    ) {
        $this->viewRenderer = $viewRenderer
            ->withController($this)
            ->withViewPath(dirname(dirname(__DIR__)) . '/views');

        $this->responseFactory = $responseFactory;
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
     * @param SenderCrudService $senderCrudService
     * @param UrlGenerator $urlGenerator
     * @return Response
     */
    public function delete(Request $request, SenderCrudService $senderCrudService, UrlGenerator $urlGenerator): Response
    {
        $senderId = $request->getAttribute('id');
        if (empty($senderId) || ($sender = $this->senderRepo->findByPK($senderId)) === null) {
            return $this->responseFactory->createResponse(404);
        }

        $senderCrudService->delete($sender);

        return $this->responseFactory
            ->createResponse(302)
            ->withHeader('Location', $urlGenerator->generate('/sender/default/index'));
    }
}
