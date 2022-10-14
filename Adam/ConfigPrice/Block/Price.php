<?php
namespace Adam\ConfigPrice\Block;

use Magento\Framework\Pricing\Helper\Data;

class Price extends \Magento\Framework\View\Element\Template
{
	protected $_productRepository;
	protected $priceHelper;

	public function __construct(
		\Magento\Backend\Block\Template\Context $context,		
		\Magento\Catalog\Model\ProductRepository $productRepository,
		Data $priceHelper,
		array $data = []
	)
	{
		$this->_productRepository = $productRepository;
		$this->priceHelper = $priceHelper;
		parent::__construct($context, $data);
	}
	
	public function getProductById($id)
	{
		return $this->_productRepository->getById($id);
	}

	public function getChildProductPrice($id) 
	{
	 $_product = $this->_productRepository->getById($id);
	 return $_product->getFinalPrice();
	}
	
	public function getLowestPrice($children)
	{
		$prices = [];
		foreach($children as $child) {
			$prices[] = $this->getChildProductPrice($child['entity_id']);
		}

		return min($prices);
	}

	public function getFormattedPrice($price)
	{
		return $this->priceHelper->currency($price, true, false);
	}
}
