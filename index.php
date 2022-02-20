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
$file = "";
$error = "";
$success = "";

if (isset($_GET['op'])){
    $op = $_GET['op'];
}else{
    $op = "";
}
if($op === 'edit'){
    $id = $_GET['id'];
    $sql3 = "select * from documents where id = '$id'";
    $q3 = mysqli_query($connection,$sql3);
    $r1 = mysqli_fetch_array($q3);
    if($r1){
        $id = $r1['id'];
        $title = $r1['title'];
    }

    if ($title == "") {
        $error = "Document Not Found";
    }
}

if ($op === 'delete'){
    $id = $_GET['id'];
    $sql5 = "delete from documents where id = '$id'";
    $q5 = mysqli_query($connection,$sql5);

    if ($q5) {
        $success = "Success Delete Document";
    }else{
        $error = "Failed Delete Document";
    }
} 

if (isset($_POST['submit'])) {// add document
   $title = $_POST['title'];
   $file = $_FILES['file'];

   if ($title) {
    if ($op === 'edit') {
        $sql4 = "update documents set title = '$title' where id = '$id'";
        $q4 = mysqli_query($connection,$sql4);

        if ($q4) {
              $success = "Success Updating Document";
              header("location: index.php");
        }else{
            $error = "Failed Updating Data";
        }
    }else{
        $sql1 = "insert into documents (title) values('$title')";
        $q1 = mysqli_query($connection,$sql1);
  
          if ($q1) {
              $success = "Success Add New Document";
              header("location: index.php");
          }else{
              $error = "Failed Add New Document";
          }  
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
            width: 70%;
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
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3 row">
                            <label for="name" class="col-sm-2 col-form-label">Title </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="title" name="title" placeholder="Document Title" value="<?php echo $title ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                            <label for="name" class="col-sm-2 col-form-label">File </label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" id="title" name="file" placeholder="Document Title" value="<?php echo $file ?>">
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
                Documents List
            </div>
            <div class="card-body">
               <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql2 = "select * from documents order by id";
                            $q2 = mysqli_query($connection,$sql2);
                            $index = 1;
                            while($r2 = mysqli_fetch_array($q2)){
                                $id = $r2['id'];
                                $title = $r2['title'];
                            ?>
                            <tr>
                               <td scope="row"><?php echo $index++  ?></th> 
                               <td scope='row'><?php echo $title  ?></td>
                               <td>
                                   <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-success">Edit</button></a>
                                   <a href="index.php?op=delete&id=<?php echo $id ?>"><button type="button" class="btn btn-danger" onclick="return confirm('are you gonna delete this document?')">Delete</button></a> 
                               </td>
                            </tr>
                        <?php
                            }
                        ?>
                    </tbody>
               </table>
            </div>
        </div>
    </div>
</body>
</html>