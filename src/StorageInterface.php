<?php

namespace Macpaw;

/**
 * Interface StorageInterface
 * @package Macpaw
 */
interface StorageInterface
{
    /**
     * @param $data
     * @return mixed
     */
    public function store($data);

    /**
     * @param $data
     * @return mixed
     */
    public function retrieve($data);
}
