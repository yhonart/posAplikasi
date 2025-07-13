<form id="transactionForm">
    <div class="form-group">
        <label for="productInput">Scan Barcode / Cari Produk:</label>
        <input type="text" class="form-control" id="productInput" placeholder="Scan barcode atau ketik nama produk..." autofocus>
        <div id="productSuggestions" class="list-group" style="position: absolute; z-index: 1000; width: 90%; max-height: 200px; overflow-y: auto; display: none;">
            </div>
    </div>

    <div class="form-group mt-3">
        <label for="productNameDisplay">Produk Terpilih:</label>
        <input type="text" class="form-control" id="productNameDisplay" readonly>
        <input type="hidden" id="productId">
    </div>

    <div class="form-group mt-3">
        <label for="quantityInput">Jumlah (Quantity):</label>
        <input type="number" class="form-control" id="quantityInput" min="1" value="1" disabled>
    </div>

    <button type="submit" class="btn btn-primary mt-4">Proses Transaksi</button>
</form>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        const productInput = $('#productInput');
        const productSuggestions = $('#productSuggestions');
        const productNameDisplay = $('#productNameDisplay');
        const productId = $('#productId');
        const quantityInput = $('#quantityInput');

        let typingTimer;
        const doneTypingInterval = 300; // milliseconds

        // --- Logic for Barcode Scan and Manual Search ---
        productInput.on('input', function() {
            clearTimeout(typingTimer);
            const query = $(this).val();

            if (query.length > 0) {
                typingTimer = setTimeout(function() {
                    // Check if it's a barcode (e.g., all digits, certain length)
                    // You might need a more robust barcode validation depending on your barcode format
                    if (/^\d+$/.test(query) && query.length >= 8 && query.length <= 13) { // Example: EAN-13
                        fetchProductByBarcode(query);
                    } else {
                        searchProducts(query);
                    }
                }, doneTypingInterval);
            } else {
                productSuggestions.hide().empty();
                resetProductFields();
            }
        });

        // Handle suggestion click
        productSuggestions.on('click', '.list-group-item', function() {
            const selectedProductName = $(this).text();
            const selectedProductId = $(this).data('id');
            const selectedProductBarcode = $(this).data('barcode');

            productNameDisplay.val(selectedProductName);
            productId.val(selectedProductId);
            productInput.val(selectedProductBarcode); // Set barcode in the input
            productSuggestions.hide().empty();
            enableQuantityInput();
        });

        // Hide suggestions when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#productInput, #productSuggestions').length) {
                productSuggestions.hide();
            }
        });

        // --- AJAX Functions ---
        function searchProducts(query) {
            $.ajax({
                url: '/api/products/search', // Laravel API endpoint for searching
                method: 'GET',
                data: { query: query },
                success: function(response) {
                    productSuggestions.empty();
                    if (response.length > 0) {
                        $.each(response, function(index, product) {
                            productSuggestions.append(
                                `<a href="#" class="list-group-item list-group-item-action" data-id="${product.id}" data-barcode="${product.barcode}">${product.name}</a>`
                            );
                        });
                        productSuggestions.show();
                    } else {
                        productSuggestions.hide();
                    }
                },
                error: function(xhr) {
                    console.error("Error searching products:", xhr.responseText);
                    productSuggestions.hide();
                }
            });
        }

        function fetchProductByBarcode(barcode) {
            $.ajax({
                url: '/api/products/barcode/' + barcode, // Laravel API endpoint for barcode lookup
                method: 'GET',
                success: function(product) {
                    if (product) {
                        productNameDisplay.val(product.name);
                        productId.val(product.id);
                        productInput.val(product.barcode); // Ensure barcode is displayed
                        productSuggestions.hide().empty();
                        enableQuantityInput();
                        quantityInput.focus(); // Auto-focus on quantity field
                    } else {
                        resetProductFields();
                        // Optional: Display a "Product not found" message
                        alert('Produk dengan barcode ini tidak ditemukan.');
                    }
                },
                error: function(xhr) {
                    console.error("Error fetching product by barcode:", xhr.responseText);
                    resetProductFields();
                    // Optional: Display an error message
                    alert('Terjadi kesalahan saat mencari produk.');
                }
            });
        }

        // --- Helper Functions ---
        function resetProductFields() {
            productNameDisplay.val('');
            productId.val('');
            quantityInput.val(1).prop('disabled', true);
        }

        function enableQuantityInput() {
            quantityInput.prop('disabled', false);
        }

        // Initialize: Ensure quantity is disabled on load
        resetProductFields();
    });
</script>
@endpush