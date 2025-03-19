<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Job Application Form</title>
</head>
<body>
	<h1>Job Application Confirmation</h1>
	<?php
		// Sanitising input method
		function sanitise_input($data){
			$data = trim($data);				//remove spaces
			$data = stripslashes($data);		//remove backslashes in front of quotes
			$data = htmlspecialchars($data);	//convert HTML special characters to HTML code
			return $data;
		}

		//Initial checking if the form was submitted properly
		if (isset($_POST["fname"], $_POST["lname"]))
            $fname = sanitise_input($_POST["fname"]);	             //get firstname
            $lname = sanitise_input($_POST["lname"]);	             //get lastname
            echo "<b>Welcome</b> $fname $lname! <br>";					
		if (isset($_POST["email"]))
            $email = sanitise_input($_POST["email"]);				 //get email
            echo "<b>Your email:</b> $email <br>";
		if (isset($_POST["tel"]))
            $tel = sanitise_input($_POST["tel"]);				     //get telephone
            echo "<b> Telephone number:</b> $tel <br>"; 
		if (isset($_POST["gender"]))
            $gender = sanitise_input($_POST["gender"]);	             //get gender
            echo "<b>Gender:</b> $gender <br>";
        if (isset($_POST["address"]))
            $address = sanitise_input($_POST["address"]);	         //get address
            echo "<b>Address:</b> $address <br>";
        if (isset($_POST["stown"]))
            $stown = sanitise_input($_POST["stown"]);	             //get Suburb/Town
            echo "<b>Suburb/Town:</b> $stown <br>";
        if (isset($_POST["state"]))
            $state = sanitise_input($_POST["state"]);	             //get State
            echo "<b>State:</b> $state <br>";
        if (isset($_POST["jobnumber"]))
            $jobnumber = sanitise_input($_POST["jobnumber"]);	     //get Job Number
            echo "<b>Job reference number:</b> $jobnumber <br>";
        // Handle file upload 
        if (isset($_POST['submit'])){
            $file = $_FILES['file'];
            print_r($file);
            $fileName = $_FILES['file']['name'];
            $fileTMPName = $_FILES['file']['tmp_name'];
            $fileSize = $_FILES['file']['size'];
            $fileError = $_FILES['file']['error'];
            $fileType = $_FILES['file']['type'];

            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));

            $allowed = array('jpg', 'jpeg', 'png', 'pdf');

            if (in_array($fileActualExt, $allowed)) {
               if($fileError === 0) {
                 if ($fileSize < 6000000) {
                    $fileNameNew = uniqid('',true).".".$fileActualExt;
                    $fileDestination = '.uploads/'.$fileNameNew;
                    move_uploaded_file($fileTMPName, $fileDestination);
                    header("location: process_eoi.php?uploadsuccess");
                 }
                 else "You file is too big!<br>";
               } 
               else{
                echo "There was an error uplpading your file!<br>";
               }
            }
            else{
                echo "You cannot upload files of this type!<br>";
            }
        } 

        if (isset($_POST["skills"]))
            $skills = sanitise_input($_POST["skills"]);	             //get Other Skills
            echo "<b>Other skills:</b> $skills"
		
	?>
</body>
</html>
