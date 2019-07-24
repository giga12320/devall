<?php
namespace Dev\ProductComments\Block\Widget;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

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
        array $data = [])
    {
        parent::__construct($context, $data);
        $this->productRepository = $productRepository;
        $this->criteriaBuilder = $criteriaBuilder;
    }

    public function getProductCollection()
    {
        $criteria = $this->criteriaBuilder
            ->addFilter('product_comments', 'yes')
            ->create();

        return $this->productRepository->getList($criteria)->getItems();
    }

}