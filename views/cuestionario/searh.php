<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    .search-container {
        margin-bottom: 20px;
        text-align: center;
    }

    #searchInput {
        width: 100%;
        max-width: 400px;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }
</style>
<body>
    <!-- search.php -->
    <div class="search-container">
        <input type="text" id="searchInput" placeholder="Buscar...">
    </div>

    <script>
        function normalizeString(str) {
            return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();
        }

        document.getElementById('searchInput').addEventListener('keyup', function() {
            var input = normalizeString(this.value);
            var items = document.querySelectorAll('.u-section-1 .cuestionario-item, .u-section-1 .image-container, .u-section-1 .u-title-overlay h2');

            items.forEach(function(item) {
                var text = normalizeString(item.textContent);
                if (text.includes(input)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>

</body>
</html>
