<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/resources.css">
    <script src="js/management.js"></script>
    <script src="js/author.js"></script>
</head>
<body>

    <?php
        include_once "db_connection.php";
        include_once "management.php";

        session_start();
        checkAccesOptionOnLogin();

        // The user try to logging
        if (isset($_POST["user"])) {
            $user = $_POST['user'];
            $pass = $_POST['pass'];

            $login = "SELECT idcustomer, type
                      FROM customer
                      WHERE username = ? AND
                            password = ?;
                     ";

            if ($query = $connection->prepare($login)) {

                $query->bind_param("ss", $user, $pass);
                $query->execute();
                $query->bind_result($userID, $userType);
                $query->fetch();

                if(isset($userID)){
                    $_SESSION["iduser"]   = $userID;
                    $_SESSION["userType"] = $userType;

                    if($userType == "Admin")
                        header('Location: admin.php');
                    else if($userType == "User")
                        header('Location: menu.php');
                }else
                    showToast("Invalid Login");
                $query->close();
            }
        }
    ?>

    <img id="logo" src="resources/img/logo.png">
    <div id="wrapper">
        <form method="post">
            <div>
                <img src="resources/img/user.png">
                <input name="user" type="text" required>
            </div>
            <div>
                <img src="resources/img/pass.png">
                <input name="pass" type="password" required>
            </div>
            <div>
                <input class="standardButton" type="submit" value="Log In">
            </div>
            <div>Don't have an account? <a href="sign_up.php">Sign Up</a></div>
        </form>
    </div>
</body>
</html>























