<?php

namespace Macpaw;


/**
 * Class FileStorage
 * @package Macpaw
 */
class FileStorage implements StorageInterface
{
    /**
     * @const string
     */
    const STORAGE_FILE = __DIR__ . '/../ab_values.json';

    /**
     * @var array
     */
    private $data;

    /**
     * FileStorage constructor.
     */
    public function __construct()
    {
        $this->data = $this->readStorageFile();
    }

    /**
     *
     */
    public function __destruct()
    {
        $this->writeFile();
    }

    /**
     * @param $data
     * @return bool
     */
    public function store($data): bool
    {
        $user = $data['user'];
        $abCase = $data['ab_case'];

        if (!isset($this->data[$user->getId()])) {
            $this->data[$user->getId()] = $abCase;
        }

        return true;
    }

    /**
     * @param $data
     * @return null|string
     */
    public function retrieve($data):? string
    {
        $user = $data['user'];

        if (isset($this->data[$user->getId()])) {
           return $this->data[$user->getId()];
        }

        return null;
    }

    /**
     * @return array
     */
    private function readStorageFile(): array
    {
        $content = file_get_contents(self::STORAGE_FILE);

        if ($content === false || empty($content)) {
            return [];
        }

        return json_decode($content, true);
    }

    /**
     * @return bool
     */
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
