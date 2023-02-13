<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Domains\Followings\Exceptions\AlreadyExistingException;
use App\Domains\Followings\Exceptions\NotFoundException;
use App\Domains\Followings\Exceptions\UnexpectedErrorException;
use App\Domains\Followings\Exceptions\UserNotFoundException;

use App\Domains\Followings\Specs\FollowInputSpec;
use App\Domains\Followings\Specs\FollowOutputSpec;
use App\Domains\Followings\Specs\UnfollowInputSpec;
use App\Domains\Followings\Specs\UnfollowOutputSpec;

use App\Domains\Followings\ServiceInterface as FollowingService;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Resources\UserResource;

use App\Repositories\UsersRepository;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UsersController extends Controller
{
    /**
     * The property that will contain the App\Repositories\UsersRepository.
     *
     * @var object
     */
    protected $repository;

    /**
     * The property that will contain the Illuminate\Http\Request.
     *
     * @var object
     */
    protected $request;

    /**
     * The property that will contain the App\Domains\Followings\ServiceInterface.
     *
     * @var object
     */
    protected $service;

    /**
     * Class constructor.
     *
     * @param object $repository Instance of App\Repositories\UsersRepository
     * @param object $request    Instance of Illuminate\Http\Request
     * @param object $service    Instance of App\Domains\Followings\ServiceInterface
     */
    public function __construct(
        UsersRepository $repository,
        Request $request,
        FollowingService $service
    ) {
        $this->repository = $repository;
        $this->request = $request;
        $this->service = $service;
    }

    /**
     * Get all users
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection($this->repository->all());
    }

    /**
     * Follow user
     *
     * @param string $userName
     *
     * @return mixed
     */
    public function doFollow(string $userName): mixed
    {
        $spec = new FollowInputSpec();

        $spec->followeeUsername = $userName;
        $spec->followerId = $this->request->get('follower_id');

        $output = $this->service->follow($spec);

        return $output->following->toArray();
    }

    /**
     * Unfollow user
     *
     * @param string $userName
     *
     * @return mixed
     */
    public function doUnfollow(string $userName): mixed
    {
        $spec = new UnfollowInputSpec();

        $spec->followeeUsername = $userName;
        $spec->followerId = $this->request->get('follower_id');

        $output = $this->service->unfollow($spec);

        return $output->result;
    }

    /**
     * Get followers by username, with name filtering option
     *
     * @param string $userName
     *
     * @return AnonymousResourceCollection
     */
    public function followers(string $userName): AnonymousResourceCollection
    {
        $followers = $this->repository->followers($userName, $this->request->has('name') ? $this->request->get('name') : '');

        return UserResource::collection($followers);
    }
}
