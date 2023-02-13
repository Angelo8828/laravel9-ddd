<?php

namespace App\Domains\Followings\Entities;

class Following
{
    /** @var int */
    public $id;
    /** @var int */
    public $followeeId;
    /** @var int */
    public $followerId;

    /** @var \DateTime */
    public $createdAt;
    /** @var \DateTime */
    public $updatedAt;

    protected static array $fieldMap = [
        'id'         => 'id',
        'followeeId' => 'followee_id',
        'followerId' => 'follower_id',
        'createdAt'  => 'created_at',
        'updatedAt'  => 'updated_at',
    ];

    /**
     * Convert object to assoc. array
     *
     * @return array
     */
    public function toArray(): array
    {
        $result = [];

        foreach (self::$fieldMap as $prop => $field) {
            if (property_exists($this, $prop)) {
                $result[$prop] = $this->$prop;
            }
        }

        return $result;
    }
}
