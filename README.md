# TailwindGram Laravel Rest API

a written rest api based on my other Tailwindgram project.

> the project uses sanctum api tokens

## Installation

First clone this repository, install the dependencies, and setup your .env file.

```
git clone git@github.com:algrvvv/twgRestApi.git blog
composer install
cp .env.example .env
```

Then create the necessary database. <br>
And run the initial migrations and seeders.

```
php artisan migrate --seed
```

## register and login to your account

`POST` request: `http://sitename/api/login?email=admin@example.com&password=password`<br>
response:

```json
{
    "message": "Welcome back, admin!",
    "token": "generated api-token"
}
```
`POST` request: `http://sitename/api/register?email=example@example.com&password=password&username=example`<br>
response:

```json
{
    "message": "User created successfully",
    "token": "generated api-token"
}
```

>when generating tokens, the role of the user is taken into account and, in accordance with it, a token is issued that is endowed with one or another persmission

>after logging in to your account, [approve any post](#admin-approval-of-the-post)


briefly on its functionality:

## Getting all approved posts
that is, to see the post you need approval from the admin. 

`GET` request: `http://sitename/api/posts/`<br>
response:
```json
{
    "data": [
        {
            "id": 1,
            "title": "Pariatur non quibusdam qui.",
            "content": "Doloremque aut consequatur saepe pariatur culpa. Sit magni sunt tenetur consequatur id a. Ea qui autem fugiat qui ad est similique.",
            "views": "0",
            "author": "amber.klein",
            "created_at": "2023-10-04T15:33:17.000000Z"
        },

        { "other" : "posts" }
    ]
}
```

## Getting a certain post

`GET` request: `http://sitename/api/posts/1`<br>
response:

```json
{
    "data": {
        "id": 1,
        "title": "Pariatur non quibusdam qui.",
        "content": "Doloremque aut consequatur saepe pariatur culpa. Sit magni sunt tenetur consequatur id a. Ea qui autem fugiat qui ad est similique.",
        "views": "0",
        "author": "amber.klein",
        "created_at": "2023-10-04T15:33:17.000000Z"
    }
}
```

## Getting all comments on a post

`GET` request: `http://sitename/api/posts/1?comments=true`<br>
response:
```json
{
    "data": {
        "id": 1,
        "title": "Pariatur non quibusdam qui.",
        "content": "Doloremque aut consequatur saepe pariatur culpa. Sit magni sunt tenetur consequatur id a. Ea qui autem fugiat qui ad est similique.",
        "views": "0",
        "author": "amber.klein",
        "created_at": "2023-10-04T15:33:17.000000Z",
        "comments": [
            {
                "id": 1,
                "post_id": 1,
                "author": "dbraun",
                "title": "ullam et similique iusto ducimus aut",
                "content": "Tenetur id quam nulla ad deleniti a voluptas. Quia temporibus earum tenetur dolorem corrupti dolor et. Explicabo omnis commodi quia veniam dolorem placeat et. Nam vitae fuga non expedita dolor eaque in. Cumque libero velit qui in incidunt.",
                "created_at": "2023-10-04T15:33:18.000000Z"
            }
        ]
    }
}
```

>the display of comments can be used during the output of all posts, simply using the same query

## Admin approval of the post

>to do this, you need to have a token that has the necessary permissions and send a PATH request with the header `access = 1`

`PATH` request: `http://sitename/api/posts/6?access=1` <br>

in case of success, response:
```json
{
    "message": "post has been publishing"
}
```
otherwise:

```json
{
    "message": "Invalid ability provided.",
}
```

>after that, the post will be visible on request `http://sitename/api/posts/`

## Adding comments

`POST` request: `http://sitename/api/posts/2/comment?title=title&content=content` <br>
response:

```json
{
    "data": {
        "id": 25,
        "post_id": "2",
        "author": "username",
        "title": "title",
        "content": "content",
        "created_at": "2023-10-05T07:47:35.000000Z"
    }
}
```

>it is important to have a token that has the authority to create comments

## Deleting posts

`DELETE `request: `http://sitename/api/posts/3` <br>
in case of success, response:

```json
{
    "message": "post has been deleted"
}
```

otherwise:

```json
{
    "message": "you dont have a permisson"
}
```