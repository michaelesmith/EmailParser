<?php
/**
 * Created by PhpStorm.
 * User: msmith
 * Date: 12/13/13
 * Time: 9:32 PM
 */

namespace MS\Email\Parser;

use Doctrine\Common\Collections\ArrayCollection;

class AddressCollection extends ArrayCollection {

    public function __construct($addressesStr)
    {
        if(!is_array($addressesStr)){
            $addresses = array();
            if(trim($addressesStr)){
                foreach(explode(',', $addressesStr) as $address){
                    $addresses[] = new Address($address);
                }
            }
        }else{
            $addresses = $addressesStr;
        }

        parent::__construct($addresses);
    }

}
