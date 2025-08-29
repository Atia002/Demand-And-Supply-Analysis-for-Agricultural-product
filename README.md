# Agricultural Demand and Supply Analysis System

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
