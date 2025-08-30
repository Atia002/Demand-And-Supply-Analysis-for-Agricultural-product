<?php
require_once 'config/db_connect.php';
include 'includes/header.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Sign Up</h4>
                </div>
                <div class="card-body">
                    <form id="signupForm" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Register as</label>
                            <select class="form-select" name="role" id="role" required>
                                <option value="farmer">Farmer</option>
                                <option value="vendor">Vendor</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Contact Number</label>
                            <input type="tel" class="form-control" name="contact" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" name="address" required></textarea>
                        </div>

                        <!-- Farmer-specific fields -->
                        <div id="farmerFields">
                            <div class="mb-3">
                                <label class="form-label">Years of Experience</label>
                                <input type="number" class="form-control" name="experience" min="0">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Gender</label>
                                <select class="form-select" name="gender">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>

                        <!-- Vendor-specific fields -->
                        <div id="vendorFields" style="display: none;">
                            <div class="mb-3">
                                <label class="form-label">License ID</label>
                                <input type="text" class="form-control" name="license_id">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Vendor Type</label>
                                <select class="form-select" name="vendor_type">
                                    <option value="Wholesaler">Wholesaler</option>
                                    <option value="Retailer">Retailer</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" name="confirm_password" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Sign Up</button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <p>Already have an account? <a href="login.php">Login here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('role').addEventListener('change', function() {
    const farmerFields = document.getElementById('farmerFields');
    const vendorFields = document.getElementById('vendorFields');
    
    if (this.value === 'farmer') {
        farmerFields.style.display = 'block';
        vendorFields.style.display = 'none';
    } else {
        farmerFields.style.display = 'none';
        vendorFields.style.display = 'block';
    }
});

document.getElementById('signupForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    formData.append('action', 'register');
    
    try {
        const response = await fetch('handlers/auth_handler.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            alert('Registration successful! Please login.');
            window.location.href = 'login.php';
        } else {
            alert('Error: ' + result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred during registration');
    }
});
</script>

<?php include 'includes/footer.php'; ?>
