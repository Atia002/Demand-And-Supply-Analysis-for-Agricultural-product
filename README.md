# Demand and Supply Analysis for Agricultural Products

## Project Status
- ✅ Frontend UI Implementation
- ✅ Database Schema Design
- ✅ Basic Backend Structure
- ⚠️ Database Connection (In Progress)
- ⚠️ Authentication System (In Progress)
- ⏳ API Implementation (Pending)

## Setup Instructions

### Prerequisites
- XAMPP (Apache and MySQL)
- PHP 7.4 or higher
- Web Browser

### Database Setup
1. Start XAMPP Apache and MySQL services
2. Create a database named `supply_demand`
3. Import the schema from `database/db_schema.sql`

### Installation
1. Clone this repository to your XAMPP htdocs folder:
   ```bash
   cd /path/to/xampp/htdocs
   git clone https://github.com/Atia002/Demand-And-Supply-Analysis-for-Agricultural-product.git
   ```

2. Configure database connection in `src/config/db_config.php`:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_NAME', 'supply_demand');
   ```

### Project Structure
```
project/
├── public/           # Public-facing files
│   ├── assets/      # Static assets (CSS, JS)
│   ├── views/       # HTML/PHP view files
│   └── index.php    # Main entry point
├── src/             # Source files
│   ├── config/      # Configuration files
│   ├── handlers/    # Request handlers
│   └── includes/    # Common PHP includes
└── database/        # Database scripts
    └── db_schema.sql
```

## Known Issues
1. Database connection needs proper configuration
2. Authentication system needs implementation
3. API endpoints need to be completed

## Next Steps
1. Fix database connection
2. Implement user authentication
3. Complete API endpoints
4. Add data validation
5. Implement security measures

## Contributing
1. Fork the repository
2. Create your feature branch (`git checkout -b feature/YourFeature`)
3. Commit your changes (`git commit -m 'Add some feature'`)
4. Push to the branch (`git push origin feature/YourFeature`)
5. Create a new Pull Request

## Project Organization

```
project/
│
├── public/                 # Public-facing files
│   ├── assets/            # Static assets
│   │   ├── css/          # CSS stylesheets (auth.css, charts.css, etc.)
│   │   └── js/           # JavaScript files (api.js, charts.js, etc.)
│   │
│   ├── views/            # HTML/PHP view files
│   │   ├── auth/         # Authentication views (login.html, signup.html)
│   │   ├── dashboard/    # Role-specific dashboards
│   │   └── shared/       # Shared components (header, footer)
│   │
│   └── index.php         # Main entry point
│
├── src/                   # Source files
│   ├── config/           # Configuration files
│   │   └── db.php        # Database configuration
│   │
│   ├── handlers/         # Request handlers
│   │   ├── auth_handler.php
│   │   ├── farmer_handler.php
│   │   ├── market_handler.php
│   │   └── ...
│   │
│   ├── includes/         # Common PHP includes
│   │   ├── db_connection.php
│   │   ├── header.php
│   │   └── footer.php
│   │
│   └── models/           # Data models
│
└── database/             # Database scripts
    └── db_schema.sql     # Database schema

## File Organization Guidelines

1. Public Assets (/public)
   - All publicly accessible files go here
   - CSS files in /public/assets/css
   - JavaScript files in /public/assets/js
   - Images in /public/assets/images

2. Views (/public/views)
   - HTML templates go in appropriate subdirectories
   - Role-specific views in /dashboard
   - Auth-related views in /auth
   - Shared components in /shared

3. Source Code (/src)
   - All PHP backend code goes here
   - Organized by functionality (handlers, includes, models)
   - Configuration files in /config

4. Database (/database)
   - Database schema and migration scripts
   - Backup scripts if any

## Naming Conventions

1. Files
   - Use lowercase with hyphens for HTML/CSS/JS files
   - Use snake_case for PHP files
   - Examples:
     - farmer-dashboard.html
     - auth_handler.php

2. Classes
   - Use PascalCase
   - Example: DatabaseConnection

3. Functions and Variables
   - Use camelCase
   - Example: getFarmerData()

## Best Practices

1. Always update both HTML and PHP files when making changes to forms
2. Keep database queries in handler files only
3. Use includes/header.php and includes/footer.php for consistent layout
4. Always validate user input in handlers
5. Keep configuration in src/config files
6. Use prepared statements for database queries

## File Responsibilities

1. Handlers (/src/handlers)
   - Process form submissions
   - Handle AJAX requests
   - Implement business logic
   - Database operations

2. Models (/src/models)
   - Define data structures
   - Handle data validation
   - Implement data relationships

3. Views (/public/views)
   - Present data to users
   - Contain forms and templates
   - Include shared components

4. Includes (/src/includes)
   - Provide common functionality
   - Handle database connections
   - Manage sessions
   - Define shared functions

A comprehensive web-based system for analyzing agricultural demand and supply patterns, connecting farmers, vendors, and consumers.

## Features

### User Roles
- **Farmers**: Manage farms, track production, and monitor weather
- **Vendors**: 
  - Wholesalers: Bulk order management
  - Retailers: Store-specific operations
- **Consumers**: Product browsing and purchasing

### Key Components
1. **Dashboard Analytics**
   - GDP and Population Trends
   - Market Analysis
   - Supply vs Demand Charts

2. **Inventory Management**
   - Product Tracking
   - Storage Management
   - Stock Level Monitoring

3. **Weather Integration**
   - Temperature Tracking
   - Rainfall Data
   - Farm-specific Weather Updates

4. **Price Analysis**
   - Historical Price Trends
   - Market Rate Comparisons
   - Seasonal Variations

## Tech Stack
- HTML5
- CSS3 (Bootstrap 5.3.0)
- JavaScript
- PHP
- MySQL
- Chart.js for visualizations

## Installation

1. Clone the repository:
```bash
git clone https://github.com/Atia002/Demand-And-Supply-Analysis-for-Agricultural-product.git
```

2. Set up your local environment:
   - Install XAMPP/WAMP
   - Configure your PHP environment
   - Set up the MySQL database

3. Database Setup:
   - Import the provided SQL schema
   - Configure database connection in `/handlers/config.php`

4. Start the application:
   - Place the project in your web server directory
   - Access via localhost

## Project Structure

```
project/
│
├── css/
│   ├── style.css
│   ├── auth.css
│   └── charts.css
│
├── js/
│   ├── main.js
│   ├── charts.js
│   └── vendor-dashboard.js
│
├── handlers/
│   ├── product_handler.php
│   ├── vendor_handler.php
│   └── weather_handler.php
│
└── index.html
```

## Database Schema

The system uses a relational database with the following key tables:
- FARMER
- FARM
- PRODUCT
- VENDOR (supertype)
  - WHOLESALER (subtype)
  - RETAILER (subtype)
- WEATHER
- PRICE_RECORD
- STORAGE
- DELIVERY

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Authors

- **Atia002** - *Initial work* - [GitHub Profile](https://github.com/Atia002)

## Acknowledgments

- Data dictionary and ERD design contributors
- Agricultural market research contributors
- Bootstrap and Chart.js communities
