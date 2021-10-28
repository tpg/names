<?php

declare(strict_types=1);

namespace TPG\Domains;

use Exception;
use Illuminate\Support\Arr;

class Configuration
{
    protected array $config;

    public function __construct()
    {
        $this->config = $this->getConfiguration();
    }

    public function isConfigured(): bool
    {
        return file_exists($this->getConfigurationDirectory().'config.json');
    }

    public function key(): string
    {
        return Arr::get($this->config, 'reseller.key');
    }

    public function testing(): bool
    {
        return Arr::get($this->config, 'reseller.testing');
    }

    protected function getConfiguration(): array
    {
        $path = $this->getConfigurationDirectory().'config.json';

        if (! file_exists($path)) {
            throw new Exception('No configuration. Run install');
        }

        return json_decode(
            file_get_contents($this->getConfigurationDirectory().'config.json'),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }

    public function createConfiguration(array $config): void
    {
        $path = $this->getConfigurationDirectory().'config.json';

        file_put_contents($path, json_encode($config, JSON_THROW_ON_ERROR));
    }

    public function getConfigurationDirectory(): string
    {
        return posix_getpwuid(fileowner(__FILE__))['dir'].'/.domains/';
    }

}
