<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Calculation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully responsive admin theme which can be used to build CRM, CMS, ERP, etc." name="description" />
    <meta content="Your Name" name="author" />
    <link rel="shortcut icon" href="{{ asset('assets/images/in.png') }}">
    <script src="{{ asset('backend/js/config.js') }}"></script>
    <link href="{{ asset('backend/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <link href="{{ asset('backend/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
</head>

<body class="authentication-bg position-relative">
<div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-8 col-lg-10">
                <div class="card overflow-hidden">
                    <div class="row g-0 align-items-center">
                        <div class="col-lg-6 d-none d-lg-block p-2">
                            <img src="{{ asset('backend/images/1.png') }}" alt="" class="img-fluid rounded h-200">
                        </div>
                        <div class="col-lg-6">
                            <div class="d-flex flex-column h-100">
                                <div class="p-4 pt-0 my-auto">
{{--                                    <form method="get" action="{{route('calculation.result')}}">--}}
                                        <form id="calculation-form" method="POST">
                                        @csrf
                                        <div class="col-12">
                                            <div class="mb-2">
                                                <label  class="form-label">Amazon Category</label>
                                                <select name="amazon_category_id" id="amazon-category-select" class="form-select">
                                                    @foreach($amazonCategory as $amazonCategoryData)
                                                        <option value="{{$amazonCategoryData->id}}">{{$amazonCategoryData->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="sub-category-select" class="form-label">Amazon Sub Category</label>
                                                <select name="amazon_sub_category_id" id="amazon-sub-category-select" class="form-select">
                                                    <option value="">Select Amazon Sub Category</option>
                                                    <!-- Sub categories will be dynamically loaded here -->
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="mb-2">
                                                <label class="form-label">Retail Price</label>
                                                <input type="text"  name="retail_price"
                                                       class="form-control" placeholder="Enter Retail Price" required>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="mb-2">
                                                <label class="form-label">Cost Price</label>
                                                <input type="text"  name="cost_price"
                                                       class="form-control" placeholder="Enter Cost Price" required>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="mb-2">
                                                <label class="form-label">Length</label>
                                                <input type="text"  name="length"
                                                       class="form-control" placeholder="Enter Length" required>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="mb-2">
                                                <label class="form-label">Width</label>
                                                <input type="text"  name="width"
                                                       class="form-control" placeholder="Enter Width" required>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="mb-2">
                                                <label class="form-label">Height</label>
                                                <input type="text"  name="height"
                                                       class="form-control" placeholder="Enter Height" required>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="mb-2">
                                                <label class="form-label">Weight</label>
                                                <input type="text"  name="weight"
                                                       class="form-control" placeholder="Enter Weight" required>
                                            </div>
                                        </div>


                                        <div class="mb-0 text-start">
                                            <button class="btn btn-soft-primary w-100" type="submit"><i class="ri-login-circle-fill me-1"></i> <span class="fw-bold">Show Result</span> </button>
                                        </div>
                                    </form>

                                    <!-- Section to display calculation results -->
                                    <div class="calculation-results" style="display:none; margin-top: 20px;">
                                        <h3>Calculation Results</h3>
                                        <ul>
                                            <li><strong>Referral Fee:</strong> $<span id="referral-fee"></span></li>
                                            <li><strong>Fulfillment Fee:</strong> $<span id="fulfillment-fee"></span></li>
                                            <li><strong>Total Amazon Fees:</strong> $<span id="total-amazon-fees"></span></li>
                                            <li><strong>Gross Profit:</strong> $<span id="gross-profit"></span></li>
                                            <li><strong>Net Profit:</strong> $<span id="net-profit"></span></li>
                                            <li><strong>Net Margin:</strong> <span id="net-margin"></span>%</li>
                                        </ul>
                                    </div>
                                    <!-- End Results Section -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<footer class="footer footer-alt fw-medium">
    <span class="text-dark">
        <script>document.write(new Date().getFullYear())</script> © Management System
    </span>
</footer>
<script src="{{ asset('backend/js/vendor.min.js') }}"></script>
<script src="{{ asset('backend/js/app.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Trigger when an Amazon category is selected
        $('#amazon-category-select').change(function() {
            // Get the selected category ID
            let categoryId = $(this).val();

            // Clear the existing subcategory options
            $('#amazon-sub-category-select').empty();
            $('#amazon-sub-category-select').append('<option value="">Select Amazon Sub Category</option>');

            // If a category is selected, make an AJAX call to get the subcategories
            if (categoryId) {
                $.ajax({
                    url: '/amazon/' + categoryId + '/sub-categories', // Call the route for fetching subcategories
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Iterate over the response data to populate subcategory dropdown
                        $.each(data, function(key, value) {
                            $('#amazon-sub-category-select').append('<option value="'+ value.id +'">' + value.name + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching subcategories:', error);
                    }
                });
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Form submission handling via AJAX
        $('#calculation-form').submit(function(e) {
            e.preventDefault();  // Prevent default form submission

            // Get form data
            let formData = $(this).serialize();

            // Send AJAX request to calculation result endpoint
            $.ajax({
                url: "{{ route('calculation.result') }}",  // Ensure route is correct for your Laravel app
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Convert fulfillment_fee to a number before calling .toFixed()
                    $('#referral-fee').text(parseFloat(response.referral_fee).toFixed(2));
                    $('#fulfillment-fee').text(parseFloat(response.fulfillment_fee).toFixed(2));  // Convert to number
                    $('#total-amazon-fees').text(parseFloat(response.total_amazon_fees).toFixed(2));
                    $('#gross-profit').text(parseFloat(response.gross_profit).toFixed(2));
                    $('#net-profit').text(parseFloat(response.net_profit).toFixed(2));
                    $('#net-margin').text(parseFloat(response.net_margin).toFixed(2));

                    // Show the results section
                    $('.calculation-results').show();
                },
                error: function(xhr, status, error) {
                    console.error('Error in calculation:', error);
                }
            });
        });
    });

</script>

</body>
</html>
