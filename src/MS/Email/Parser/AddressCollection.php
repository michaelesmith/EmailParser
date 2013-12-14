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
        $addresses = array();
        if(trim($addressesStr)){
            foreach(explode(',', $addressesStr) as $address){
                $addresses[] = new Address($address);
            }
        }

        parent::__construct($addresses);
    }

}
