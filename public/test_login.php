<?php
session_start();
$BASE_URL = '/Demand-And-Supply-Analysis-for-Agricultural-product';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Test Login</h3>
                    </div>
                    <div class="card-body">
                        <form id="loginForm">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username/Contact</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                        <div id="result" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData();
            formData.append('action', 'login');
            formData.append('username', document.getElementById('username').value);
            formData.append('password', document.getElementById('password').value);
            
            fetch('<?php echo $BASE_URL; ?>/src/handlers/auth_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const resultDiv = document.getElementById('result');
                if (data.success) {
                    resultDiv.innerHTML = '<div class="alert alert-success">Login successful! Redirecting...</div>';
                    window.location.href = data.redirect;
                } else {
                    resultDiv.innerHTML = '<div class="alert alert-danger">Login failed: ' + data.message + '</div>';
                }
            })
            .catch(error => {
                document.getElementById('result').innerHTML = '<div class="alert alert-danger">Error: ' + error.message + '</div>';
            });
        });
    </script>
</body>
</html>
