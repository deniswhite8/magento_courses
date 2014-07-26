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
 * Observer
 *
 * @category   Oggetto
 * @package    Oggetto_Question
 * @subpackage Model
 * @author     Denis Belov <dbelov@oggettoweb.com>
 */
class Oggetto_Question_Model_EmailSender
{
    /**
     * Send question
     *
     * @param Oggetto_Question_Model_Question $question Question
     * @return void
     */
    public function sendQuestion($question)
    {
        $email = $question->getEmail();
        $name = $question->getName();

        try {
            $emailTemplate = Mage::getModel('core/email_template')->load(1);

            $emailTemplateVariables = array(
                'name' => $question->getName(),
                'question' => $question->getText(),
                'answer' => $question->getAnswer(),
                'date' => $question->getTimestamp()
            );

            $from = 'general';
            $emailTemplate->setSenderEmail(Mage::getStoreConfig("trans_email/ident_{$from}/email"));
            $emailTemplate->setSenderName(Mage::getStoreConfig("trans_email/ident_{$from}/name"));
            $emailTemplate->setType('html');
            $emailTemplate->send($email, $name, $emailTemplateVariables);
        } catch (Exception $e) {
            Mage::logException($e);
        }
    }
}