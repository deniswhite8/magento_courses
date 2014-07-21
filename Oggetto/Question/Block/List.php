<?php
/**
 * Oggetto question extension for Magento
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
 * @package   Oggetto_Question
 * @copyright Copyright (C) 2014, Oggetto Web (http://oggettoweb.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Admin edit form
 *
 * @category   Oggetto
 * @package    Oggetto_Question
 * @subpackage Block
 * @author     Denis Belov <dbelov@oggettoweb.com>
 */
class Oggetto_Question_Block_List extends Mage_Core_Block_Template
{

    /** @var Oggetto_Question_Model_Resource_Question_Collection */
    private $_collection;

    /**
     * Get question collection
     *
     * @return Mage_Core_Model_Resource_Db_Collection_Abstract
     */
    public function getQuestionCollection()
    {
        if (!$this->_collection) {
            $this->_collection = Mage::getModel('question/question')->getCollection()
                ->addFilter('status', Oggetto_Question_Model_Question::STATUS_ANSWERED)
                ->setOrder('timestamp');
        }

        return $this->_collection;
    }

    /**
     * Prepare layout
     *
     * @return Oggetto_Question_Block_List
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $pager = $this->getLayout()->getBlock('question.pager');
        $pager->setAvailableLimit(array(5 => 5));
        $pager->setCollection($this->getQuestionCollection());

        return $this;
    }
}