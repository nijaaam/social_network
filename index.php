<?php include('db.php');?> 
<html>

<head>
    <title>index</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.45/css/bootstrap-datetimepicker.min.css" />
</head>

<body>
    <div class="mainr">
        <form action="login.php" method="post">
            <div class="qwerty">
                <div class="label">
                    <div class="email style1">&nbsp;UserName</div>
                    <div class="password">&nbsp;&nbsp;Password</div>
                </div>
                <div class="label1">
                    <div class="emailtext">
                        <input name="UserName" type="text" />
                    </div>
                    <div class="passwordtext">
                        <input name="Password" type="password" />
                        <input name="submit" type="submit" class="greenButton" value="Login" />
                    </div>
                </div>
                <div class="label2">
                    <div class="password">&nbsp;&nbsp;Forgot Password?</div>
                </div>
            </div>
        </form>
    </div>

    <div class="downleft">
        <div class="field">
            <div class="signup">Sign Up</div>
            <div class="free">It's free, and always will be</div>
            <div class="text">
                <form id="signup_form" class="form-horizontal" action="signup.php" method="POST" >
                    <div class="form-group has-feedback">
                        <label class="col-sm-2 control-label">First name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="first_name" name="first_name">
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label class="col-sm-2 control-label">Last name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="last_name" name="last_name">
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label class="col-sm-2 control-label">User name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="username" name="username">
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="password" name="password">
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label class="col-sm-2 control-label">Address</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="address" name="address">
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label class="col-sm-2 control-label">Contact Number</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="contact" name="contact" placeholder="Enter passcode/name">
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="email" name="email">
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="description" class="col-sm-2 control-label">Gender</label>
                        <div class="col-sm-10">
                            <select name="gender" id="gender" class="form-control">
                              <option value="0"selected>Male</option>
                              <option value="1">Female</option>
                            </select>
                            <span class="glyphicon form-control-feedback" id="description_error"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label class="col-sm-2 control-label">DOB</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="dob" name="dob">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default">Sign in</button>
                        </div>
                    </div>
                </form>
            </div>
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
                contact: {
                    required: true,
                },
                first_name: {
                    required: true,
                },
                address: {
                    required: true,
                },
                password: {
                    required: true,
                },
                last_name: {
                    required: true,
                },
                username: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true,
                },
                dob: {
                    required: true,
                }
            },
        });
        $('#signup_form').submit(function() {
            if (!$(this).valid()){
            	return false;
            }
        });
        $('#dob').datetimepicker({
            format: 'DD-MM-YYYY',
        });
    </script>
</body>

</html>