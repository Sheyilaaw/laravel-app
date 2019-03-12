<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="_token" content="{{csrf_token()}}" />

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin-top: 50px;
            }
            h5{
                font-size: 15px;
            }
        </style>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    </head>
    <body>
        <div class="container">

            <div class="text-center">
                    Add Product
            </div>
            <form id="create-product">
                <div class="row">
                    <input class="form-control" placeholder="Product Name" type="text" name="name">
                </div>

                <div class="row">
                    <input class="form-control" placeholder="Quantity" type="number" min="1" name="quantity">
                </div>

                <div class="row">
                    <input class="form-control" placeholder="Price" type="number" min="1" name="price">
                </div>
                <br>
                <div class="text-center">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>

            </form>

            <div class="row">
                <h3>All Products</h3>
				<?php $totalVal = 0; ?>
                @if(count($data) > 0)
                    @foreach($data as $value)
                        <h5>
                            Name: {{ $value['name'] }}
                            Quantity: {{ $value['quantity'] }}
                            Price: {{ $value['price'] }}
                            Date Submitted : {{ date('d F Y, h:i:s A',strtotime($value['datetime_submitted'])) }}
                            Total Value : {{ $value['total_value'] }}
                            <?php $totalVal += $value['total_value'] ; ?>
                        </h5>
                    @endforeach
                    <p> <b> SumTotal: <?php echo $totalVal; ?> </b> </p>
                    <br>
                @endif
            </div>
        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

        <script type="application/javascript">
            $("#create-product").submit(function(event) {
                /* Stop form from submitting normally */
                event.preventDefault();

                /* Get from elements values */
                var values = $(this).serialize();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                jQuery.ajax({
                    url: "{{ url('/product/') }}",
                    method: 'post',
                    data: values,
                    success: function(result){
                        if(result.success) {
							swal("Good job!", "You added a product!", "success");							
							var data = result.message;
							console.log(data);
							//Append Data

                        } else {                           
							swal("Error!",result.message, "error");
                        }
                    }
                });
            });

        </script>
    </body>
</html>
