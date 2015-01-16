<?php

namespace MS\Email\Parser;

use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;

/**
 * @author msmith
 * @author sebastien monterisi <sebastienmonterisi@yahoo.fr>
 */
class AddressCollection extends ArrayCollection implements JsonSerializable {

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

    public function jsonSerialize()
    {
        return $this->getValues();
    }

}
