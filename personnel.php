<?php
include("includes/config.php");
include("includes/classes/Account.php");
include("includes/classes/Constants.php");
include("includes/classes/Query.php");
$account = new Account($con);

include("includes/handlers/login-handler.php");

function getInputValue($name) {
    if(isset($_POST[$name])) {
        echo $_POST[$name];
    }
    
}

?>



<! doctype>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="assets/css/input.css">
    <link rel="stylesheet" type="text/css" href="assets/css/register.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
        <?php
        // php code included here because at the beginning of the file the jquery has not yet been linked
        if(isset($_POST['registerButton'])) {
                echo "<script>
                $(document).ready(function() {
                    $('#registerForm').show();
                    $('#loginForm').hide();
                })</script>";
            } else {
                echo "<script>
                $(document).ready(function() {
                    $('#registerForm').hide();
                    $('#loginForm').show();
                })</script>";
        }
            ?>
    
    <div id=background>
        <div id="loginContainer">
                <div id=inputContainer>

                    <form id="loginForm" method="post" action="personnel.php">
                        <h2>Personnel Portal</h2>
                        <p> 
                        <?php echo $account->getError(Constants::$loginFailed); ?>
                        <label for = "loginusername">Username </label>
                        <input type="text" name="loginUsername" value="<?php getInputValue("loginUsername") ?>" id="loginusername" required>
                        </p>

                        <p>
                        <label for = "loginpassword">Password </label>
                        <input type="password" name="loginPassword" id="loginpassword" required>
                        </p>
                        
                        <p>
                        <label class="container-radio">Artist
                          <input type="radio" name="loginType" value="artist" checked="checked">
                          <span class="checkmark"></span>
                        </label>

                        <label class="container-radio">Admin
                          <input type="radio" name="loginType" value="admin">
                          <span class="checkmark"></span>
                        </label>
                        </p>

                        <p>
                        <input type="submit" name="loginPrivButton" value="LOG IN" placeholder="LOG IN">
                            <!-- Can also use the button tags-->
                        </p>

                    </form>


                </div>
            
                <div id="loginText">
                    <h1>Glad to have you back!</h1>
                    <p>This area is reserved for authorized personnel only. </p>
                </div>
        </div>
    </div>

</body>
</html>