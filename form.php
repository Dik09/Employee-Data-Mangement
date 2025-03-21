<?php
// Include database connection
include("connection.php"); 

/*******************************
 * SEARCH FUNCTIONALITY
 *******************************/
if (isset($_POST['searchdata'])) {
    $search = $_POST['id']; // Get ID from user input
    $query = "SELECT * FROM form WHERE id = '$search'";
    $data = mysqli_query($conn, $query);

    if ($result = mysqli_fetch_assoc($data)) {
        // Fetch data from database
        $id     = $result['id'];
        $name   = $result['emp_name'];
        $gender = $result['emp_gender'];
        $email  = $result['emp_email'];
        $dept   = $result['emp_dept'];
        $add    = $result['emp_address'];
    } else {
        echo '<script>alert("No Record Found!")</script>';
        // Clear variables if no record found
        $id = $name = $gender = $email = $dept = $add = "";
    }
}

/*******************************
 * SAVE / INSERT FUNCTIONALITY
 *******************************/
if (isset($_POST['save'])) {
    $id     = $_POST['id'];
    $name   = $_POST['name'];
    $gender = $_POST['gender'];
    $email  = $_POST['email'];
    $dept   = $_POST['department'];
    $add    = $_POST['address'];

    // Check if ID already exists
    $checkQuery = "SELECT * FROM form WHERE id = '$id'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        echo '<script>alert("Error: ID already exists! Choose a different ID.")</script>';
    } else {
        // Insert new record
        $query = "INSERT INTO form (id, emp_name, emp_gender, emp_email, emp_dept, emp_address) 
                  VALUES ('$id', '$name', '$gender', '$email', '$dept', '$add')";
        $data = mysqli_query($conn, $query);

        echo $data ? '<script>alert("Data Saved Successfully!")</script>' 
                   : '<script>alert("Failed to save data")</script>';
    }
}

/*******************************
 * MODIFY / UPDATE FUNCTIONALITY
 *******************************/
if (isset($_POST['modify'])) {
    $id     = $_POST['id'];
    $name   = $_POST['name'];
    $gender = $_POST['gender'];
    $email  = $_POST['email'];
    $dept   = $_POST['department'];
    $add    = $_POST['address'];

    $query = "UPDATE form 
              SET emp_name='$name', emp_gender='$gender', emp_email='$email', 
                  emp_dept='$dept', emp_address='$add' 
              WHERE id='$id'";
    $data = mysqli_query($conn, $query);

    echo $data ? '<script>alert("Record Updated Successfully!")</script>' 
               : '<script>alert("Failed to Update Record!")</script>';
}

/*******************************
 * DELETE FUNCTIONALITY
 *******************************/
if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $query = "DELETE FROM form WHERE id='$id'";
    $data = mysqli_query($conn, $query);

    echo $data ? '<script>alert("Record Deleted Successfully!")</script>' 
               : '<script>alert("Failed to Delete Record!")</script>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee Management</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

    <div class="center">
        <form action="" method="POST">
            <h1>Employee Data Management System</h1>

            <div class="form">
                <!-- Employee ID -->
                <input type="text" name="id" class="textfield" placeholder="Enter Employee ID" 
                       value="<?php echo isset($id) ? $id : ''; ?>">

                <!-- Employee Name -->
                <input type="text" name="name" class="textfield" placeholder="Employee Name" 
                       value="<?php echo isset($name) ? $name : ''; ?>">

                <!-- Gender Selection -->
                <select class="textfield" name="gender">
                    <option value="Not Selected">Select Gender</option>
                    <option value="Male"   <?php echo (isset($gender) && $gender == 'Male') ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo (isset($gender) && $gender == 'Female') ? 'selected' : ''; ?>>Female</option>
                    <option value="Others" <?php echo (isset($gender) && $gender == 'Others') ? 'selected' : ''; ?>>Others</option>
                </select>

                <!-- Email Address -->
                <input type="text" name="email" class="textfield" placeholder="Email Address" 
                       value="<?php echo isset($email) ? $email : ''; ?>">

                <!-- Department Selection -->
                <select class="textfield" name="department">
                    <option value="">Select Department</option>
                    <option value="IT"                  <?php echo (isset($dept) && $dept == 'IT') ? 'selected' : ''; ?>>IT</option>
                    <option value="HR"                  <?php echo (isset($dept) && $dept == 'HR') ? 'selected' : ''; ?>>HR</option>
                    <option value="Accounts"            <?php echo (isset($dept) && $dept == 'Accounts') ? 'selected' : ''; ?>>Accounts</option>
                    <option value="Marketing"           <?php echo (isset($dept) && $dept == 'Marketing') ? 'selected' : ''; ?>>Marketing</option>
                    <option value="Sales"               <?php echo (isset($dept) && $dept == 'Sales') ? 'selected' : ''; ?>>Sales</option>
                    <option value="Business Development"<?php echo (isset($dept) && $dept == 'Business Development') ? 'selected' : ''; ?>>Business Development</option>
                    <option value="Others"              <?php echo (isset($dept) && $dept == 'Others') ? 'selected' : ''; ?>>Others</option>
                </select>

                <!-- Address -->
                <textarea placeholder="Address" name="address"><?php echo isset($add) ? $add : ''; ?></textarea>

                <!-- Form Buttons -->
                <input type="submit" value="Search" name="searchdata" class="btn">
                <input type="submit" value="Save" name="save" class="btn" style="background-color:green;">
                <input type="submit" value="Modify" name="modify" class="btn" style="background-color:greenyellow;">
                <input type="submit" value="Delete" name="delete" class="btn" style="background-color:red;" onclick="return checkdelete()">
                <input type="reset" value="Clear" name="clear" class="btn" style="background-color:violet;">
            </div>
        </form>
    </div>

</body>
</html>

<script>
// JavaScript function to confirm delete action
function checkdelete() {
    return confirm("Are you sure you want to delete this record?");
}
</script>
