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

// redirect to upload form if no file has been uploaded or an error occurred
if (!isset($_FILES['fileToUpload']) || $_FILES['fileToUpload']['error'] > 0) {
  header('Location: index.html');
  exit;
}

// configuration
$uploadDirectory = getcwd() . '/uploads/';
$fileExtensionsAllowed = ['jpeg', 'jpg', 'png']; // These will be the only file extensions allowed
$mimeTypesAllowed = ['image/jpeg', 'image/png']; // These will be the only mime types allowed
$maxFileSizeInBytes = 1024 * 1024 * 5; // 5 megabytes

// extract data about the uploaded file
['name' => $fileName, 'tmp_name' => $fileTempName, 'type' => $fileType, 'size' => $fileSize] = $_FILES['fileToUpload'];
['extension' => $fileExtension] = pathinfo($fileName);

$errors = [];

// validate the file extension is in our allow list
if (!in_array($fileExtension, $fileExtensionsAllowed, strict: true)) {
  $errors[] = 'File must have one of the following extensions: ' . implode(', ', $fileExtensionsAllowed) . '.';
}

// validate the file is an allowed mime type based on actual contents
$detectedType = mime_content_type($fileTempName) ?: 'unknown type';
if (!in_array($detectedType, $mimeTypesAllowed, strict: true)) {
  $errors[] = 'File must have one of the following mime types: ' . implode(', ', $mimeTypesAllowed) . '.';
}

// validate if the file already exists
$uploadPath = $uploadDirectory . $fileName;
if (file_exists($uploadPath)) {
  $errors[] = 'File with the same name already exists.';
}

// validate the maximum file size
if ($fileSize > $maxFileSizeInBytes) {
  $errors[] = 'File must not be greater than ' . number_format($maxFileSizeInBytes) . ' bytes.';
}

// verify for errors and move the file upon successful validation
if (count($errors) > 0) {
  echo '<h3>Errors</h3>';
  echo '<ul>';
  foreach ($errors as $error) {
    echo '<li>' . $error . '</li>';
  }
  echo '</ul>';

  exit;
}

if (move_uploaded_file($fileTempName, $uploadPath)) {
  echo 'The file has been successfully uploaded. <br>';
} else {
  echo 'There was an error uploading your file. <br>';
}

        if (isset($_POST["skills"]))
            $skills = sanitise_input($_POST["skills"]);	             //get Other Skills
            echo "<b>Other skills:</b> $skills";
		
	?>
</body>
</html>
