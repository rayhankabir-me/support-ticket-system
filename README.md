# Mini Support Ticketing System (PHP Backend)
Built a RESTful PHP backend (without a framework) for a minimal ticketing system,
including users, departments, and support tickets.


## Installation
1. Clone git
```bash
  git clone git@github.com:rayhankabir-me/support-ticket-system.git
```
2. Fill Database connection credentials in --- config/Database.php
3. No need to create database, database will be created on each model api hit


#### Register User

```http
  POST /register
```

| Form Body       | Type      | Description                              |
|:----------------|:----------|:-----------------------------------------|
| `name`          | `string`  | **Required**                             |
| `email`         | `email`   | **Required**                             |
| `password_hash` | `string`  | **Required**                             |
| `role`          | `integer` | **1 for Admin, 2 for Agent, 3 for User** |

#### User Login & Token Generate 
tokens will be stored in "files/tokens.json"

```http
  POST /login
```
| Form Body       | Type      | Description                              |
|:----------------|:----------|:-----------------------------------------|
| `email`         | `email`   | **Required**                             |
| `password_hash` | `string`  | **Required**                             |

#### User Logout & Token Delete

```http
  POST /logout
```
| Bearer Token     | Type     | Description  |
|:-----------------|:---------|:-------------|
| `Bearer {token}` | `header` | **Required** |


#### Create User -- (Auth Required - Bearer Token )

```http
  POST /users/
```
| Parameter       | Type      | Description                              |
|:----------------|:----------|:-----------------------------------------|
| `name`          | `string`  | **Required**                             |
| `email`         | `email`   | **Required**                             |
| `password_hash` | `string`  | **Required**                             |
| `role`          | `integer` | **1 for Admin, 2 for Agent, 3 for User** |

#### Get A User

```http
  GET /users/{id}
```

#### Delete User

```http
  DELETE /users/{id}
```

#### Update User -- (Auth Required - Bearer Token )

```http
  PUT /users/{id}
```
| Parameter       | Type      | Description                              |
|:----------------|:----------|:-----------------------------------------|
| `name`          | `string`  | **Required**                             |
| `email`         | `email`   | **Required**                             |
| `password_hash` | `string`  | **Required**                             |
| `role`          | `integer` | **1 for Admin, 2 for Agent, 3 for User** |

#### Create Departments -- (Auth Required - Bearer Token )

```http
  POST /departments
```
| Form Body | Type      | Description                              |
|:----------|:----------|:-----------------------------------------|
| `name`    | `string`  | **Required**                             |

#### Get All Departments

```http
  GET /departments
```
#### Get Department by ID

```http
  GET /departments/{id}
```

#### Update Departments -- (Auth Required - Bearer Token )

```http
  PUT /departments/{id}
```
| Form Body | Type      | Description                              |
|:----------|:----------|:-----------------------------------------|
| `name`    | `string`  | **Required**                             |

#### Delete a Department -- (Auth Required - Bearer Token)

```http
  DELETE /departments/{id}
```

#### Submit Ticket -- (Auth Required - Bearer Token )

```http
  POST /tickets
```
| Form Body       | Type      | Description                              |
|:----------------|:----------|:-----------------------------------------|
| `title`         | `string`  | **Required**                             |
| `description`   | `string`  | **Required**                             |
| `department_id` | `integer` | **Required**                             |

#### Assign Ticket To Himself(Agent) -- (Auth Required - Bearer Token )

```http
  PUT /tickets/{ticket_id}/assign
```

#### Add Notes (Conversations) -- (Auth Required - Bearer Token )

```http
  POST /tickets/{ticket_id}/notes
```
| Form Body | Type      | Description                              |
|:----------|:----------|:-----------------------------------------|
| `note`    | `string`  | **Required**                             |

