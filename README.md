# Sol

## Design Decisions

Given the 24-hour constraint (3 days), I had to make specific trade-offs. My primary goal was not just to build a CRUD app that *works*, but to demonstrate an architecture that *scales* and remains maintainable as complexity grows. Here is the reasoning behind my approach:

### 1. Architecture: Domain-Driven Design (Lite)
I chose a modular structure (`app/Domain/Customer`) over the standard Laravel structure.
*   **Why:** Standard Laravel projects often suffer from 'Model Bloat' where Eloquent models become God Classes handling validation, database logic, and business rules.
*   **The Decision:** I isolated the **Domain** (Entities and Value Objects) from the **Infrastructure** (Eloquent and Database). This ensures that my business rules—like what constitutes a valid Customer—are pure PHP and don't depend on the framework. If we swapped Laravel for Symfony tomorrow, the `Domain` folder could largely stay the same.

### 2. Value Objects over Primitives
You’ll notice I used `DocumentValueObject` instead of passing around strict strings for the CPF/CNPJ.
*   **The Decision:** 'Primitive Obsession' is a common source of bugs. A string is just a string, but a `DocumentValueObject` guarantees validity upon instantiation.
*   **The Benefit:** I don't need to validate the document in every Controller or Service. If I have an instance of `DocumentValueObject`, I *know* it's valid. It centralizes the validation logic in one place rather than scattering regex checks throughout the app.

### 3. The 'Manual' Validation Logic
I wrote the CPF/CNPJ validation logic from scratch rather than pulling in a package.
*   **The Reasoning:** In a real production environment with tight deadlines, I would use a battle-tested package. However, for this challenge, I wanted to demonstrate two things:
    1.  **Algorithmic capability:** I can implement complex business rules without relying on 'magic' black boxes.
    2.  **Zero-dependency Domain:** I wanted my Domain layer to have zero external dependencies. External packages often bring their own constraints or framework couplings. By writing it myself, I kept the Domain pure.

### 4. Repositories as Anti-Corruption Layers
I implemented strict Repository Interfaces (`CustomerRepositoryInterface`).
*   **The Decision:** I didn't just use Repositories to wrap Eloquent methods. I used them to map **Eloquent Models** (Infrastructure) to **Domain Entities** (Business Logic).
*   **The Benefit:** This is the 'Anti-Corruption Layer'. It prevents the Active Record pattern (where data and database behavior are mixed) from leaking into the business logic. My Services don't know Eloquent exists; they only know about `Customer` Entities.

### 5. Addressing the Trade-offs (The "24-Hour" Reality)
You might notice I used `all()` instead of pagination, and strict error handling is missing in some repository lookups.
*   **The Context:** This was a conscious prioritization decision. I spent my time ensuring the **Architectural Boundaries** were correct—because refactoring architecture later is expensive.
*   **The Next Steps:** Adding pagination or `try-catch` blocks is a trivial implementation detail that can be added in an hour. Untangling a tightly coupled codebase takes weeks. I prioritized the 'hard part' to show I can lay a solid foundation.

## Setup / Running

To install/run the application, it needs to have any modern PHP version (>= 8.3), git, composer, and docker installed locally. All other dependencies are handled by the docker setup.

Clone the repository

```sh
git clone git@github.com:marcelo-lipienski/sol
```

Move into project's root directory

```sh
cd sol
```

Copy .env.example into .env
```sh
cp .env.example .env
```

Install depencencies

```sh
composer install
```

Boot the application using docker

```sh
./vendor/bin/sail up -d
```

Run migrations

```sh
./vendor/bin/sail artisan migrate
```

Seed database

```sh
./vendor/bin/sail artisan db:seed
```

Run tests

```sh
./vendor/bin/phpunit tests
```

Access API docs
```
http://localhost/docs/api
```