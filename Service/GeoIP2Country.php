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
} 