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
 * Request handler model test
 *
 * @category   Oggetto
 * @package    Oggetto_Payment
 * @subpackage Model
 * @author     Denis Belov <dbelov@oggettoweb.com>
 */
class Oggetto_Payment_Test_Model_RequestHandler extends EcomDev_PHPUnit_Test_Case_Controller
{
    /**
     * Set up function
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $order = $this->getModelMock('sales/order', array('getBaseGrandTotal'));

        $order->expects($this->any())
            ->method('getBaseGrandTotal')
            ->will($this->returnValue(123.123));

        $this->replaceByMock('model', 'sales/order', $order);
    }

    /**
     * Test init handler
     *
     * @return void
     */
    public function testInit()
    {
        $requestHandler = Mage::getModel('oggetto_payment/requestHandler');

        $requestHandler->init(array(
            'status' => 1,
            'order_id' => 42,
            'total' => '123,12',
            'hash' => '1q2w3e'
        ));

        $this->assertEquals(1, $requestHandler->getStatus());
        $this->assertEquals(42, $requestHandler->getOrderId());
        $this->assertEquals('123,12', $requestHandler->getTotal());
        $this->assertEquals('1q2w3e', $requestHandler->getHash());

        $this->assertEquals(array(
            'status' => 1,
            'order_id' => 42,
            'total' => '123,12'
        ), $requestHandler->getParams());

        $this->assertEquals(42, $requestHandler->getOrder()->getId());
    }


    /**
     * Test process with ok status
     *
     * @return void
     */
    public function testProcessWithOkStatus()
    {
        $requestHandler = Mage::getModel('oggetto_payment/requestHandler');

        $hash = md5(
            'order_id:50|' .
            'status:1|' .
            'total:123,12|' .
            Mage::helper('oggetto_payment/data')->getSecretKey()
        );

        $requestHandler->init(array(
            'status' => 1,
            'order_id' => 50,
            'total' => '123,12',
            'hash' => $hash
        ));

        Mage::getModel('sales/order')->load(50)->getPayment()->setMethod(
            Mage::getModel('oggetto_payment/standard')->getCode());

        $requestHandler->process();

        $order = Mage::getModel('sales/order')->load(50);
        $this->assertEquals(Mage_Sales_Model_Order::STATE_PROCESSING, $order->getStatus());
        $this->assertEquals(Mage_Sales_Model_Order_Invoice::STATE_PAID, $order->getInvoiceCollection()->getFirstItem()->getState());
    }


    /**
     * Test process with fail status
     *
     * @return void
     */
    public function testProcessWithFailStatus()
    {
        $requestHandler = Mage::getModel('oggetto_payment/requestHandler');

        $hash = md5(
            'order_id:50|' .
            'status:2|' .
            'total:123,12|' .
            Mage::helper('oggetto_payment/data')->getSecretKey()
        );

        $requestHandler->init(array(
            'status' => 2,
            'order_id' => 50,
            'total' => '123,12',
            'hash' => $hash
        ));

        Mage::getModel('sales/order')->load(50)->getPayment()->setMethod(
            Mage::getModel('oggetto_payment/standard')->getCode());

        $requestHandler->process();

        $order = Mage::getModel('sales/order')->load(50);
        $this->assertEquals(Mage_Sales_Model_Order::STATE_CANCELED, $order->load(50)->getStatus());
        $this->assertEquals(Mage_Sales_Model_Order_Invoice::STATE_CANCELED, $order->getInvoiceCollection()->getFirstItem()->getState());
    }


    /**
     * Test success validate
     *
     * @return void
     */
    public function testValidateSuccess()
    {
        $requestHandler = Mage::getModel('oggetto_payment/requestHandler');

        $hash = md5(
            'order_id:42|' .
            'status:1|' .
            'total:123,12|' .
            Mage::helper('oggetto_payment/data')->getSecretKey()
        );

        $requestHandler->init(array(
            'status' => 1,
            'order_id' => 42,
            'total' => '123,12',
            'hash' => $hash
        ));

        $this->assertTrue($requestHandler->validate());
    }

    /**
     * Test order id incorrect validate
     *
     * @return void
     */
    public function testValidateIncorrectOrderId()
    {
        $requestHandler = Mage::getModel('oggetto_payment/requestHandler');

        $hash = md5(
            'order_id:100500|' .
            'status:1|' .
            'total:123,12|' .
            Mage::helper('oggetto_payment/data')->getSecretKey()
        );

        $requestHandler->init(array(
            'status' => 1,
            'order_id' => 100500,
            'total' => '123,12',
            'hash' => $hash
        ));

        $this->assertFalse($requestHandler->validate());
    }


    /**
     * Test total incorrect validate
     *
     * @return void
     */
    public function testValidateIncorrectTotal()
    {
        $requestHandler = Mage::getModel('oggetto_payment/requestHandler');

        $hash = md5(
            'order_id:42|' .
            'status:1|' .
            'total:100500|' .
            Mage::helper('oggetto_payment/data')->getSecretKey()
        );

        $requestHandler->init(array(
            'status' => 1,
            'order_id' => 42,
            'total' => '100500',
            'hash' => $hash
        ));

        $this->assertFalse($requestHandler->validate());
    }


    /**
     * Test status incorrect validate
     *
     * @return void
     */
    public function testValidateIncorrectStatus()
    {
        $requestHandler = Mage::getModel('oggetto_payment/requestHandler');

        $hash = md5(
            'order_id:42|' .
            'status:666|' .
            'total:123,12|' .
            Mage::helper('oggetto_payment/data')->getSecretKey()
        );

        $requestHandler->init(array(
            'status' => 666,
            'order_id' => 42,
            'total' => '123,12',
            'hash' => $hash
        ));

        $this->assertFalse($requestHandler->validate());
    }


    /**
     * Test hash incorrect validate
     *
     * @return void
     */
    public function testValidateIncorrectHash()
    {
        $requestHandler = Mage::getModel('oggetto_payment/requestHandler');

        $requestHandler->init(array(
            'status' => 1,
            'order_id' => 42,
            'total' => '123,12',
            'hash' => '1q2w3e'
        ));

        $this->assertFalse($requestHandler->validate());
    }
}