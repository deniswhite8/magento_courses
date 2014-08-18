<?php
/**
 * Oggetto Payment extension for Magento
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
 * the Oggetto Payment module to newer versions in the future.
 * If you wish to customize the Oggetto Sales module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Oggetto
 * @package   Oggetto_Payment
 * @copyright Copyright (C) 2014, Oggetto Web (http://oggettoweb.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Helper data
 *
 * @category   Oggetto
 * @package    Oggetto_Payment
 * @subpackage Block
 * @author     Denis Belov <dbelov@oggettoweb.com>
 */
class Oggetto_Payment_Helper_Data extends Mage_Core_Helper_Abstract
{
    /** @var Mage_Sales_Model_Order $_order */
    protected $_order;

    protected $_params;

    /**
     * Get order status
     *
     * @return string
     */
    public function getOrderStatus()
    {
        return Mage::getStoreConfig('payment/oggettopayment/order_status');
    }

    /**
     * Get gateway url
     *
     * @return string
     */
    public function getGatewayUrl()
    {
        return Mage::getStoreConfig('payment/oggettopayment/submit_url');
    }

    /**
     * Get secret api key
     *
     * @return string
     */
    public function getSecretKey()
    {
        return Mage::getStoreConfig('payment/oggettopayment/secret_key');
    }

    /**
     * Get order
     *
     * @return Mage_Sales_Model_Order
     */
    public function getOrder()
    {
        if (!$this->_order) {
            $orderId = Mage::getSingleton('checkout/session')->getLastRealOrderId();
            $this->_order = Mage::getModel('sales/order')->loadByIncrementId($orderId);
        }

        return $this->_order;
    }

    /**
     * Get order items name
     *
     * @return string
     */
    public function getOrderItemsName()
    {
        $result = array();

        foreach ($this->getOrder()->getAllVisibleItems() as $orderItem) {
            $qty = round($orderItem->getQtyOrdered());
            $qtyString = '';

            if ($qty > 1) {
                $qtyString = " ($qty)";
            }

            $result[] = $orderItem->getName() . $qtyString;
        }

        return implode(', ', $result);
    }

    /**
     * Get success url
     *
     * @return string
     */
    public function getSuccessUrl()
    {
        return Mage::getUrl(
            'checkout/onepage/success',
            array('_secure' => true)
        );
    }

    /**
     * Get failure url
     *
     * @return string
     */
    public function getFailureUrl()
    {
        return Mage::getUrl(
            'oggetto_payment/payment/cancel',
            array('_secure' => true)
        );
    }

    /**
     * Get report url
     *
     * @return string
     */
    public function getReportUrl()
    {
        return Mage::getUrl(
            'oggetto_payment/payment/response',
            array('_secure' => true)
        );
    }

    /**
     * Get params without hash
     *
     * @return array
     */
    public function getParamsWithoutHash()
    {
        if (!$this->_params) {
            $order = $this->getOrder();
            $this->_params = array(
                'order_id' => $order->getEntityId(),
                'total' => $this->getOrderTotal($order),
                'items' => $this->getOrderItemsName(),
                'success_url' => $this->getSuccessUrl(),
                'error_url' => $this->getFailureUrl(),
                'payment_report_url' => $this->getReportUrl(),
            );
        }

        return $this->_params;
    }

    /**
     * Get order total formatted
     *
     * @param Mage_Sales_Model_Order $order Order
     * @return array
     */
    public function getOrderTotal($order)
    {
        return strtr($order->getBaseGrandTotal(), '.', ',');
    }

    /**
     * Get params
     *
     * @return array
     */
    public function getParams()
    {
        $params = $this->getParamsWithoutHash();
        $params['hash'] = $this->getHash($this->getParamsWithoutHash());

        return $params;
    }

    /**
     * Get hash
     *
     * @param array $params Params
     * @return string
     */
    public function getHash($params)
    {
        ksort($params);

        $joinParams = array();
        foreach ($params as $key => $value) {
            $joinParams[] = $key . ':' . $value;
        }

        $joinParams[] = $this->getSecretKey();

        return md5(implode('|', $joinParams));
    }
}