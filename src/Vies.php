<?php

namespace Depsimon\Vies;

use SoapClient;

class Vies
{
    /**
     * Endpoint of the VIES Service
     */
    const ENDPOINT = 'http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl';

    /**
     * Executes the checkVat service on the SoapClient
     * @param  string $countryCode The ISO-2 country code
     * @param  string $vatNumber   The vat number without the country code
     * @return mixed  $response    The response of the service
     */
    static function checkVat($countryCode, $vatNumber)
    {
        try {
            $response = (new SoapClient( self::ENDPOINT, ['connection_timeout' => 10]))->checkVat(compact('countryCode', 'vatNumber'));
        } catch (SoapFault $e) {
            throw new ViesException('Error communicating with VIES service', 0, $e);
        }

        return $response;
    }

    /**
     * Checks wether the vat number is valid or not
     * @param  string $countryCode The ISO-2 country code
     * @param  string $vatNumber   The vat number without the country code
     * @return bool
     */
    static function isVatValid(...$args)
    {
        return (bool) self::checkVat(...$args)->valid;
    }

    /**
     * Returns information on the business if it's found
     * @param  string $countryCode The ISO-2 country code
     * @param  string $vatNumber   The vat number without the country code
     * @return array               All info available on the business
     */
    static function getInfo(...$args)
    {
        $response = self::checkVat(...$args);

        return [
            'countryCode' => $response->countryCode,
            'vatNumber' => $response->vatNumber,
            'valid' => $response->valid,
            'name' => $response->name,
            'address' => $response->address
        ];
    }
}