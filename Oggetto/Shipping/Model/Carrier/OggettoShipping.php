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
 * Oggetto shipping carrier model
 *
 * @category   Oggetto
 * @package    Oggetto_Shipping
 * @subpackage Block
 * @author     Denis Belov <dbelov@oggettoweb.com>
 */
class Oggetto_Shipping_Model_Carrier_OggettoShipping
    extends Mage_Shipping_Model_Carrier_Abstract
{
    /**
     * unique internal shipping method identifier
     *
     * @var string [a-z0-9_]
     */
    protected $_code = 'oggetto_shipping';

    /**
     * Collect rates for this shipping method based on information in $request
     *
     * @param Mage_Shipping_Model_Rate_Request $data
     * @return Mage_Shipping_Model_Rate_Result
     */
    public function collectRates(Mage_Shipping_Model_Rate_Request $request)
    {
        $webApi = Mage::getSingleton('oggetto_shipping/oggettoShippingApi');

        $locale = new Zend_Locale('ru_RU');

        $fromCountryId = $request->getCountryId();
        $toCountryId = $request->getDestCountryId();
        $fromRegionId = $request->getRegionId();
        $toRegionId = $request->getDestRegionId();

        $localeCode = Mage::app()->getLocale()->getLocaleCode();
        Mage::app()->getLocale()->setLocaleCode('ru_RU');

        $fromCountry = $locale->getTranslationList('Territory', $locale->getLanguage(), 2)[$fromCountryId];
        $fromRegion = Mage::getModel('directory/region')->load($fromRegionId)->getName();
        $fromCity = $request->getCity();

        $toCountry = $locale->getTranslationList('Territory', $locale->getLanguage(), 2)[$toCountryId];
        $toRegion = Mage::getModel('directory/region')->load($toRegionId)->getName();
        $toCity = $request->getDestCity();

        Mage::app()->getLocale()->setLocaleCode($localeCode);

        $methods = $webApi->calculatePrices(
            $fromCountry, $fromRegion, $fromCity,
            $toCountry, $toRegion, $toCity
        );

        $result = Mage::getModel('shipping/rate_result');
        $apiCurrencyCode = $webApi->getCurrencyCode();
        $currentCurrencyCode = Mage::app()->getStore()->getCurrentCurrencyCode();

        foreach ($methods as $name => $price) {
            $method = Mage::getModel('shipping/rate_result_method');
            $method->setCarrier($this->_code);
            $method->setCarrierTitle($this->getConfigData('title'));
            $method->setMethod($name);
            $method->setMethodTitle(ucfirst($name));

            $price = 1 / Mage::helper('directory')->currencyConvert(1 / $price, $currentCurrencyCode, $apiCurrencyCode);
            $price = Mage::app()->getStore()->roundPrice($price);

            $method->setPrice($price);
            $method->setCost($price);

            $result->append($method);
        }

        return $result;
    }

    /**
     * Get allowed methods
     *
     * @return array
     */
    public function getAllowedMethods()
    {
        return array(
            'standard' => 'Standard',
            'fast' => 'Fast',
        );
    }
}