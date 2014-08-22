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
 * Payment model test
 *
 * @category   Oggetto
 * @package    Oggetto_Payment
 * @subpackage Controller
 * @author     Denis Belov <dbelov@oggettoweb.com>
 */
class Oggetto_Payment_Test_Controller_PaymentController extends EcomDev_PHPUnit_Test_Case_Controller
{
    /**
     * Mock request handler model, with validation result
     *
     * @param PHPUnit_Framework_MockObject_Stub $value Validation result
     * @return void
     */
    protected function _mockRequestHandler($value)
    {
        parent::setUp();

        $requestHandler = $this->getModelMock('oggetto_payment/requestHandler', array('init', 'validate', 'process'));

        $requestHandler->expects($this->any())
            ->method('init')
            ->will($this->returnSelf());

        $requestHandler->expects($this->any())
            ->method('validate')
            ->will($value);

        $requestHandler->expects($this->any())
            ->method('process')
            ->will($this->returnSelf());

        $this->replaceByMock('model', 'oggetto_payment/requestHandler', $requestHandler);
    }

    /**
     * Test redirect action
     *
     * @return void
     */
    public function testBlockInRedirectAction()
    {
        $this->dispatch('oggetto_payment/payment/redirect');
        $this->assertRequestRoute('oggetto_payment/payment/redirect');
        $this->assertEquals('oggetto_payment/redirect.phtml',
            $this->getLayout()->getBlock('root')->getTemplate());
    }

    /**
     * Test correct response action
     *
     * @return void
     */
    public function testCorrectResponse()
    {
        $this->_mockRequestHandler($this->returnValue(true));

        $this->dispatch('oggetto_payment/payment/response');
        $this->assertRequestRoute('oggetto_payment/payment/response');

        $this->assertResponseHttpCode(200);
    }

    /**
     * Test incorrect response action
     *
     * @return void
     */
    public function testIncorrectResponse()
    {
        $this->_mockRequestHandler($this->returnValue(false));

        $this->dispatch('oggetto_payment/payment/response');
        $this->assertRequestRoute('oggetto_payment/payment/response');

        $this->assertResponseHttpCode(400);
    }

    /**
     * Test system exception response action
     *
     * @return void
     */
    public function testSystemExceptionResponse()
    {
        $this->_mockRequestHandler($this->throwException(new Mage_Exception('lol')));
        $this->dispatch('oggetto_payment/payment/response');
        $this->assertRequestRoute('oggetto_payment/payment/response');

        $this->assertResponseHttpCode(500);
    }
}
