<?php

namespace App\Domains\Followings;

use App\Domains\Followings\Entities\Following;
use App\Domains\Followings\Entities\User;

use App\Models\PDOProvider;

use PDO;

class Repository implements RepositoryInterface
{
    private $PDOProvider;
    private PDO $dbh;

    /**
     * Class constructor
     *
     * @param PDOProvider $PDOProvider
     */
    public function __construct(PDOProvider $PDOProvider)
    {
        $this->PDOProvider = $PDOProvider;
    }

    /**
     * Get following
     *
     * @param Following $following
     *
     * @return Following
     */
    public function get(Following $following): ?Following
    {
        $selectData = [
            'followee_id' => $following->followeeId,
            'follower_id' => $following->followerId,
        ];

        $selectSql = "SELECT * FROM followings WHERE followee_id=:followee_id AND follower_id=:follower_id";

        $stmt = $this->getDBH()->prepare($selectSql);
        $stmt->execute($selectData);

        $result = $stmt->fetch();

        if (!$result) {
            return null;
        }

        $following->id         = $result['id'];
        $following->created_at = $result['created_at'];
        $following->updated_at = $result['updated_at'];

        return $following;
    }

    /**
     * Save following
     *
     * @param Following $following
     *
     * @return Following
     */
    public function save(Following $following): Following
    {
        $insertData = [
            'followee_id' => $following->followeeId,
            'follower_id' => $following->followerId,
            'created_at'  => $following->createdAt,
            'updated_at'  => $following->updatedAt
        ];

        $insertSql = "INSERT INTO followings (followee_id, follower_id, created_at, updated_at) VALUES (:followee_id, :follower_id, :created_at, :updated_at)";

        $stmt = $this->getDBH()->prepare($insertSql);
        $stmt->execute($insertData);

        $following->id = $this->getDBH()->lastInsertId();

        return $following;
    }

    /**
     * Delete following
     *
     * @param Following $following
     *
     * @return bool
     */
    public function delete(Following $following): bool
    {
        $deleteData = ['id' => $following->id];

        $deleteSql = "DELETE FROM followings WHERE id = :id";

        $stmt = $this->getDBH()->prepare($deleteSql);
        $stmt->execute($deleteData);

        return true;
    }

    /**
     * Get user by username
     *
     * @param string $username
     *
     * @return User
     */
    public function getByUsername(string $username): ?User
    {
        $stmt = $this->getDBH()->prepare('SELECT * FROM users WHERE users.username = ?');
        $stmt->execute([$username]);

        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        $user = new User();

        $user->id       = $data['id'];
        $user->name     = $data['name'];
        $user->username = $data['username'];
        $user->email    = $data['email'];

        return $user;
    }

    /**
     * Get PDO connection
     *
     * @return \PDO
     */
    protected function getDBH()
    {
        if (!isset($this->dbh)) {
            $this->dbh = $this->PDOProvider->getPdo();
        }

        return $this->dbh;
    }
}
