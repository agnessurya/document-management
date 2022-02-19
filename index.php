<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "document";

$connection = mysqli_connect($host,$user,$pass,$db);
if (!$connection) {
    die("Could not connect to the database");
}

$title = "";
$error = "";
$success = "";

if (isset($_POST['submit'])) {
   $title = $_POST['title'];

   if ($title) {
      $sql1 = "insert into documents (title) values('$title')";
      $q1 = mysqli_query($connection,$sql1);

        if ($q1) {
            $success = "Success Add New Document";
        }else {
            $error = "Failed Add New Document";
        }  
    }else{
        $error = "Please Input All Data";
    }
}   

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        .mx-auto{
            width: 80%;
        }
        .card{
            margin: 10px
        }
    </style>
</head>
<body>
    <div class="mx-auto">
        <!-- add data -->
        <div class="card">
            <div class="card-header">
                Create / Update Document
            </div>
            <div class="card-body"> 
                <?php
                    if ($error) {
                ?>
                        <div class="alert alert-danger" role="alert">
                           <?php echo $error ?>
                        </div>
                <?php
                    }
                ?>

                <?php
                    if ($success) {
                ?>
                        <div class="alert alert-success" role="alert">
                           <?php echo $success ?>
                        </div>
                <?php
                    }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                            <label for="name" class="col-sm-2 col-form-label">Title </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="title" name="title" placeholder="Document Title" value="<?php echo $title ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="submit" value="submit" class="btn btn-primary"/>
                    </div>
                </form>
            </div>
        </div>
           <!-- show data -->
        <div class="card">
            <div class="card-header text-white bg-primary">
                Documents
            </div>
            <div class="card-body">
               
            </div>
        </div>
    </div>
</body>
</html>