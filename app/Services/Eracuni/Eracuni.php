<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 15.10.2018.
 * Time: 09:37
 */

namespace App\Services\Eracuni;


class Eracuni
{

    private $username;
    private $password;
    private $token;

    /**
     * Eracuni constructor.
     * @param string $username
     * @param string $password
     * @param string $token
     */
    function __construct($username, $password, $token)
    {
        $this->username = $username;
        $this->password = $password;
        $this->token = $token;
    }

    /**
     * @param $partnerCode
     * @return string
     * @throws EracuniException
     */
    public function PartnerGetByCode($partnerCode)
    {
        $params = '<method name="PartnerGetByCode">
                        <parameter name="partnerCode" value="' . $partnerCode . '" />
                   </method>';

        return $this->execute($params);
    }

    /**
     * @param $params
     * @return string
     * @throws EracuniException
     */
    private function execute($params)
    {
        $string = '<?xml version="1.0" encoding="UTF-8"?>
       <request>
       <login username="' . $this->username . '" md5pass="' . $this->password . '" token="' . $this->token . '" />
        ' . $params . '
       </request>';

        $serverUrl = env('ERACUNI_API_URL');
        $ch = curl_init($serverUrl);
        curl_setopt($ch, CURLOPT_HEADER, ("Content-Type: application/xml"));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = htmlentities(curl_exec($ch));

        $curl_errno = curl_errno($ch);
        $curl_error = curl_error($ch);

        curl_close($ch);
        if ($curl_errno > 0) {
            throw new EracuniException('cURL Error: ' . $curl_errno);
        } else {
            return $data;
        }
    }

    /**
     * @param $data
     * @return string
     * @throws EracuniException
     */
    public function PartnerCreate($data)
    {

        $params = '<method name="PartnerCreate">
                       <parameter name="partner">
                               <companyType>' . $data['companyType'] . '</companyType>
                               <dateOfBirth>' . $data['dateOfBirth'] . '</dateOfBirth>
                               <eMail>' . $data['eMail'] . '</eMail>
                               <firstName>' . $data['firstName'] . '</firstName>
                               <gender>' . $data['gender'] . '</gender>     
                               <ID>' . $data['ID'] . '</ID>   
                               <lastName>' . $data['lastName'] . '</lastName>
                               <maritalStatus>' . $data['maritalStatus'] . '</maritalStatus>
                               <mobilePhone>' . $data['mobilePhone'] . '</mobilePhone>
                               <partnerCode>' . $data['partnerCode'] . '</partnerCode>
                               <vatRegistration>' . $data['vatRegistration'] . '</vatRegistration>   
                               <Addresses>
                                       <Address>
                                               <city>' . $data['city'] . '</city>
                                               <country>' . $data['country'] . '</country>
                                               <postalCode>' . $data['postalCode'] . '</postalCode>
                                               <street>' . $data['street'] . '</street>
                                               <telephone>' . $data['telephone'] . '</telephone>
                                               <type>' . $data['type'] . '</type>  
                                       </Address>
                               </Addresses>
                               <BuyerData><buyerCode>' . $data['partnerCode'] . '</buyerCode></BuyerData>
                        </parameter>
                </method>';

        return $this->execute($params);
    }

    /**
     * @param $invoiceNumber
     * @return string
     * @throws EracuniException
     */
    public function SalesInvoiceGet($invoiceNumber)
    {
        $params = '<method name="SalesInvoiceGet">
                           <parameter name="number" value="' . $invoiceNumber . '" />
                    </method>';

        return $this->execute($params);
    }

    /**
     * @param $data
     * @return string
     * @throws EracuniException
     */
    public function SalesInvoiceCreate($data)
    {
        $params = '<method name="SalesInvoiceCreate">
                       <parameter name="SalesInvoice">         
                           <date>' . $data['date'] . '</date>
                           <dateOfSupplyFrom>' . $data['dateOfSupplyFrom'] . '</dateOfSupplyFrom>
                           <expirationDate>' . $data['expirationDate'] . '</expirationDate>             
                           <city>' . $data['city'] . '</city>
                           <isReccurringInvoice>false</isReccurringInvoice>
                           <buyerCode>' . $data['buyerCode'] . '</buyerCode>
                           <methodOfPayment>unknown</methodOfPayment>
                           <Items>
                               <Item>
                                   <productCode>' . $data['productCode'] . '</productCode>
                                   <quantity>' . $data['quantity'] . '</quantity>
                                   <discountPercentage>' . $data['discountPercentage'] . '</discountPercentage>
                               </Item>
                           </Items>
                        </parameter>
                    </method>';

        return $this->execute($params);
    }
}