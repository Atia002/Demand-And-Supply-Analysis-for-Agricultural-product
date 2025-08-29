// Load data and initialize charts
document.addEventListener('DOMContentLoaded', function() {
    // Load products and other data
    loadProducts();
    setupFormHandlers();
    // Demand Chart
    const demandCtx = document.getElementById('demandChart').getContext('2d');
    const demandChart = new Chart(demandCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Demand Trend',
                data: [65, 59, 80, 81, 56, 55],
                borderColor: '#2c8f4c',
                tension: 0.1,
                fill: false
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Monthly Demand Trends'
                }
            }
        }
    });

    // Supply Chart
    const supplyCtx = document.getElementById('supplyChart').getContext('2d');
    const supplyChart = new Chart(supplyCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Supply Trend',
                data: [70, 62, 75, 85, 60, 58],
                borderColor: '#17a2b8',
                tension: 0.1,
                fill: false
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Monthly Supply Trends'
                }
            }
        }
    });
});

// Form Handling
document.getElementById('addProductForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    // Add product form handling logic here
    console.log('Product form submitted');
    // Close modal after submission
    const modal = bootstrap.Modal.getInstance(document.getElementById('addProductModal'));
    modal.hide();
});

document.getElementById('addWarehouseForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    // Add warehouse form handling logic here
    console.log('Warehouse form submitted');
    // Close modal after submission
    const modal = bootstrap.Modal.getInstance(document.getElementById('addWarehouseModal'));
    modal.hide();
});

// Smooth scrolling for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Initialize all tooltips
const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
});

// Progress bar animation
function animateProgressBars() {
    document.querySelectorAll('.progress-bar').forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0';
        setTimeout(() => {
            bar.style.width = width;
            bar.style.transition = 'width 1s ease-in-out';
        }, 100);
    });
}

// Call progress bar animation when the warehouse section is in view
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            animateProgressBars();
        }
    });
});

const warehouseSection = document.querySelector('.warehouses-section');
if (warehouseSection) {
    observer.observe(warehouseSection);
}
