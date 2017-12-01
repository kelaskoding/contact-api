<?php

class Contact extends DB\SQL\Mapper{
    
        public function __construct(\DB\SQL $db) {
            parent::__construct($db, 'tbl_contact');
        }

    }