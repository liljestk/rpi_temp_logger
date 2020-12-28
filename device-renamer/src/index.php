<!DOCTYPE html>
<html>

<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style>
        #loading-img {
            display: none;
        }

        .response_msg {
            margin-top: 10px;
            font-size: 13px;
            background: #E5D669;
            color: #ffffff;
            width: 250px;
            padding: 3px;
            display: none;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1>Update the device id in the database</h1>
                <h2>(if changed when replacing batteries)</h2>
                <form name="contact-form" action="" method="post" id="contact-form">
                    <div class="form-group">
                        <label for="Name">Old Device id/name</label>
                        <input type="text" class="form-control" name="old_id" placeholder="Old device id" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">New Device id/name</label>
                        <input type="text" class="form-control" name="new_id" placeholder="New device id" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit" value="Submit"
                        id="submit_form">Update</button>
                    <img src="img/loading.gif" id="loading-img">
                </form>

                <div class="response_msg"></div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#contact-form").on("submit", function (e) {
                e.preventDefault();
                if ($("#contact-form [name='new_id']").val() === '') {
                    $("#contact-form [name='new_id']").css("border", "1px solid red");
                } else if ($("#contact-form [name='old_id']").val() === '') {
                    $("#contact-form [name='old_id']").css("border", "1px solid red");
                } else {
                    $("#loading-img").css("display", "block");
                    var sendData = $(this).serialize();
                    $.ajax({
                        type: "POST",
                        url: "functions.php",
                        data: sendData,
                        success: function (data) {
                            $("#loading-img").css("display", "none");
                            $(".response_msg").text(data);
                            $(".response_msg").slideDown().fadeOut(30000);
                            $("#contact-form").find(
                                "input[type=text], input[type=email], textarea").val("");
                        }

                    });
                }
            });

            $("#contact-form input").blur(function () {
                var checkValue = $(this).val();
                if (checkValue != '') {
                    $(this).css("border", "1px solid #eeeeee");
                }
            });
        });
    </script>
</body>

</html>