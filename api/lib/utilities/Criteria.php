<?php


class Criteria
    {
        const ID = 0;
        const TOKEN = 1;
        const ALPHA2  = 2;
        const ALPHA3 = 3;
        const CODE = 4;
        const NAMEFR = 5;
        const NAMEEN = 6;
        const OTHER = 7;
        const WRITING= 8;
        const NAME= 9;
        const SPEAKING = 10;
        const READING = 11; 
        const PHONE = 12;
        const YBIRTH = 13;
        const FSTNAME = 14;
        const PROFESSION = 15;
        const CITY = 16;
        const EMAIL = 17;
        const PASSWORD = 18;
        const SCHOOL = 19;
        const DIPLOMA = 20;
        const STUDYFIELD = 21;
        const COMPANY = 22;
        const POSITION = 23;
        





        /**
         * @param array|null $fields
         * @param array|null $REQUEST
         * @return void
         * @throws Exception
         */
        static public function _formRequiredCheck(?array $fields, ?array $REQUEST): void
        {
            if (empty($REQUEST))
                throw new Exception("Empty request not accepted here!");

            foreach ($fields as $field)
                if (!array_key_exists($field, $REQUEST))
                    throw new Exception("{$field} missing in your request!");

        }

    }