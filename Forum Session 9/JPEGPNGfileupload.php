<?php

  $Email = $FileError = "";
  
  if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
    $Email = test_input($_POST["Email"]);
    $File = $_FILES["File"];
    $role = $_POST["role"];
    
    if (!filter_var($Email, FILTER_VALIDATE_EMAIL))
    {
      $EmailError = "Email address invalid.";
    }
    
    $AllowedExtensions = array("jpeg", "jpg", "png");
    $FileExtension = strtolower(pathinfo($File["Name"], PATHINFO_EXTENSION));
    
    if (!in_array($FileExtension, $AllowedExtensions)) 
    {
      $FileError = "Please input a JPEG or PNG file.";
    }

    if ($role === "A") {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
            $stmt = $conn->prepare("INSERT INTO uploaded_files (email, file_path) VALUES (?, ?)");
            $stmt->bind_param("ss", $email, $targetFile);
          
        if (empty($EmailError) && empty($FileError)){
            $TargetDirectory = "uploads/";
            $TargetFile = $TargetDirectory . basename($File["Name"]);
      
        if (move_uploaded_file($File["tmp_name"], $TargetFile)){
            echo "File uploaded successfully.";
        } else {
          echo "Error uploading your file.";
        }
      } elseif ($role === "B") {
          echo "You are not authorized.";
        } else {
            echo "Error uploading file.. :(";
            echo "Invalid role selection.";
        }
  }
  
  function test_input($data) 
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  ?>
