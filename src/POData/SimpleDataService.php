<?php

declare(strict_types=1);

namespace POData;

use POData\Common\ODataException;
use POData\Configuration\EntitySetRights;
use POData\Configuration\IServiceConfiguration;
use POData\ObjectModel\IObjectSerialiser;
use POData\OperationContext\ServiceHost;
use POData\Providers\Metadata\IMetadataProvider;
use POData\Providers\Metadata\SimpleMetadataProvider;
use POData\Providers\Query\IQueryProvider;
use POData\Providers\Query\SimpleQueryProvider;
use POData\Providers\Stream\IStreamProvider2;
use POData\Providers\Stream\SimpleStreamProvider;

/**
 * DataService that implements IServiceProvider.
 **/
class SimpleDataService extends BaseService implements IService
{
    /**
     * @var IMetadataProvider
     */
    protected $metaProvider;
    /**
     * @var IQueryProvider
     */
    protected $queryProvider;

    /**
     * @var IStreamProvider2;
     */
    protected $streamProvider;
    public $maxPageSize = 400;

    /**
     * SimpleDataService constructor.
     * @param $db
     * @param  SimpleMetadataProvider $metaProvider
     * @param  ServiceHost            $host
     * @param  IObjectSerialiser|null $serialiser
     * @param  IStreamProvider2|null  $streamProvider
     * @throws ODataException
     */
    public function __construct(
        $db,
        SimpleMetadataProvider $metaProvider,
        ServiceHost $host,
        IObjectSerialiser $serialiser = null,
        IStreamProvider2 $streamProvider = null
    ) {
        $this->metaProvider = $metaProvider;
        if ($db instanceof IQueryProvider) {
            $this->queryProvider = $db;
        } elseif (!empty($db->queryProviderClassName)) {
            $queryProviderClassName = $db->queryProviderClassName;
            $this->queryProvider    = new $queryProviderClassName($db);
        } else {
            throw new ODataException('Invalid query provider supplied', 500);
        }
        $this->setStreamProvider($streamProvider);

        $this->setHost($host);
        parent::__construct($serialiser);
    }

    /**
     * {@inheritdoc}
     * @throws Common\InvalidOperationException
     */
    public function initialize(IServiceConfiguration $config)
    {
        $config->setEntitySetPageSize('*', $this->maxPageSize);
        $config->setEntitySetAccessRule('*', /* @scrutinizer ignore-type */EntitySetRights::ALL);
        $config->setAcceptCountRequests(true);
        $config->setAcceptProjectionRequests(true);
    }

    /**
     * @return IQueryProvider
     */
    public function getQueryProvider(): ?IQueryProvider
    {
        return $this->queryProvider;
    }

    /**
     * @return IMetadataProvider
     */
    public function getMetadataProvider()
    {
        return $this->metaProvider;
    }

    /**
     * @param  IStreamProvider2|null $streamProvider
     * @return void
     */
    public function setStreamProvider(IStreamProvider2 $streamProvider = null)
    {
        $this->streamProvider = (null == $streamProvider) ? new SimpleStreamProvider() : $streamProvider;
    }
    /**
     * @return IStreamProvider2
     */
    public function getStreamProviderX()
    {
        return $this->streamProvider;
    }

    /**
     * This method is called only once to initialize service-wide policies.
     *
     * @param IServiceConfiguration $config data service configuration
     */
    public function initializeService(IServiceConfiguration $config)
    {
        $config->setEntitySetAccessRule('*', /* @scrutinizer ignore-type */EntitySetRights::ALL);
    }
}
