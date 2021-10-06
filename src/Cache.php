<?php

declare(strict_types=1);

namespace TPG\Domains;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Cache
{
    protected Configuration $configuration;

    public function __construct()
    {
        $this->configuration = new Configuration();
    }

    public function remember(string $key, Carbon $expiry, \Closure $callback): mixed
    {
        if ($cache = $this->get($key)) {
            return $cache;
        }

        $this->store($key, $expiry, $data = $callback());

        return $data;
    }

    public function get(string $key): mixed
    {
        if (! $this->exists($key)) {
            return null;
        }

        $data = json_decode(
            file_get_contents($this->getCacheFilePath($key)),
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        if (Carbon::createFromTimestamp(Arr::get($data, 'expires'))->lt(Carbon::now())) {
            $this->forget($key);

            return null;
        }

        return unserialize(Arr::get($data, 'data'), ['allowed_classes' => false]);
    }

    public function store($key, Carbon $expiry, mixed $data): void
    {
        $cache = [
            'expires' => $expiry->timestamp,
            'data' => serialize($data),
        ];

        file_put_contents($this->getCacheFilePath($key), json_encode($cache, JSON_THROW_ON_ERROR));
    }

    public function forget($key): void
    {
        if ($this->exists($key)) {
            unlink($this->getCacheFilePath($key));
        }
    }

    public function clear(): void
    {
        $files = glob($this->configuration->getConfigurationDirectory().'cache/*');

        foreach ($files as $file) {
            unlink($file);
        }
    }

    protected function exists(string $key): bool
    {
        return file_exists($this->getCacheFilePath($key));
    }

    public function getCacheFilePath($key): string
    {
        return $this->configuration->getConfigurationDirectory().'cache/'.$key;
    }
}
