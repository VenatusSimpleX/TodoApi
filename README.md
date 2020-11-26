# Todo API

An api for simple todo CRUD with basic JWT auth

## Endpoints

Generally speaking, if the API call was successful, then it will return some data with `200 OK` status.

### Profile

-   `POST /api/profile/register` - registers a user, `409 Conflict` if username is already taken.
-   `POST /api/profile/login` - logs in to a user, `401 Unauthorized` if credentials are incorrect.
-   `POST /api/profile/logout` - logs out to a user, `401 Unauthorized` if not logged in.
-   `GET /api/profile` - get current signed in user, `401 Unauthorized` if not logged in.
-   `DELETE /api/profile` - deletes current signed in user and all the todo's associated with the user, `401 Unauthorized` if not logged in.

### Todo

-   `GET /api/todos` - get current user's todo list, `401 Unauthorized` if not logged in.
-   `POST /api/todos` - create new todo for current user, `401 Unauthorized` if not logged in.
-   `GET /api/todos/{todoHash}` - read specific todo,
    -   `401 Unauthorized` if user is not logged in.
    -   `404 Not Found` if todo does not exist or if user does not own the todo.
-   `PUT /api/todos/{todoHash}` - update specific todo,
    -   `401 Unauthorized` if user is not logged in.
    -   `404 Not Found` if todo does not exist or if user does not own the todo.
-   `DELETE /api/todos/{todoHash}` - delete specific todo,
    -   `401 Unauthorized` if user is not logged in.
    -   `404 Not Found` if todo does not exist or if user does not own the todo.
