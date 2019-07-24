<?php

namespace Dev\ProductComments\Block\Widget;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
use Magento\Catalog\Helper\Image;
use Magento\Framework\Pricing\PriceCurrencyInterface;


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
     * @var Magento\Framework\Pricing\Helper\Data
     */
    private $priceCurrency;

    /**
     * Posts constructor.
     * @param Template\Context $context
     * @param ProductRepositoryInterface $productRepository
     * @param SearchCriteriaBuilder $criteriaBuilder
     * @param PriceCurrencyInterface $priceCurrency
     * @param Image $imageHelper
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        ProductRepositoryInterface $productRepository,
        SearchCriteriaBuilder $criteriaBuilder,
        PriceCurrencyInterface $priceCurrency,
        Image $imageHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->productRepository = $productRepository;
        $this->criteriaBuilder = $criteriaBuilder;
        $this->imageHelper = $imageHelper;
        $this->priceCurrency = $priceCurrency;
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

    public function getFormatedPrice($price)
    {
        return $this->priceCurrency->convertAndFormat($price);

    }



}