<?php
class Oggetto_Question_Block_Form extends Mage_Core_Block_Template
{
    public function getSendUrl()
    {
        return Mage::getUrl('question/index/send');
    }
}