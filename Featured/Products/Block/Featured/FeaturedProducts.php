<?php
namespace Featured\Products\Block\Featured;

protected $_categoryFactory;


class FeaturedProducts extends \Magento\Framework\View\Element\Template
{
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context, 
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility,
        array $data = []
    ) {
        $this->_productCollectionFactory = $productCollectionFactory;  
        $this->_categoryFactory = $categoryFactory;      
        $this->catalogProductVisibility = $catalogProductVisibility;
        parent::__construct(
            $context,
            $data
        );
    }

  public function getCategory($categoryId) 
    {
        $category = $this->_categoryFactory->create();
        $category->load($categoryId);
        return $category;
    }



    public function getProducts($category_id = null)
    {
        $collection = $this->_productCollectionFactory->create();
        $collection = $this->_productCollectionFactory->create()->addAttributeToSelect('*');
        if(!empty($category_id)) {
        	$categoryId = 'yourcategoryid';
    		$category = $this->_categoryFactory->create()->load($categoryId);
    		$collection->addCategoryFilter($category);
        }

        $collection->addAttributeToFilter('status', '1')->addAttributeToFilter('is_featured', '1');

        $collection->setVisibility($this->catalogProductVisibility->getVisibleInCatalogIds());
        $collection->printLogQuery(true); 	

        return $collection;
    }   



     public function getCategoryProducts($categoryId) 
    {
        $products = $this->getCategory($categoryId)->getProductCollection();
        $products->addAttributeToSelect('*');
        $products->addAttributeToFilter('status', '1')->addAttributeToFilter('is_featured', '1');
        $products->setVisibility($this->catalogProductVisibility->getVisibleInCatalogIds());
     
        return $products;
    }





}