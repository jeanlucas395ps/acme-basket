## About the Challenge

Acme Widget Co is launching a new sales system. This proof of concept implements the basket logic, supporting:

- product catalog
- dynamic shipping rules
- promotional offers (like "Buy One Get One Half Price")

It was built to demonstrate code clarity, clean architecture, and extensibility.

# Acme Basket - Code Challenge

This project is a coding challenge for Acme Widget Co, simulating a backend system that manages a shopping basket with product catalog, delivery rules, and special offers.

## Features

- Add items to a basket by product code
- Calculate total cost including:
  - Dynamic delivery charges
  - Product-specific discount rules
- Easily extendable with:
  - Custom offers (via Strategy Pattern)
  - Delivery charge rules
  - Clean separation of concerns
- Unit tested with PHPUnit
- Static analysis with PHPStan (level 5)
- Built with Docker (multi-stage image)

## Assumptions Made

- Only **Red Widgets (R01)** are eligible for the "buy one, get one half price" offer.
- All prices are in **USD**, stored as floats rounded to 2 decimal places.
- Offers are applied **before** shipping is calculated.
- Shipping rules apply to the **subtotal after discounts**.

## Tech Stack

- PHP 8.1
- Docker + Docker Compose
- PHPUnit 10
- PHPStan (level 5)
- PSR-4 Autoloading
- No frameworks
- Pure PHP architecture

## Project Structure

```bash
├── docker/ # Docker image configuration
├── src/
│ └── Acme/
│ ├── Basket.php
│ ├── Product.php
│ ├── Catalog/
│ ├── Offers/
│ └── Shipping/
├── tests/ # PHPUnit tests
├── phpunit.xml
├── phpstan.neon
├── docker-compose.yml
└── README.md
```

## How to Run

1. **Clone the repository**:

```bash
git clone https://github.com/jeanlucas395ps/acme-basket.git
cd acme-basket
```

2. **Start the container**:

```bash
docker-compose up -d --build
```

3. **Run tests**:

```bash
docker exec -it acme-basket-app vendor/bin/phpunit
```

4. **Run static analysis**:

```bash
docker exec -it acme-basket-app vendor/bin/phpstan analyse
```

## Example Scenarios

| Basket Items              | Total    |
| ------------------------- | -------- |
| `B01, G01`                | `$37.85` |
| `R01, R01`                | `$54.37` |
| `R01, G01`                | `$60.85` |
| `B01, B01, R01, R01, R01` | `$98.27` |
