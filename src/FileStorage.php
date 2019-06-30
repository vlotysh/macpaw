<?php

namespace Macpaw;


class FileStorage implements StorageInterface
{
    const STORAGE_FILE = __DIR__ . '/../ab_values.json';

    private $data;

    public function __construct()
    {
        $this->data = $this->readStorageFile();
    }

    public function __destruct()
    {
        $this->writeFile();
    }

    public function store($data): bool
    {
        $user = $data['user'];
        $abCase = $data['ab_case'];

        if (!isset($this->data[$user->getId()])) {
            $this->data[$user->getId()] = $abCase;
        }

        return true;
    }

    public function retrieve($data):? string
    {
        $user = $data['user'];

        if (isset($this->data[$user->getId()])) {
           return $this->data[$user->getId()];
        }

        return null;
    }

    private function readStorageFile(): array
    {
        $content = file_get_contents(self::STORAGE_FILE);

        if ($content === false) {
            return [];
        }

        return json_decode($content, true);
    }

    private function writeFile(): bool
    {
        $json = json_encode($this->data);

        $result = file_put_contents(self::STORAGE_FILE, $json);

        if ($result !== false) {
            return false;
        }

        return true;
    }
}
