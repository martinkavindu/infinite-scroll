<!DOCTYPE html>
<html>
<head>
    <title>Facebook Style Infinite Scroll Pagination in Codeigniter using Ajax</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        /* Your CSS styles here */
    </style>
</head>
<body>
    <div class="container">
        <h2 align="center">Infinite Scroll Pagination</h2>
        <br />
        <table id="post_table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Account</th>
                    <th>Status</th>
                    <th>Effective date</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody id="load_data"></tbody>
        </table>
        <div id="load_data_message"></div>
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
    </div>

    <script>
        $(document).ready(function(){

            var limit = 20;
            var start = 0;
            var action = 'inactive';

            function lazzy_loader(limit) {
                var output = '';
                for(var count=0; count<limit; count++) {
                    output += '<div class="post_data">';
                    output += '</div>';
                }
                $('#load_data_message').html(output);
            }

            lazzy_loader(limit);

            function load_data(limit, start) {
                $.ajax({
                    url: "<?php echo base_url(); ?>infinite/fetch",
                    method: "POST",
                    data: {limit: limit, start: start},
                    cache: false,
                    success: function(data) {
                        console.log(data);
                        if(data == '') {
                            $('#load_data_message').html('<h3>No More Result Found</h3>');
                            action = 'active';
                        } else {
                            $.each(data, function(index, value) {
                                var row = '<tr>';
                                row += '<td>' + value.account + '</td>';
                                row += '<td>' + value.status + '</td>';
                                row += '<td>' + value.effective_date + '</td>';
                                row += '<td>' + value.created_at + '</td>';
                                row += '</tr>';
                                $('#load_data').append(row);
                            });
                            $('#load_data_message').html("");
                            action = 'inactive';
                        }
                    }
                });
            }

            if(action == 'inactive') {
                action = 'active';
                load_data(limit, start);
            }

            $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() > $("#load_data").height() && action == 'inactive') {
                    lazzy_loader(limit);
                    action = 'active';
                    start = start + limit;
                    setTimeout(function() {
                        load_data(limit, start);
                    }, 1000);
                }
            });

        });
    </script>
</body>
</html>
