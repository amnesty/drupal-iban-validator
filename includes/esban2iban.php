<?php

/**
 * @copyright (c)2015 Intervia IT
 * @link http://intervia.com/doc/convertir-cuentas-de-formato-ccc-a-iban/
 * @license MIT http://opensource.org/licenses/MIT
 */

  //Incluye el paquete para cálculo con grandes números
  include_once "math/BigInteger.php";

  function esban_to_iban($cc){

    $es_iso = '142800'; // Código ISO ES + 00
    $bban_es = $cc.$es_iso; // CC + ES + 00

    $a = new Math_BigInteger($bban_es); //Dividendo
    $b = new Math_BigInteger('97'); //Divisor (97)
    list($cociente, $resto) = $a->divide($b); //Carga el resultado en dos variables
    //$cociente->toString(); //El cociente no es necesario

    //Obtiene el resto y lo resta de 98 para obtener el dígito de control,
    //sacando siempre 2 dígitos
    $ibandc = str_pad(98 - $resto->toString(),2,0,STR_PAD_LEFT);
    $iban = 'ES'.$ibandc.$cc; //El código IBAN es el código ISO de país más el DC

    return $iban;
  }

 ?>
