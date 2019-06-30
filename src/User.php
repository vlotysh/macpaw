<?php

namespace Macpaw;


/**
 * Class User
 * @package Macpaw
 */
class User
{
    /**
     * @var string
     */
    private $id;

    /**
     * User constructor.
     * @param null $id
     */
    public function __construct($id = null)
    {
        if (!$id) {
            $id = uniqid();
        }

        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}
