<?php
require_once 'config/db_connect.php';
include 'includes/header.php';

// Get all products for the filter
$products = $conn->query("SELECT * FROM product ORDER BY name");
// Get all districts for the filter
$districts = $conn->query("SELECT * FROM district ORDER BY name");
?>

<main class="container mt-4">
    <h1 class="mb-4">Market Analysis</h1>

    <!-- Filters Section -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Product</label>
                        <select class="form-select" id="productFilter">
                            <option value="">All Products</option>
                            <?php while($product = $products->fetch_assoc()): ?>
                                <option value="<?php echo $product['product_id']; ?>">
                                    <?php echo htmlspecialchars($product['name']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>District</label>
                        <select class="form-select" id="districtFilter">
                            <option value="">All Districts</option>
                            <?php while($district = $districts->fetch_assoc()): ?>
                                <option value="<?php echo $district['district_id']; ?>">
                                    <?php echo htmlspecialchars($district['name']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Date Range</label>
                        <select class="form-select" id="dateFilter">
                            <option value="7">Last 7 days</option>
                            <option value="30" selected>Last 30 days</option>
                            <option value="90">Last 3 months</option>
                            <option value="180">Last 6 months</option>
                            <option value="365">Last year</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button class="btn btn-primary d-block w-100" onclick="updateCharts()">
                            Update Analysis
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Market Overview Section -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6 class="card-title">Total Products</h6>
                    <h2 id="totalProducts">-</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6 class="card-title">Active Farmers</h6>
                    <h2 id="totalFarmers">-</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6 class="card-title">Total Vendors</h6>
                    <h2 id="totalVendors">-</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h6 class="card-title">Active Deliveries</h6>
                    <h2 id="activeDeliveries">-</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Price Trends</h5>
                    <canvas id="priceChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Supply vs Demand</h5>
                    <canvas id="supplyDemandChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Weather Impact</h5>
                    <canvas id="weatherImpactChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Market Distribution</h5>
                    <canvas id="marketDistributionChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
let priceChart, supplyDemandChart, weatherImpactChart, marketDistributionChart;

// Initialize charts
document.addEventListener('DOMContentLoaded', function() {
    initializeCharts();
    updateCharts();
});

function initializeCharts() {
    // Price Trends Chart
    const priceCtx = document.getElementById('priceChart').getContext('2d');
    priceChart = new Chart(priceCtx, {
        type: 'line',
        data: {
            labels: [],
            datasets: []
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Price Trends Over Time'
                }
            }
        }
    });

    // Supply vs Demand Chart
    const supplyDemandCtx = document.getElementById('supplyDemandChart').getContext('2d');
    supplyDemandChart = new Chart(supplyDemandCtx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: []
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Supply and Demand Analysis'
                }
            }
        }
    });

    // Weather Impact Chart
    const weatherCtx = document.getElementById('weatherImpactChart').getContext('2d');
    weatherImpactChart = new Chart(weatherCtx, {
        type: 'line',
        data: {
            labels: [],
            datasets: []
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Weather Impact on Prices'
                }
            }
        }
    });

    // Market Distribution Chart
    const distributionCtx = document.getElementById('marketDistributionChart').getContext('2d');
    marketDistributionChart = new Chart(distributionCtx, {
        type: 'pie',
        data: {
            labels: [],
            datasets: []
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Market Distribution'
                }
            }
        }
    });
}

async function updateCharts() {
    const productId = document.getElementById('productFilter').value;
    const districtId = document.getElementById('districtFilter').value;
    const dateRange = document.getElementById('dateFilter').value;

    try {
        // Update market summary
        const summaryResponse = await fetch('handlers/market_handler.php?action=getMarketSummary');
        const summaryData = await summaryResponse.json();
        if (summaryData.success) {
            document.getElementById('totalProducts').textContent = summaryData.data.total_products;
            document.getElementById('totalFarmers').textContent = summaryData.data.total_farmers;
            document.getElementById('totalVendors').textContent = summaryData.data.total_vendors;
            document.getElementById('activeDeliveries').textContent = summaryData.data.active_deliveries;
        }

        if (productId) {
            // Update price trends
            const priceResponse = await fetch(`handlers/market_handler.php?action=getPrices&product_id=${productId}`);
            const priceData = await priceResponse.json();
            if (priceData.success) {
                updatePriceChart(priceData.data);
            }

            // Update supply and demand
            const supplyResponse = await fetch(`handlers/market_handler.php?action=getSupplyDemand&product_id=${productId}`);
            const supplyData = await supplyResponse.json();
            if (supplyData.success) {
                updateSupplyDemandChart(supplyData.data);
            }

            // Update weather impact
            if (districtId) {
                const weatherResponse = await fetch(`handlers/market_handler.php?action=getWeatherImpact&product_id=${productId}&district_id=${districtId}`);
                const weatherData = await weatherResponse.json();
                if (weatherData.success) {
                    updateWeatherImpactChart(weatherData.data);
                }
            }
        }
    } catch (error) {
        console.error('Error updating charts:', error);
        alert('An error occurred while updating the analysis');
    }
}

function updatePriceChart(data) {
    const dates = data.map(item => item.date);
    const prices = data.map(item => item.price_value);

    priceChart.data.labels = dates;
    priceChart.data.datasets = [{
        label: 'Price',
        data: prices,
        borderColor: 'rgb(75, 192, 192)',
        tension: 0.1
    }];
    priceChart.update();
}

function updateSupplyDemandChart(data) {
    supplyDemandChart.data.labels = ['Supply', 'Demand'];
    supplyDemandChart.data.datasets = [{
        label: data.product_name,
        data: [data.total_supply, data.num_producers * data.avg_price],
        backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(255, 99, 132, 0.2)'],
        borderColor: ['rgb(75, 192, 192)', 'rgb(255, 99, 132)'],
        borderWidth: 1
    }];
    supplyDemandChart.update();
}

function updateWeatherImpactChart(data) {
    const dates = data.map(item => item.date);
    const temperatures = data.map(item => item.temperature_c);
    const prices = data.map(item => item.price_value);

    weatherImpactChart.data.labels = dates;
    weatherImpactChart.data.datasets = [
        {
            label: 'Temperature (°C)',
            data: temperatures,
            borderColor: 'rgb(255, 99, 132)',
            yAxisID: 'y1'
        },
        {
            label: 'Price',
            data: prices,
            borderColor: 'rgb(75, 192, 192)',
            yAxisID: 'y2'
        }
    ];
    weatherImpactChart.update();
}
</script>

<?php 
$pageSpecificScripts = ['js/market-analysis.js'];
include 'includes/footer.php'; 
?>
