<?php
include('dbcon.php');
include('session.php');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset($_POST['import_class_id'])) {
            $get_class_id = $_POST['import_class_id'];
}

if(isset($_POST['save_excel_data']))
{
    $fileName = $_FILES['import_file']['name'];
    $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);

    $allowed_ext = ['xls','csv','xlsx'];

    if(in_array($file_ext, $allowed_ext))
    {
        $inputFileNamePath = $_FILES['import_file']['tmp_name'];
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
        $data = $spreadsheet->getActiveSheet()->toArray();

        $count = "0";
        foreach($data as $row)
        {
            if($count > 0)
            {
                $student_id = $row['0'];
				//separate names
                $name = $row['1'];
				$firstname = trim(explode(',', $name)[1]);
				$lastname = trim(explode(',', $name)[0]);
				$email = $row['2'];
                $username = $row['3'];
				
				//Check if student ID already exists
				$query = mysqli_query($conn, "SELECT * FROM student WHERE username = '$username' ") or die(mysqli_error($conn));
				$count = mysqli_num_rows($query);
				
				if (empty($firstname) or $firstname == 'First Name'){
				} else if ($count > 0) {
					$count = 0;
				}
				else {
					//username and password are the same for student-id
					$studentQuery = "INSERT INTO student (student_id,firstname,lastname,class_id,username,password,status,email) VALUES ('$student_id','$firstname','$lastname','$get_class_id','$username','$username','Unregistered', '$email')";
					$result = mysqli_query($conn, $studentQuery);
					$msg = true;
				}
            }
            else
            {
                $count = "1";
            }
        }

        if(isset($msg))
        {
            $_SESSION['message'] = "Successfully Imported";
            header('Location: admin_students.php');
            exit(0);
        }
        else
        {
            $_SESSION['message'] = "Not Imported";
            header('Location:  admin_students.php');
            exit(0);
        }
    }
    else
    {
        $_SESSION['message'] = "Invalid File";
        header('Location:  admin_students.php');
        exit(0);
    }
}
?>