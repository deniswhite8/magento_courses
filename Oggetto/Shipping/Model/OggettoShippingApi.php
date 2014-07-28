<?php
/**
 * Oggetto shipping extension for Magento
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
 * @package   Oggetto_Shipping
 * @copyright Copyright (C) 2014, Oggetto Web (http://oggettoweb.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
?>
<?php
/**
 * Oggetto shipping web API
 *
 * @category   Oggetto
 * @package    Oggetto_Shipping
 * @subpackage Block
 * @author     Denis Belov <dbelov@oggettoweb.com>
 */
class Oggetto_Shipping_Model_OggettoShippingApi
{
    /**
     * Api URL
     *
     * @var string
     */
    protected $_url = 'http://new.oggy.co/shipping/api/rest.php';
    protected $_httpClient;

    /**
     * Calculate price
     *
     * @param string $region
     * @return Mage_Shipping_Model_Rate_Result
     */
    public function calculatePrices($fromCountry, $fromRegion, $fromCity,
                                   $toCountry, $toRegion, $toCity)
    {
        if (!$this->_httpClient) {
            $this->_httpClient = new Varien_Http_Client($this->_url);
        }

        $this->_httpClient->setParameterGet(
            array(
                'from_country' => $fromCountry,
                'from_region' => $fromRegion,
                'from_city' => $fromCity,
                'to_country' => $toCountry,
                'to_region' => $toRegion,
                'to_city' => $toCity
            )
        );

        $response = $this->_httpClient->request(Varien_Http_Client::GET);

        if ($response->getStatus() == 200) {
            $responseData = Mage::helper('core')->jsonDecode($response->getBody());
            if ($responseData['status'] === 'success') {
                return $responseData['prices'];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Get currency code
     *
     * @return string
     */
    public function getCurrencyCode()
    {
        return 'RUB';
    }
}