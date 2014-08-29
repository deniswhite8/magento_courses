<?php
/**
 * Oggetto Web extension for Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade
 * the Oggetto Sales module to newer versions in the future.
 * If you wish to customize the Oggetto Sales module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Oggetto
 * @package   Oggetto_News
 * @copyright Copyright (C) 2014, Oggetto Web (http://oggettoweb.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * List block
 *
 * @category   Oggetto
 * @package    Oggetto_News
 * @subpackage Block
 * @author     Denis Belov <dbelov@oggettoweb.com>
 */
class Oggetto_News_Block_List extends Mage_Core_Block_Template
{

    /** @var Oggetto_News_Model_Resource_News_Collection */
    private $_collection;

    /**
     * Get news collection
     *
     * @return Mage_Core_Model_Resource_Db_Collection_Abstract
     */
    public function getNewsCollection()
    {
        if (!$this->_collection) {
            $this->_collection = Mage::getResourceModel('oggetto_news/news_collection')
                ->addFilter('status', Oggetto_News_Model_News::STATUS_ENABLED)
                ->setOrder('timestamp');
        }

        return $this->_collection;
    }

    /**
     * Prepare layout
     *
     * @return Oggetto_News_Block_List
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $pager = $this->getLayout()->getBlock('news.pager');
        $pager->setAvailableLimit(array(5 => 5));
        $pager->setCollection($this->getNewsCollection());

        return $this;
    }
}