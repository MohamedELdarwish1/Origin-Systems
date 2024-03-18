# Origin Systems

Origin Systems is a Laravel project for hotel search and management.

## Setup

1. Clone the repository:

`https://github.com/MohamedELdarwish1/Origin-Systems.git`

2. Install dependencies:

`composer install`

3. Copy `.env.example` to `.env` and configure database settings.

4. Run migrations:

`php artisan migrate`


## Running the Project

Start the development server:

`php artisan serve`


## Running Unit Tests

To run unit tests, use:

`php artisan test`


## Usage Examples

1. Search hotels by name:

`GET /api/hotels?name=Media`


2. Filter hotels by city and price range:

`GET /api/hotels?city=Dubai&price_range=100:150`


## Endpoints Documentation

### GET /api/hotels
- **Parameters:**
  - `name`: Search hotels by name.
  - `city`: Filter hotels by city.
  - `price_range`: Filter hotels by price range (format: min_price : max_price).
  - `date_range`: Filter hotels by availability date range (format: start_date : end_date).
  - `sort_by`: Sort hotels by name or price.

- **Response:**
  - An array of hotel objects containing city, name, price, and availability.


## Contributing

Thank you for considering contributing to Origin Systems!

## License

This project is licensed under the [MIT License](LICENSE).

