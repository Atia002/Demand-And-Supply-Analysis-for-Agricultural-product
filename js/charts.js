// Initialize all charts when the document is ready
document.addEventListener('DOMContentLoaded', function() {
    initializeSearch();
    initializeCharts();
});

// Global Search Functionality
function initializeSearch() {
    const searchInput = document.querySelector('.search-input');
    const searchResults = document.querySelector('.search-results');

    if (searchInput) {
        searchInput.addEventListener('input', debounce(function(e) {
            const query = e.target.value;
            if (query.length > 2) {
                performSearch(query);
            } else {
                searchResults.classList.remove('active');
            }
        }, 300));
    }
}

function performSearch(query) {
    // Mock search results - Replace with actual API call
    const results = [
        { type: 'product', name: 'Rice', details: 'Current stock: 1000kg' },
        { type: 'farmer', name: 'John Doe', details: 'Rice producer' },
        { type: 'market', name: 'Central Market', details: 'Price trends available' }
    ];

    displaySearchResults(results);
}

function displaySearchResults(results) {
    const searchResults = document.querySelector('.search-results');
    searchResults.innerHTML = '';
    
    results.forEach(result => {
        const div = document.createElement('div');
        div.className = 'search-result-item';
        div.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas fa-${getIconForType(result.type)} me-2"></i>
                <div>
                    <strong>${result.name}</strong>
                    <div class="small text-muted">${result.details}</div>
                </div>
            </div>
        `;
        searchResults.appendChild(div);
    });

    searchResults.classList.add('active');
}

// Charts Initialization
function initializeCharts() {
    initializePriceChart();
    initializeSupplyDemandChart();
    initializeProductionTrendsChart();
    initializeStorageChart();
}

// Price Trends Chart
function initializePriceChart() {
    const ctx = document.getElementById('priceChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Rice',
                    data: [65, 59, 80, 81, 56, 55],
                    borderColor: '#2c8f4c',
                    tension: 0.4
                }, {
                    label: 'Wheat',
                    data: [28, 48, 40, 19, 86, 27],
                    borderColor: '#3498db',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Price Trends Over Time'
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Price (USD)'
                        }
                    }
                }
            }
        });
    }
}

// Supply vs Demand Chart
function initializeSupplyDemandChart() {
    const ctx = document.getElementById('supplyDemandChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Rice', 'Wheat', 'Corn', 'Vegetables'],
                datasets: [{
                    label: 'Supply',
                    data: [300, 450, 320, 280],
                    backgroundColor: '#2c8f4c'
                }, {
                    label: 'Demand',
                    data: [280, 400, 360, 290],
                    backgroundColor: '#e74c3c'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Supply vs Demand Analysis'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Quantity (tons)'
                        }
                    }
                }
            }
        });
    }
}

// Production Trends Chart
function initializeProductionTrendsChart() {
    const ctx = document.getElementById('productionChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['2020', '2021', '2022', '2023', '2024', '2025'],
                datasets: [{
                    label: 'Production Volume',
                    data: [1200, 1350, 1500, 1800, 2100, 2400],
                    borderColor: '#2c8f4c',
                    fill: true,
                    backgroundColor: 'rgba(44, 143, 76, 0.1)'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Yearly Production Trends'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Production Volume (tons)'
                        }
                    }
                }
            }
        });
    }
}

// Storage Utilization Chart
function initializeStorageChart() {
    const ctx = document.getElementById('storageChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Used', 'Available'],
                datasets: [{
                    data: [75, 25],
                    backgroundColor: [
                        '#2c8f4c',
                        '#ecf0f1'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Storage Capacity Utilization'
                    }
                }
            }
        });
    }
}

// Utility Functions
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

function getIconForType(type) {
    const icons = {
        product: 'box',
        farmer: 'user',
        market: 'store',
        weather: 'cloud',
        price: 'dollar-sign'
    };
    return icons[type] || 'search';
}

// Export functions for use in other files
window.chartUtils = {
    initializeCharts,
    updateChartData: function(chartId, newData) {
        const chart = Chart.getChart(chartId);
        if (chart) {
            chart.data.datasets = newData;
            chart.update();
        }
    }
};
