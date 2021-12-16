<?php
include("includes/config.php");
include("includes/classes/Account.php");
include("includes/classes/Constants.php");
include("includes/classes/Query.php");
$account = new Account($con);

include("includes/handlers/register-handler.php");
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
    <script src="assets/js/register.js"></script>
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

                    <form id="loginForm" method="post" action="register.php">
                        <h2>Login to your account</h2>
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
                        <input type="submit" name="loginButton" value="LOG IN" placeholder="LOG IN">
                            <!-- Can also use the button tags-->
                        </p>


                        <div class="hasAccountText">
                            <span id="hideLogin">Dont have an account yet? Sign Up here.</span>

                        </div>
                    </form>



                    <form id="registerForm" method="post" action="register.php">
                        <h2>Create your account</h2>
                        <p>
                        <?php echo $account->getError(Constants::$usernameCharacters); ?>
                        <?php echo $account->getError(Constants::$usernameTaken); ?>
                        <label for = "username">Username </label>
                        <input type="text" name="username" id="username" value="<?php getInputValue("username") ?>" placeholder="e.g alchemist" required>
                        </p>

                        <p>
                        <?php echo $account->getError(Constants::$firstNameCharacters); ?>
                        <label for = "firstname">First Name </label>
                        <input type="text" name="firstName" id="firstname" value="<?php getInputValue("firstName") ?>"placeholder="e.g Walter" required>
                        </p>

                        <p>
                        <?php echo $account->getError(Constants::$lastNameCharacters); ?>
                        <label for = "lastname">Last Name </label>
                        <input type="text" name="lastName" id="lastname" value="<?php getInputValue("lastName") ?>" placeholder="e.g White" required>
                        </p>

                        <p>
                        <?php echo $account->getError(Constants::$emailInvalid); ?>
                        <?php echo $account->getError(Constants::$emailTaken); ?>
                        <label for = "email">Email </label>
                        <input type="email" name="email" id="email" placeholder="e.g mrwhite@gmail.com" value="<?php getInputValue("email") ?>" required>
                        </p>

                        <p>
                        <?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
                        <label for = "email2">Confirm Email </label>
                        <input type="email" name="email2" id="email2" required>
                        </p>

                        <p>
                        <?php echo $account->getError(Constants::$passwordCharacters); ?>
                        <?php echo $account->getError(Constants::$passwordsNotAlphanumeric); ?>
                        <label for = "password">Password </label>
                        <input type="password" name="password" id="password" required>
                        </p>

                        <p>
                        <?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
                        <label for = "password2">Confirm Password </label>
                        <input type="password" name="password2" id="password2" required>
                        </p>

                        <p>
                        <input type="submit" name="registerButton" value="SIGN UP" placeholder="LOG IN">
                        </p>

                        <div class="hasAccountText">
                            <span id="hideRegister">Already have an account? Sign In here.</span>

                        </div>

                    </form>

                </div>
            
                <div id="loginText">
                    <h1>The Great artist, Next door</h1>
                    <h2>Support local artists near you by</h2>
                    <ul>
                        <li>Discovering and requesting their music</li>
                        <li> Creating and broadcasting your own playlists</li>
                        <li>Rating and following artists who get your attention</li>
                    </ul>
                    <div>
                        <button class="returnHome"><a href="index.php">LISTEN TO RADIO</a></button>
                        <button class="returnHome"><a href="personnel.php">PERSONNEL LOGIN</a></button>
                    </div>
                </div>
        </div>
    </div>

</body>
</html>