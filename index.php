<?php

    session_start();

    $error = "";

    $regno = "";
    $password = "";

    if (array_key_exists("logout", $_GET)) {

        session_destroy();
        session_write_close();

        header("Location: ./");

    } else if (array_key_exists("id", $_SESSION)) {

        header("Location: dashboard.php");

    }

    if (array_key_exists("submit", $_POST)) {

        $regno = $_POST["regno"];
        $password = $_POST["password"];
        $signup = $_POST["signup"];

        include("connection.php");

        if (!$regno) {

            $error .= "Registration Number is required.<br>";

        }

        if (!$password) {

            $error .= "Password is required.<br>";

        }

        if (!preg_match("/\d{2,2}\/\d{2,2}/", $regno)) {

            $error .= "Please enter valid Reg Number eg. 12/34<br>";

        }

        if ($error != "") {

            $error = "<p>There were error(s) in your form</p>".$error;

        } else {

            if ($signup == "1") {//SIGN UP

                $query = "SELECT id FROM students WHERE regno = '".mysqli_real_escape_string($link, $regno)."' LIMIT 1";
                $result = mysqli_query($link, $query);

                if (mysqli_num_rows($result) > 0) {

                    $error = "That Registration Number already exists";

                } else {

                    $query = "INSERT INTO students (regno, password) VALUES ('".mysqli_real_escape_string($link, $regno)."', '".mysqli_real_escape_string($link, $password)."')";

                    $result = mysqli_query($link, $query);

                    if (!$result) {

                        $error = "There was error signing up. Try again later";

                    } else {

                        $_SESSION["id"] = mysqli_insert_id($link);

                        header("Location: dashboard.php");

                    }

                }

            } else {//LOG IN

                $query = "SELECT * FROM students WHERE regno = '".mysqli_real_escape_string($link, $regno)."'";
                $row = mysqli_fetch_array(mysqli_query($link, $query));

                if (isset($row)) {

                    if (($row["regno"] == mysqli_real_escape_string($link, $regno)) AND ($row["password"] == mysqli_real_escape_string($link, $password))) {

                        $_SESSION["id"] = $row["id"];

                        header("Location: dashboard.php");

                    } else {

                        $error = "That email/password combination cannot be found";

                    }

                } else {

                    $error = "That  email/password combination cannot be found";

                }

            }

        }

    }

?>

<?php include("header.php") ?>

    <div class="container">

        <h1 class="color">Student Portal</h1>

        <p><strong>Access the Student Dashboard</strong></p>

        <div id="error">
            <?php if ($error != "") { echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';}
            ?>
        </div>

        <form method="POST" id="signupForm">

            <p>Sign up as new Student</p>

            <div class="form-group">
                <input type="text" class="form-control" name="regno" placeholder="Enter Reg Number">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Enter Password">
            </div>
            <div class="form-group">
                <input type="hidden" name="signup" value="1">
            </div>

            <button type="submit" name="submit" class="btn btn-success">Sign Up</button>

            <p><a class="toggleForms" href="javascript:void(0)">Log In</a></p>

        </form>

        <p></p>

        <form method="POST" id="loginForm">

            <p>Log in with your Registration Number</p>

            <div class="form-group">
                <input type="text" class="form-control" name="regno" placeholder="Enter Reg Number">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Enter Password">
            </div>
            <div class="form-group">
                <input type="hidden" name="signup" value="0">
            </div>
            <button type="submit" class="btn btn-success" name="submit">Login</button>

            <p><a class="toggleForms" href="javascript:void(0)">Sign Up</a></p>

        </form>

    </div>

    <?php include("footer.php") ?>