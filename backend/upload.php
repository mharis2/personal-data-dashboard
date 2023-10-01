<?php
$target_dir = "../data/input/";
$target_file = $target_dir . "uploaded.csv"; // Ensure the uploaded file is consistently named
$uploadOk = 1;

$fileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));

// Check if file is a CSV
if (isset($_POST["submit"])) {
    if ($fileType != "csv") {
        echo "Sorry, only CSV files are allowed.";
        $uploadOk = 0;
    }
}

// Attempt to upload file
if ($uploadOk == 1) {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
        
        // Calling the Perl script after successful file upload
        $output = shell_exec('perl ./scripts/process.pl 2>&1');
        echo "<pre>Processing Result: $output</pre>";

        // Reading and displaying the processed data
        $processed_file = "../data/output/processed.csv";
        if (file_exists($processed_file)) {
            $rows = array_map('str_getcsv', file($processed_file));
            echo "<table border='1'>";
            foreach ($rows as $row) {
                echo "<tr>";
                foreach ($row as $cell) {
                    echo "<td>$cell</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        }

    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>

<a href="../frontend/index.php">Return to upload page</a>

