# TailwindGram Laravel Rest API

a written rest api based on my other Tailwindgram project.

> the project uses sanctum api tokens

## register and log in to your account

request: `http://sitename/api/login?email=yspinka@example.com&password=password`
response:

```json
{
    "message": "Welcome back, amber.klein!",
    "token": "generated api-token"
}
```
request: `http://sitename/api/login?email=example@example.com&password=password&username=example`
response:

```json
{
    "message": "User created successfully",
    "token": "generated api-token"
}
```

>when generating tokens, the role of the user is taken into account and, in accordance with it, a token is issued that is endowed with one or another persmission


briefly on its functionality:

## Getting all approved posts
that is, to see the post you need approval from the admin. 

request: `http://sitename/api/posts/`
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

request: `http://sitename/api/posts/1`
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

request: `http://sitename/api/posts/1?comments=true`
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

request: `http://sitename/api/posts/6?access=1`

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