<footer class="bg-dark text-white py-4 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h5>AgriAnalytics</h5>
                <p>Your complete solution for agricultural demand and supply analysis.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <h5>Contact</h5>
                <p>Email: info@agrianalytics.com<br>Phone: (123) 456-7890</p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php if (isset($pageSpecificScripts)): ?>
    <?php foreach ($pageSpecificScripts as $script): ?>
        <script src="<?php echo $script; ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>
</body>
</html>
