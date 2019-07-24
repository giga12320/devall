<?php

namespace Dev\ProductComments\Block\Widget;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
use Magento\Catalog\Helper\Image;

class CommentsWidget extends Template implements BlockInterface
{

    protected $_template = "widget/comments-widget.phtml";
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private $criteriaBuilder;

    /**
     * Posts constructor.
     * @param Template\Context $context
     * @param ProductRepositoryInterface $productRepository
     * @param SearchCriteriaBuilder $criteriaBuilder
     */
    public function __construct(
        Template\Context $context,
        ProductRepositoryInterface $productRepository,
        SearchCriteriaBuilder $criteriaBuilder,
        Image $imageHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->productRepository = $productRepository;
        $this->criteriaBuilder = $criteriaBuilder;
        $this->imageHelper = $imageHelper;
    }

    public function getProductCollection($maxSize)
    {
        $criteria = $this->criteriaBuilder
            ->addFilter('product_comments', 'yes')
            ->create()
            ->setPageSize($maxSize);

        return $this->productRepository->getList($criteria)->getItems();
    }

    private $imageHelper;

    public function getItemImage($productId)
    {
        try {
            $_product = $this->productRepository->getById($productId);
        } catch (NoSuchEntityException $e) {
            return 'product not found';
        }
        $image_url = $this->imageHelper->init($_product, 'product_base_image')->getUrl();
        return $image_url;
    }

}