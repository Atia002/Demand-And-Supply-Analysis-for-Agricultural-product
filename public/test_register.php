<?php
session_start();
$BASE_URL = '/Demand-And-Supply-Analysis-for-Agricultural-product';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Test Registration</h3>
                    </div>
                    <div class="card-body">
                        <form id="registerForm">
                            <div class="mb-3">
                                <label class="form-label">Register as</label>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="farmer">Farmer</option>
                                    <option value="vendor">Vendor</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Contact</label>
                                <input type="text" class="form-control" name="contact" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" class="form-control" name="address" required>
                            </div>
                            <div class="vendor-fields" style="display: none;">
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
                            <div class="farmer-fields">
                                <div class="mb-3">
                                    <label class="form-label">Years of Experience</label>
                                    <input type="number" class="form-control" name="experience">
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
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Register</button>
                        </form>
                        <div id="result" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle fields based on role selection
        document.getElementById('role').addEventListener('change', function() {
            const vendorFields = document.querySelector('.vendor-fields');
            const farmerFields = document.querySelector('.farmer-fields');
            
            if (this.value === 'vendor') {
                vendorFields.style.display = 'block';
                farmerFields.style.display = 'none';
            } else {
                vendorFields.style.display = 'none';
                farmerFields.style.display = 'block';
            }
        });

        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            formData.append('action', 'register');
            
            fetch('<?php echo $BASE_URL; ?>/src/handlers/auth_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const resultDiv = document.getElementById('result');
                if (data.success) {
                    resultDiv.innerHTML = '<div class="alert alert-success">Registration successful! You can now login.</div>';
                    this.reset();
                } else {
                    resultDiv.innerHTML = '<div class="alert alert-danger">Registration failed: ' + data.message + '</div>';
                }
            })
            .catch(error => {
                document.getElementById('result').innerHTML = '<div class="alert alert-danger">Error: ' + error.message + '</div>';
            });
        });
    </script>
</body>
</html>
