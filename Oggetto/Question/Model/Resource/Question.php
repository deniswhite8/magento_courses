<?php

class Oggetto_Question_Model_Resource_Question extends Mage_Core_Model_Resource_Db_Abstract {

    public function _construct()
    {
        $this->_init('question/question', 'question_id');
    }
}