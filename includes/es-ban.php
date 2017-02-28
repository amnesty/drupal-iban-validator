<?php

    /***********************
    *** FROM: http://www.neleste.com/validar-ccc-con-php/
    ************************/
    function ccc_valido($ccc)
    {
        //$ccc sería el 20770338793100254321
        $valido = true;

        ///////////////////////////////////////////////////
        //    Dígito de control de la entidad y sucursal:
        //Se multiplica cada dígito por su factor de peso
        ///////////////////////////////////////////////////
        $suma = 0;
        $suma += $ccc[0] * 4;
        $suma += $ccc[1] * 8;
        $suma += $ccc[2] * 5;
        $suma += $ccc[3] * 10;
        $suma += $ccc[4] * 9;
        $suma += $ccc[5] * 7;
        $suma += $ccc[6] * 3;
        $suma += $ccc[7] * 6;

        $division = floor($suma/11);
        $resto    = $suma - ($division  * 11);
        $primer_digito_control = 11 - $resto;
        if($primer_digito_control == 11)
            $primer_digito_control = 0;

        if($primer_digito_control == 10)
            $primer_digito_control = 1;

        if($primer_digito_control != $ccc[8])
            $valido = false;

        ///////////////////////////////////////////////////
        //            Dígito de control de la cuenta:
        ///////////////////////////////////////////////////
        $suma = 0;
        $suma += $ccc[10] * 1;
        $suma += $ccc[11] * 2;
        $suma += $ccc[12] * 4;
        $suma += $ccc[13] * 8;
        $suma += $ccc[14] * 5;
        $suma += $ccc[15] * 10;
        $suma += $ccc[16] * 9;
        $suma += $ccc[17] * 7;
        $suma += $ccc[18] * 3;
        $suma += $ccc[19] * 6;

        $division = floor($suma/11);
        $resto = $suma-($division  * 11);
        $segundo_digito_control = 11- $resto;

        if($segundo_digito_control == 11)
            $segundo_digito_control = 0;
        if($segundo_digito_control == 10)
            $segundo_digito_control = 1;

        if($segundo_digito_control != $ccc[9])
            $valido = false;

        return $valido;
    }

   /*
    *   This function expects the different parts of an Spanish account as
    *   parameters: entity, office, check digits and account.
    *
    *   This function returns 1 if the check digit is correct. 0 if it is not.
    *
    *   Usage:
    *           echo isValidAccountNumber( '1234', '1234', '16', '1234567890' );
    *   Returns:
    *           TRUE
    */
    function isValidAccountNumber( $entity, $office, $CD, $account ) {
      echo $entity . " - " . $office . " - " . $CD . " - " . $account . "\n";
        $correctCD = "";

        if( respectsAccountPattern ( $entity, $office, $account ) ) {
            $correctCD = getBankAccountCheckDigits( $entity, $office, $account );
        }

        return ( ( $correctCD == $CD ) && ( $correctCD != "" ) );
    }

   /*
    *   This function expects the different parts of an Spanish account as
    *   parameters: entity, office and account.
    *
    *   This function returns the two check digits for the account number.
    *
    *   Usage:
    *           echo getBankAccountCheckDigits( '1234', '1234', '1234567890' );
    *   Returns:
    *           16
    */
    function getBankAccountCheckDigits( $entity, $office, $account ) {
        $entitySum = 0;
        $officeSum = 0;
        $accountSum = 0;

        $CD1 = "";
        $CD2 = "";

        if( respectsAccountPattern ( $entity, $office, $account ) ) {
            $entitySum =
                substr( $entity, 0, 1 ) * 4 +
                substr( $entity, 1, 1 ) * 8 +
                substr( $entity, 2, 1 ) * 5 +
                substr( $entity, 3, 1 ) * 10;

            $officeSum =
                substr( $office, 0, 1 ) * 9 +
                substr( $office, 1, 1 ) * 7 +
                substr( $office, 2, 1 ) * 3 +
                substr( $office, 3, 1 ) * 6;

            $CD1 = 11 - ( ( $entitySum + $officeSum ) % 11 );

            $accountSum =
                substr( $account, 0, 1 ) * 1 +
                substr( $account, 1, 1 ) * 2 +
                substr( $account, 2, 1 ) * 4 +
                substr( $account, 3, 1 ) * 8 +
                substr( $account, 4, 1 ) * 5 +
                substr( $account, 5, 1 ) * 10 +
                substr( $account, 6, 1 ) * 9 +
                substr( $account, 7, 1 ) * 7 +
                substr( $account, 8, 1 ) * 3 +
                substr( $account, 9, 1 ) * 6;

            $CD2 = 11 - ( $accountSum % 11 );

        }
        echo $CD1 . $CD2 . "\n";
        echo substr($CD1 . $CD2, 0, 2) . "\n";
        return substr($CD1 . $CD2, 0, 2);
    }

   /*
    *   This function validates the format of a Spanish account number.
    *   We consider that the correct format is:
    *       - A string of 4 characters lenght, only numbers, for the entity
    *       - A string of 4 characters lenght, only numbers, for the office
    *       - A string of 10 characters lenght, only numbers, for the account
    *
    *   This function does not validate the account check digits. Only validates
    *   its structure.
    *
    *   This function returns:
    *       TRUE: If specified string respects the pattern
    *       FALSE: Otherwise
    *
    *   Usage:
    *       echo respectsAccountPattern( '1234', '123A', '1234567890' );
    *   Returns:
    *       FALSE
    */
    function respectsAccountPattern( $entity, $office, $account ) {
        $isValid = TRUE;

        if( !preg_match( "/^[0-9][0-9][0-9][0-9]/", $entity ) ) {
            $isValid = FALSE;
        }
        if( !preg_match( "/^[0-9][0-9][0-9][0-9]/", $office ) ) {
            $isValid = FALSE;
        }
        if( !preg_match( "/^[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]/", $account ) ) {
            $isValid = FALSE;
        }
        return $isValid;
    }
?>
