<?php

class DBConn
    {

        /**
         * MySQL DB Connector
         * @return void
         */
        static public function _conn(): void
        {
            try {
                R::setup('mysql:host=localhost;dbname=competence',
                    'root', '');
            } catch (Exception $exception) {
                die($exception->getMessage());
            }
        }

    }