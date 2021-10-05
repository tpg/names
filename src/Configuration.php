<?php

declare(strict_types=1);

namespace TPG\Domains;

use Illuminate\Support\Arr;

class Configuration
{
    public function key(): string
    {
        $config = $this->getConfiguration();

        return Arr::get($config, 'reseller.key');
    }

    protected function getConfiguration(): array
    {
        $path = $this->getConfigurationDirectory().'config.json';

        if (! file_exists($path)) {
            throw new \Exception('No configuration. Run install');
        }

        return json_decode(
            file_get_contents($this->getConfigurationDirectory().'config.json'),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }

    protected function getConfigurationDirectory(): string
    {
        return posix_getpwuid(fileowner(__FILE__))['dir'].'/.domains/';
    }

}
