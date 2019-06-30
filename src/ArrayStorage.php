<?php

namespace Macpaw;


/**
 * Class ArrayStorage
 * @package Macpaw
 */
class ArrayStorage implements StorageInterface
{
    /**
     * @var array
     */
    private $data = [];

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
}
