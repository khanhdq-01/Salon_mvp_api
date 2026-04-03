# 🏗 Laravel Base Architecture (Scalable & Maintainable)

## 🎯 Goals

* Scalable for large projects
* Easy to maintain & extend
* High reusability
* Clear separation of concerns
* Testable code

---

## 📁 Project Structure

```
app/
├── Console/
├── Exceptions/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
│   ├── Requests/        # Validate input (FormRequest)
│   └── Resources/       # API Resource (transform response)
│
├── Models/
│
├── Services/            # Business logic
├── Repositories/        # Data access layer
├── Interfaces/          # Contracts (DI)
│
├── Traits/              # Reusable logic
├── Helpers/             # Global helpers
│
└── Providers/
```

---

## 🧠 Architecture Overview

Controller → Service → Repository → Model

```
Controller
   ↓
Service (Business Logic)
   ↓
Repository (DB Query)
   ↓
Model (Eloquent)
```

---

## 🔹 1. Controllers (Thin Controllers)

* Only handle request/response
* No business logic

```php
public function store(CreateUserRequest $request)
{
    return $this->userService->create($request->validated());
}
```

---

## 🔹 2. Services (Business Logic Layer)

* Handle core logic
* Reusable across controllers

```php
class UserService
{
    public function __construct(
        private UserRepositoryInterface $userRepo
    ) {}

    public function create(array $data)
    {
        return $this->userRepo->create($data);
    }
}
```

---

## 🔹 3. Repositories (Data Layer)

* Handle DB queries
* Avoid writing query in controller/service

```php
class UserRepository implements UserRepositoryInterface
{
    public function create(array $data)
    {
        return User::create($data);
    }
}
```

---

## 🔹 4. Interfaces (Dependency Injection)

* Decouple implementation
* Easy to swap logic

```php
interface UserRepositoryInterface
{
    public function create(array $data);
}
```

---

## 🔹 5. Service Provider Binding

```php
$this->app->bind(
    UserRepositoryInterface::class,
    UserRepository::class
);
```

---

## 🔹 6. Form Request (Validation)

```php
class CreateUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users'
        ];
    }
}
```

---

## 🔹 7. API Resources (Response Format)

```php
return new UserResource($user);
```

---

## ♻️ Reusability Principles

* Use Traits for shared logic
* Use Services for reusable business logic
* Avoid duplicate queries → use Repository
* Extract common logic into Helpers

---

## 🧪 Testing Strategy

* Unit test: Services
* Feature test: API endpoints
* Mock Repository in tests

---

## ⚙️ Naming Convention

| Layer      | Example                 |
| ---------- | ----------------------- |
| Controller | UserController          |
| Service    | UserService             |
| Repository | UserRepository          |
| Interface  | UserRepositoryInterface |
| Request    | CreateUserRequest       |

---

## 🚫 Anti-Patterns (Avoid)

* Fat Controllers ❌
* Business logic in Model ❌
* Query in Controller ❌
* Hardcode logic ❌

---

## ✅ Best Practices

* Follow SOLID principles
* Use Dependency Injection
* Keep functions small & readable
* Write clean & self-documenting code

---

## 📌 Summary

| Layer      | Responsibility |
| ---------- | -------------- |
| Controller | Handle HTTP    |
| Service    | Business logic |
| Repository | Data access    |
| Model      | ORM            |
| Request    | Validation     |
| Resource   | Response       |

---

## 🚀 Bonus Tips

* Use DTO for large data transfer
* Use Events for async logic
* Use Jobs for queue handling
* Use Caching (Redis) when needed

---

> Clean architecture = Faster development + Easier maintenance + Scalable system
