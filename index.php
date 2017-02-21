<?php include('db.php');?>
<html>

<head>
    <title>index</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.45/css/bootstrap-datetimepicker.min.css" />
</head>

<body>
    <div class="container">
        <div class="row">
            </br>
            <form id = "login_form" class="pull-right form-inline" method="POST" action="login.php">
                <label class="sr-only">Username</label>
                <input type="text" class="form-control" name="username" placeholder="Username">
                <label class="sr-only">Username</label>
                <input type="password" class="form-control" name = "password" placeholder="Password">
                <button type="submit" name="submit1" class="btn btn-primary">Log In</button>
            </form>
        </div>
    </div>
    <div class="container">
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
        <div class="col-md-4">
            </br>
            <form id = "signup_form" class="form-horizontal" action="signup.php" method="POST">
                 <div class="form-group has-feedback">
                    <label class="col-sm-4 control-label">User name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="username">
                    </div>
                </div>
                 <div class="form-group has-feedback">
                    <label class="col-sm-4 control-label">Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" name="password">
                    </div>
                </div>
                <div class="form-group has-feedback">
                    <label class="col-sm-4 control-label">First name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="firstname">
                    </div>
                </div>
                <div class="form-group has-feedback">
                    <label class="col-sm-4 control-label">Last name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="lastname">
                    </div>
                </div>
               
                <div class="form-group has-feedback">
                    <label class="col-sm-4 control-label">Email</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="email">
                    </div>
                </div>
                <div class="form-group has-feedback">
                    <label class="col-sm-4 control-label">DOB</label>
                    <div class="col-sm-8">
                        <input type="text" id ="datepicker"class="form-control" name="dob">
                    </div>
                </div>
                <div class="form-group has-feedback">
                    <label class="col-sm-4 control-label">Security Question</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="question">
                    </div>
                </div>
                <div class="form-group has-feedback">
                    <label class="col-sm-4 control-label">Security Answer</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="answer">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" name="submit" class="btn btn-default">Sign Up</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.45/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>
    <script type="text/javascript">
        $.validator.setDefaults({
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorElement: 'span',
            errorClass: 'help-block',
            errorPlacement: function(error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }
        });
        $('#signup_form').validate({
            rules: {
                firstname: {
                    required: true,
                },
                password: {
                    required: true,
                },
                lastname: {
                    required: true,
                },
                username: {
                    required: true,
                },
                email: {
                    required: true,
                },
                dob: {
                    required: true,
                },
                question: {
                    required: true,
                },
                answer: {
                    required: true,
                },
            },
        });
        $('#login_form').validate({
            rules: {
                username: {
                    required: true,
                },
                password: {
                    required: true,
                }
            },
        });
        $('#login_form').submit(function() {
            if (!$(this).valid()) {
                return false;
            }
        });
        $('#signup_form').submit(function() {
            if (!$(this).valid()) {
                return false;
            }
        });
        $('#dob').datetimepicker({
            format: 'DD-MM-YYYY',
        });
    </script>
</body>

</html>