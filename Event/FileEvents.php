<?php

namespace Octo\Azure\Event;

use b8\Config;
use Octo\Event\Listener;
use Octo\Event\Manager;

use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Blob\Models\CreateContainerOptions;
use WindowsAzure\Blob\Models\PublicAccessType;
use WindowsAzure\Common\ServiceException;

class FileEvents extends Listener
{
    /**
     * @var \WindowsAzure\Blob\Internal\IBlob
     */
    protected $blobProxy;
    protected $container = 'octo';

    public function registerListeners(Manager $manager)
    {
        $config = Config::getInstance()->get('Octo.Azure.BlobStorage');

        if (is_array($config) && array_key_exists('ConnectionString', $config)) {
            if (array_key_exists('Container', $config)) {
                $this->container = $config['Container'];
            }

            $this->blobProxy = ServicesBuilder::getInstance()->createBlobService($config['ConnectionString']);

            $manager->registerListener('GetFile', array($this, 'getFile'), false);
            $manager->registerListener('PutFile', array($this, 'putFile'), false);
        }
    }

    public function getFile(array &$file, &$continue)
    {
        try {
            $blob = $this->blobProxy->getBlob($this->container, $file['id']);
            $file['data'] = stream_get_contents($blob->getContentStream());
            $continue = false;
        } catch (ServiceException $ex) {
            $continue = true;
        }
    }

    public function putFile(array &$file, &$continue)
    {
        try {
            $this->blobProxy->createBlockBlob($this->container, $file['id'], $file['data']);
        } catch (ServiceException $ex) {
            $continue = false;
            return false;
        }

        return true;
    }
}
