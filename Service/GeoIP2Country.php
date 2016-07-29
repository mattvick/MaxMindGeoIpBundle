<?php
namespace Insomnia\MaxMindGeoIpBundle\Service;

use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;
use MaxMind\Db\InvalidDatabaseException;

/**
 * GeoIP2 Country level wrapper
 *
 * If the record is not found, a \GeoIp2\Exception\AddressNotFoundException is thrown
 * If the database is invalid or corrupt, a \MaxMind\Db\InvalidDatabaseException will be thrown
 *
 * @author Matthew Vickery <vickery.matthew@gmail.com>
 *
 * @todo handle Exceptions / errors
 */
class GeoIP2Country
{
    /**
     * @var GeoIp2\Database\Reader
     */
    protected $reader;

    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * Get the continent
     *
     * @param string $ip the client's IP address
     * @return GeoIp2\Model\Country
     */
    public function getRecord($ip)
    {
        return $this->reader->country($ip);
    }

    /**
     * Get the traits
     *
     * @param string $ip the client's IP address
     * @return GeoIp2\Record\Traits
     */
    public function getTraits($ip)
    {
        $record = $this->reader->country($ip);

        return $record->traits;
    }

    /**
     * Get the continent
     *
     * @param string $ip the client's IP address
     * @return GeoIp2\Record\Continent
     */
    public function getContinent($ip)
    {
        $record = $this->reader->country($ip);

        return $record->continent;
    }

    /**
     * Get the country
     *
     * @param string $ip the client's IP address
     * @return GeoIp2\Record\Country
     */
    public function getCountry($ip)
    {
        $record = $this->reader->country($ip);

        return $record->country;
    }

    // maxmind
    // registeredCountry
    // representedCountry
    // locales

    /**
     * Get the continent's geonameid
     *
     * @param string $ip the client's IP address
     * @return int: the GeoName.org ID for the continent
     */
    // public function getContinentGeonameId($ip)
    // {
    //     $record = $this->reader->country($ip);

    //     return $record->continent->geonameId;
    // }

    /**
     * Get the continent's name
     *
     * @param string $ip the client's IP address
     * @return string: the continent's name
     */
    // public function getContinentName($ip)
    // {
    //     $record = $this->reader->country($ip);

    //     return $record->continent->name;
    // }

    /**
     * Get the continent's code
     *
     * @param string $ip the client's IP address
     * @return string: the code for the continent
     */
    // public function getContinentCode($ip)
    // {
    //     $record = $this->reader->country($ip);

    //     return $record->continent->code;
    // }

    /**
     * Get the country's name
     *
     * @param string $ip the client's IP address
     * @return int: the name of the country
     */
    // public function getCountryName($ip)
    // {
    //     $record = $this->reader->country($ip);

    //     return $record->country->name;
    // }

    /**
     * Get the country's geonameid
     *
     * @param string $ip the client's IP address
     * @return int: the GeoName.org ID for the country
     */
    // public function getCountryGeonameId($ip)
    // {
    //     $record = $this->reader->country($ip);

    //     return $record->country->geonameId;
    // }

    /**
     * Get the country's iso alpha 2 code
     *
     * @param string $ip the client's IP address
     * @return string: the iso alpha 2 code for the country
     */
    // public function getCountryIsoCode($ip)
    // {
    //     $record = $this->reader->country($ip);

    //     return $record->country->isoCode;
    // }
} 