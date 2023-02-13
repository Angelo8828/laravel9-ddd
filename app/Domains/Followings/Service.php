<?php

namespace App\Domains\Followings;

use App\Domains\Followings\Entities\Following;

use App\Domains\Followings\Exceptions\AlreadyExistingException;
use App\Domains\Followings\Exceptions\NotFoundException;
use App\Domains\Followings\Exceptions\SameIDException;
use App\Domains\Followings\Exceptions\UnexpectedErrorException;
use App\Domains\Followings\Exceptions\UserNotFoundException;

use App\Domains\Followings\Specs\FollowInputSpec;
use App\Domains\Followings\Specs\FollowOutputSpec;
use App\Domains\Followings\Specs\UnfollowInputSpec;
use App\Domains\Followings\Specs\UnfollowOutputSpec;

use App\Domains\Followings\RepositoryInterface;
use App\Domains\Followings\ServiceInterface;

class Service implements ServiceInterface
{
    protected $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Method for following users
     *
     * @param FollowInputSpec $input
     *
     * @return FollowOutputSpec
     */
    public function follow(FollowInputSpec $input): FollowOutputSpec
    {
        try {
            $output = new FollowOutputSpec();

            $user = $this->repository->getByUsername($input->followeeUsername);

            if (!$user) {
                throw UserNotFoundException::make();
            }

            $now = new \DateTime();

            $following = new Following();

            $following->followeeId = $user->id;
            $following->followerId = $input->followerId;
            $following->createdAt  = $now->format('Y-m-d H:i:s');
            $following->updatedAt  = $now->format('Y-m-d H:i:s');

            if ($following->followeeId == $following->followerId) {
                throw SameIDException::make();
            }

            $isExisting = $this->repository->get($following);

            if ($isExisting) {
                throw AlreadyExistingException::make();
            }

            $following = $this->repository->save($following);

            $output->following = $following;

            return $output;
        } catch (AlreadyExistingException $exception) {
            throw $exception;
        } catch (UserNotFoundException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            throw new UnexpectedErrorException('unexpected error', 0, $exception);
        }
    }

    /**
     * Method for unfollowing users
     *
     * @param UnfollowInputSpec $input
     *
     * @return UnfollowOutputSpec
     */
    public function unfollow(UnfollowInputSpec $input): UnfollowOutputSpec
    {
        try {
            $output = new UnfollowOutputSpec();

            $user = $this->repository->getByUsername($input->followeeUsername);

            if (!$user) {
                throw UserNotFoundException::make();
            }

            $following = new Following();

            $following->followeeId = $user->id;
            $following->followerId = $input->followerId;

            $following = $this->repository->get($following);

            if (!$following) {
                throw NotFoundException::make();
            }

            $output->result = $this->repository->delete($following);

            return $output;
        } catch (NotFoundException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            throw new UnexpectedErrorException('unexpected error', 0, $exception);
        }
    }
}
