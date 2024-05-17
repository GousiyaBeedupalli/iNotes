<?php

// INSERT INTO `notes` (`sno`, `title`, `description`, `tstamp`) VALUES 
// (NULL, 'Go to buy books', 'Purchase books', current_timestamp());
//Connect to the Database
$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";
$conn = mysqli_connect($servername, $username, $password, $database);
$insert = false;
$update=false;
$delete=false;

if (!$conn) {
    die("Sorry we failed to connect:" . mysqli_connect_error());
}
if(isset($_GET['delete'])){
    $sno = $_GET['delete'];
    $delete = true;
    $sql = "DELETE FROM `notes`  WHERE `sno`=$sno;";
        $result = mysqli_query($conn, $sql);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if(isset($_POST['snoEdit'])){
        //Update the notes
        $sno=$_POST["snoEdit"];
        $title = $_POST["titleEdit"];
        $description = $_POST["descriptionEdit"];
        $sql = "UPDATE `notes` SET `title` = '$title',`description` = '$description' WHERE `notes`.`sno`=$sno;";
        $result = mysqli_query($conn, $sql);
        if($result){
            $update=true;
        }
        else{
            echo "We couldn't updated the record successfully";
        }
        
    }
    else{
    $title = $_POST["title"];
    $description = $_POST["description"];
    $sql = "INSERT INTO `notes` (`title`,`description`) VALUES ('$title','$description')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        // echo "The record has been Inserted Successfully!";
        $insert = true;
    } else {
        echo "The record has been Inserted Successfully!";
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <style>
        body,#myTable
        {
            color: white;
            font-family:'Times New Roman', Times, serif ;
        }
        .black
        {
            color: black;
        }
    </style>

    <title>iNotes - Notes Taking Made Easy</title>
    
</head>

<body style="background-color: #001233;">
    <!-- Edit modal -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal">
  Edit Modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title black" id="editModalLabel">Edit this Note</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="index.php" method="post">
      <div class="modal-body">
        <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="form-group">
                <label for="titleEdit" class="black">Note Title</label>
                <input type="text" class="form-control black" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
                <label for="descriptionEdit" class="black">Note Description</label>
                <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
            </div>
        </div>
        <div class="modal-footer d-block mr-auto">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
    </div>
  </div>
</div>
    <nav class="navbar navbar-expand-lg navbar-dark " style="background-color: #329d9c;">
        <a class="navbar-brand" href="#"><img src="logo1.jpeg" alt="" height="50px" width="50px" style="border-radius: 50%;"></a>
        <a class="navbar-brand" href="#">iNotes</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact Us</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>
    <!-- Image and text -->
<!-- <nav class="navbar navbar-light" style="background-color: #15133C;">
  <a class="navbar-brand" href="#">
    <img src="/docs/4.4/assets/brand/bootstrap-solid.svg" width="30" height="30" class="d-inline-block align-top" alt="">
    iNotes
  </a>
</nav> -->

    <?php
        if ($insert) {
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Success!</strong> Your note has been inserted Successfully.
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button>
            </div>";
        }
        if ($delete) {
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Success!</strong> Your note has been Deleted Successfully.
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button>
            </div>";
        }
        if ($update) {
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Success!</strong> Your note has been Updated Successfully.
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button>
            </div>";
        }
    ?>

    <div class="container my-3">
        <h2>Add a Note to iNotes </h2>
        <form action="/crud/index.php" method="post">
            <div class="form-group">
                <label for="title">Note Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
                <label for="description">Note Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Note</button>
        </form>
    </div>

    <div class="container my-4">


        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `notes`";
                $result = mysqli_query($conn, $sql);
                $no = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $no=$no+1;
                    echo " <tr>
                    <th scope='row'>" . $no . "</th>
                    <td>" . $row['title'] . "</td>
                    <td>" . $row['description'] . "</td>
                    <td> <button class='btn btn-sm btn-primary edit' id=".$row['sno'].">Edit</button>
                    <button class='delete btn btn-sm btn-danger' id=d".$row['sno']." >Delete</button></td>
                    </tr>";
                    // echo $row['sno']." Title ".$row['title'] ." Description is " .$row['description']."<br>";
                    // echo var_dump($row)."<br>" ;
                }
                ?>

            </tbody>
        </table>
        <hr>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <script src="//cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
    <script>
        const edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element)=>{
            element.addEventListener("click",(e)=>{
                console.log("edit");
                tr=e.target.parentNode.parentNode;
                title=tr.getElementsByTagName("td")[0].innerText;
                description=tr.getElementsByTagName("td")[1].innerText;
                console.log(title,description);
                titleEdit.value=title;
                descriptionEdit.value=description;
                snoEdit.value=e.target.id;
                console.log(e.target.id );
                $('#editModal').modal('toggle');
            })
        })
        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element)=>{
            element.addEventListener("click",(e)=>{
                console.log("delete");

                sno = e.target.id.substr(1,);
                console.log(sno);
                if(confirm("Are you Sure.You want to Delete this Note!")){
                    console.log("Yes");
                    window.location = `/crud/index.php?delete=${sno}`;
                    //TODO: Create a form and usse Post request to submit a form
                }
                else{
                    console.log("No");
                }
            })
        })
    </script>

</body>

</html>