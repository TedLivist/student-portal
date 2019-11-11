<?php

    session_start();

    $regno = "";
    $password = "";

    $error = "";
    $homeError = "";

    $disabled = "";

    if (array_key_exists("id", $_SESSION)) {

        include("connection.php");

        $query = "SELECT * from students WHERE id = ".$_SESSION["id"]." LIMIT 1";
        $row = mysqli_fetch_array(mysqli_query($link, $query));
        $sname = $row["sname"];
        $fname = $row["fname"];

        if (($sname != "") AND ($fname != "")) {

            $disabled = "disabled='true'";

        }

    }

    if (array_key_exists("submit-details", $_POST)) {

        $fname = $_POST["fname"];
        $sname = $_POST["sname"];
        $faculty = $_POST["faculty"];
        $dept = $_POST["dept"];
        $entry_year = $_POST["entry-year"];
        $grad_year = $_POST["grad-year"];
        $level = $_POST["level"];
        $email = $_POST["email"];

        if (empty($fname)) {

            $error .= "Please enter your First Name<br>";

        }

        if (empty($sname)) {

            $error .= "Please enter your Surname<br>";

        }

        if ($faculty == "Select Faculty") {

            $error .= "Please select a Faculty<br>";

        }

        if ($dept == "Select Department") {

            $error .= "Please select a department<br>";

        }

        if ($email == "") {

            $error .= "Please fill in the email space<br>";

        }

        if ($error != "") {

            $error = "<p>There were error(s) in your form</p>".$error."<p></p>";
            $homeError = "There were errors in your form. Check the Update Profile tab";
    
            
        } else {

            $query = "UPDATE students SET `fname` = '".mysqli_real_escape_string($link, $fname)."', `sname` = '".mysqli_real_escape_string($link, $sname)."', `dept` = '".mysqli_real_escape_string($link, $dept)."', `faculty` = '".mysqli_real_escape_string($link, $faculty)."', `entry-year` = '".mysqli_real_escape_string($link, $entry_year)."', `grad-year` = '".mysqli_real_escape_string($link, $grad_year)."', `study-year` = '".mysqli_real_escape_string($link, $level)."' , `email` = '".mysqli_real_escape_string($link, $email)."' WHERE id = '".mysqli_real_escape_string($link, $_SESSION["id"])."' LIMIT 1";
            $result = mysqli_query($link, $query);

            if ($result) {

                $disabled = "disabled='true'";

            }

        }

    }

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Student Dashboard</title>

    <style>
    
        .row {
            margin-top: 20px;
            margin-left: 10px;
            margin-right: 10px;
        }
    
    </style>

  </head>
  <body>
        <div class="row">
            <div class="col-3">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Home</a>
                    <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Profile</a>
                    <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Update Profile</a>
                    <a class="nav-link" href='index.php?logout=1'>Log Out</a>
                </div>
            </div>
            <div class="col-5">
                <div class="tab-content" id="v-pills-tabContent">

                    <!--HOME-->
                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">

                        <div><?php echo $homeError ?></div>
                        <h1>Welcome!</h1>
                            <?php if ($sname == "" AND $fname == "") {
                            ?>
                                <h4>Update Your Profile</h4>
                            <?php
                            } else {?> <h3> <?php

                                echo $sname .", ". $fname;

                            } 
                            ?>
                        </h3>

                    </div>

                    <!--PROFILE-->
                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">

                        <h4>First Name</h4>
                        <p><?php echo $row["fname"]?></p>

                        <h4>Surname</h4>
                        <p><?php echo $row["sname"]?></p>

                        <h4>Registration Number</h4>
                        <p><?php echo $row["regno"]?></p>

                        <h4>Faculty</h4>
                        <p><?php echo $row["faculty"]?></p>

                        <h4>Department</h4>
                        <p><?php echo $row["dept"]?></p>

                        <h4>Entry Year</h4>
                        <p><?php echo $row["entry-year"]?></p>

                        <h4>Graduation Year</h4>
                        <p><?php echo $row["grad-year"]?></p>

                        <h4>Level</h4>
                        <p><?php echo $row["study-year"]?></p>

                        <h4>Email</h4>
                        <p><?php echo $row["email"]?></p>

                    </div>

                    <!--UPDATE FORM-->
                    <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab" >

                    <form method="POST" id="stuff">

                        <div><?php echo $error ?></div>
                        
                        <div class="form-group">
                            <label for="fname">First Name</label>
                            <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter First Name">
                        </div>

                        <div class="form-group">
                            <label for="sname">Surname</label>
                            <input type="text" class="form-control" id="sname" name="sname" placeholder="Enter your Surname">
                        </div>

                        <div class="form-group">
                            <label for="faculty">Faculty</label>
                            <select id="faculty" class="form-control" name="faculty">
                                <option selected>Select Faculty</option>
                                <option>Environmental Studies</option>
                                <option>Public Administration</option>
                                <option>Health Sciences</option>
                            </select>
                        </div>

                        <div class="form-group">
                        <label for="dept">Department</label>
                            <select id="dept" class="form-control" name="dept">
                                <option selected>Select Department</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="entry-year">Entry Year</label>
                            <select id="entry-year" class="form-control col-md-4" name="entry-year">
                                <option selected>2010</option>
                                <option>2011</option>
                                <option>2012</option>
                                <option>2013</option>
                                <option>2014</option>
                                <option>2015</option>
                                <option>2016</option>
                                <option>2017</option>
                                <option>2018</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="grad-year">Graduation Year</label>
                            <select id="grad-year" class="form-control col-md-4" name="grad-year">
                                <option selected>2019</option>
                                <option>2020</option>
                                <option>2021</option>
                                <option>2022</option>
                                <option>2023</option>
                                <option>2024</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="level">Study Level</label>
                            <select id="level" class="form-control col-md-4" name="level">
                                <option selected>100 Level</option>
                                <option>200 Level</option>
                                <option>300 Level</option>
                                <option>400 Level</option>
                                <option>500 Level</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
                        </div>

                        <button type="submit" <?php echo $disabled ?> class="btn btn-primary" name="submit-details" value="Submit Details">Submit Details</button>
                    
                    </form>

                    </div>
                    <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">Unboxed Settings</div>
                </div>
            </div>
            <div class="col-4">

                <h1>Check this out for school news</h1>
                <h3>[This is a dummy nonetheless]</h3>

            </div>
        </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script>
        
        const dept = document.querySelector("#dept");
        const faculty = document.querySelector("#faculty");
        let envArray = []

        faculty.addEventListener("click", function() {

            faculty.addEventListener("change", function() {

                while (dept.firstChild) {

                    dept.removeChild(dept.firstChild);

                }

                if (faculty.value == "Environmental Studies") {

                    envArray = ["Geoinformatics and Surveying", "Urban and Regional Planning", "Architecture", "Estate Management"];

                    for (let i = 0; i <= envArray.length - 1; i++) {

                        console.log(envArray.length);
                        var envOptions = document.createElement("option");
                        envOptions.textContent = envArray[i];
                        dept.appendChild(envOptions);

                    }

                } else if (faculty.value == "Public Administration") {

                    envArray = ["Banking and Finance", "Marketing", "Public Management", "Accountancy"];

                    for (let i = 0; i <= envArray.length - 1; i++) {

                        var envOptions = document.createElement("option");
                        envOptions.textContent = envArray[i];
                        dept.appendChild(envOptions);

                    }

                } else if (faculty.value == "Health Sciences") {

                    envArray = ["Medical Rehabilitation", "Medical Laboratory Science", "Radiography", "Medicine and Surgery"];                    for (let i = 0; i <= envArray.length - 1; i++) {

                        var envOptions = document.createElement("option");
                        envOptions.textContent = envArray[i];
                        dept.appendChild(envOptions);

                    }

                }

            })

        })

        dept.addEventListener("click", function() {

            if (faculty.value == "Select Faculty") {

                alert("Choose Faculty First");

            }

        })

    </script>
  </body>
</html>