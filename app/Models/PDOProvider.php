<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PDOProvider extends Model
{
    /**
     * @return \PDO
     */
    public function getPdo()
    {
        return $this->getConnection()->getPdo();
    }
}
