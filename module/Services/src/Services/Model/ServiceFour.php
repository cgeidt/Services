<?php

namespace Services\Model;

use Zend\Json\Exception\InvalidArgumentException;

class ServiceFour extends Service
{

    static protected $name = 'ServiceFour';
    static protected $description = 'Splits a number into two factors';
    static protected $input = array('integer');
    static protected $output = array('integer', 'integer');

    static public function execute($params)
    {
        if (isset($params[0]) && is_int($params[0])) {
            $a = $params[0];
            $b = 1;

            if ($a > $b) {
                // number is > 1
                $unten = $b;
                $oben = $a;
                $unten++;
                while ($unten < $oben) {
                    if (($oben % $unten) == 0) {
                        $b = $unten;
                        $a = (int)($oben / $unten);
                        break;
                    } else {
                        $unten++;
                    }
                }
            } else if ($a < 0) {
                // number is < 0
                $unten = $b;
                $oben = $a * -1;
                $unten++;
                while ($unten < $oben) {
                    if (($oben % $unten) == 0) {
                        $b = $unten;
                        $a = -1 * (int)($oben / $unten);
                        break;
                    } else {
                        $unten++;
                    }
                }
            } else {
                // number is 0 or 1
                // do nothing
            }

            return array($a, $b);
        } else {
            throw new InvalidArgumentException('Invalid Arguments (requires int*int)');
        }
    }
}
