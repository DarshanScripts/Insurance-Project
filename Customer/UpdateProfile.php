<?php
session_start();

if (isset($_SESSION['sesLogin']['btnLogin'])) {

    // echo "<pre>";
    // print_r($_SESSION['sesLogUser']);
    // echo"</pre>";

    // echo "<pre>";
    // print_r($_SESSION['sesLogin']);
    // echo"</pre>";

    $fName = $_SESSION['sesLogUser']['firstName'];
    $lName = $_SESSION['sesLogUser']['lastName'];
    $email = $_SESSION['sesLogin']['txtEmail'];
    $pass = $_SESSION['sesLogin']['txtPass'];

    if (isset($_POST['btnUpdPro'])) {

        //    validations
        //    first name
        if (!preg_match('/^[A-Z][a-z]{1,15}$/', $fName))
            echo "<script>alert('First character of name should be capital & length should be between 2-15 characters!');</script>";

        //    last name
        if (!preg_match('/^[A-Z][a-z]{1,15}$/', $lName))
            echo "<script>alert('First character of name should be capital & length should be between 2-15 characters!');</script>";

        //    email
        elseif (!preg_match("/^[a-z][a-z0-9]+@(gmail|outlook|hotmail|yahoo|icloud)[.](com|in)$/", $email))
            echo "<script>alert('Email format is incorrect!');</script>";

        //    pass
        elseif (strlen($pass) < 5 || strlen($pass) > 8)
            echo "<script>alert('Length of Password should be between 5 to 8 characters!');</script>";

        else {
            require_once '../Database/DBConnection.php';
            $sql = "UPDATE User SET firstName = ?, lastName = ?, email = ?, password = ? WHERE email = '$email'";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssss', $fName, $lName, $email, $md5Pass);
            $fName = $_POST['txtFName'];
            $lName = $_POST['txtLName'];
            $email = $_POST['txtEmail'];
            $pass = $_POST['txtPass'];
            $md5Pass = md5($pass);
            $stmt->execute();
            if ($stmt)
                echo "<script>alert('Profile Updated Successful!');window.location.replace('./Homepage.php');</script>";
            else
                echo "<script>alert('Profile not Updated!');</script>";
        }
    }
?>


    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>ABC Insurance</title>
        <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="../assets/style.css">
        <style>
            a {
                font-size: 25px;
                float: right;
                padding-right: 30px;
                padding-top: 15px;
                text-decoration: none;
            }
        </style>
        <script>
            function hideShowPassword() {
                var pass = document.getElementById("pass");
                if (pass.type === "password")
                    pass.type = "text";
                else
                    pass.type = "password";
            }
        </script>
    </head>

    <body>
        <h1>
            &emsp;ABC Insurance
            <a href="../Logout.php">Logout</a>
            <a href="./Homepage.php">Homepage</a>
        </h1>
        <hr>
        <form method="POST">
            <!-- First Name input -->
            <div class="form-outline mb-3">
                <input type="text" name="txtFName" class="form-control" required="" value="<?php echo $fName ?>" <?php if (!isset($_POST['btnEdit'])) echo ' disabled'; ?> />
                <label class="form-label" for="form2Example1">First Name</label>
            </div>

            <!-- Last Name input -->
            <div class="form-outline mb-3">
                <input type="text" name="txtLName" class="form-control" required="" value="<?php echo $lName ?>" <?php if (!isset($_POST['btnEdit'])) echo ' disabled'; ?> />
                <label class="form-label" for="form2Example1">Last Name</label>
            </div>

            <!-- Email input -->
            <div class="form-outline mb-3">
                <input type="text" name="txtEmail" class="form-control" required="" value="<?php echo $email ?>" <?php if (!isset($_POST['btnEdit'])) echo ' disabled'; ?> />
                <label class="form-label" for="form2Example1">Email Address</label>
            </div>

            <!-- Password input -->
            <div class="form-outline mb-3">
                <input type="password" name="txtPass" class="form-control" id="pass" required="" value="<?php echo $pass ?>" <?php if (!isset($_POST['btnEdit'])) echo ' disabled'; ?> onfocus="hideShowPassword()" onblur="hideShowPassword()" />
                <label class="form-label" for="form2Example2">Password</label>
            </div>

            <!-- Submit button -->
            <button type="submit" name="btnEdit" class="btn btn-primary btn-block mb-4" <?php if (isset($_POST['btnEdit'])) echo ' disabled'; ?>>Edit</button>
            <button type="submit" name="btnUpdPro" class="btn btn-primary btn-block mb-4" <?php if (!isset($_POST['btnEdit'])) echo ' disabled'; ?>>Update Profile</button>

        </form>

    </body>

    </html>
<?php
} else
    echo "Please <a href='../Login.php'>Login</a> first!";
?>