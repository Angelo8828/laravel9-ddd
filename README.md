## Sample Laravel 9 Project with DDD Implementation

### About

Test project written on Laravel 9 with sample domain driven-design implementation, automated tests and API returns

### Prerequisites

- Docker

### Setup for Local Development

1. Create `.env` file by duplicating and renaming `.env.example` file. Replace database configs using these values below

```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel9-ddd-db
DB_USERNAME=user1
DB_PASSWORD=p@ssw0rd
```

2. Run `docker-compose up -d`

3. Enter PHP app container, through `docker exec -it laravel9-ddd-app bash`

4. Install Composer dependencies inside the container by running `composer install`

5. Run `php artisan key:generate` to generate application key

6. Run `php artisan migrate` to generate DB schemas

7. Run `php artisan db:seed` to generate sample users data

### Local URLs and Credentials

App URL: http://localhost:8001

PHPMyAdmin URL: http://localhost:8081

DB Credentials:
```
UN: root
PW: p@ssw0rd

UN: user1
PW: p@ssw0rd
```

### Usage and testing

#### Routes

Here is the list of the routes that I made

- /api/users (GET) - Fetching of users
- /api/users/`username`/followers (GET) - Fetching of followers, can accept `name` parameter to search followers
- /api/users/`username`/follow (POST) - Following of users, will need to accept `follower_id` as mandatory parameter
- /api/users/`username`/unfollow (POST) - Unfollowing of users, will need to accept `follower_id` as mandatory parameter

#### Setup for automated tests

1. Create `laravel9-ddd-db-test` database on MySQL (through PHPMyAdmin)

2. Create `.env.testing` file by duplicating and renaming `.env.teting.example` file. No need to replace or configure new values

3. Enter PHP app container, through `docker exec -it laravel9-ddd-app bash`, and run `php artisan test`

### Technical Notes

#### DDD vs Repository Pattern

For the fetching of users and followers, I used Repository pattern to implement it. Repository pattern is best for straigthforward fetching/manipulation of data.

I used Domain-Driven Design, or DDD, in the mechanics/functionality for following/unfollowing users. There's a lot of advantages of using DDD. Here it is as follows

- It can be really fault-tolerant if it has been coded and designed well, especially if it's supported by automated tests
- The code will not break if we try to switch or upgrade frameworks
- If transitioning from a monolith to a microservices structure, the domains can already act as a single API/microservice if needed
- If the usage of 3rd-party services has been minimized (like in our case where we did not used Eloquent ORM), there would also be minimal problems in reworking the feature in a different programming language

One of the disadvantages for DDD is that, we're reinventing the wheel in a way, especially if we opt to not use 3rd-party packages (like in our case, we did not used ORM in favor of PHP PDO)
