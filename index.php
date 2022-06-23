<!-- INSERT INTO `datacollector` (`sno`, `title`, `description`, `tstamp`) VALUES (1, 'this is text title', '', current_timestamp()), (NULL, 'this is text description', '', current_timestamp()); -->

<!-- connecting to database -->
<?php

$servername="localhost";
$username="root";
$password="";
$database="inotes";

// create a connection
$conn=mysqli_connect($servername,$username,$password,$database);
if(!$conn){
die("sorry we got fucked up!!!".mysqli_connect_error());
}

//for delete
if(isset($_GET['delete'])){
  $sno=$_GET['delete'];
  $sql="DELETE FROM `datacollector` WHERE `sno`=$sno";
  $result=mysqli_query($conn,$sql);
 
}


// for update
if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST['snoEdit']))
    {
        $sno=$_POST['snoEdit'];
        $title=$_POST['titleEdit'];
        $description=$_POST['descriptionEdit'];
        
        
        $sql="UPDATE `datacollector` SET `title` = '$title' , `description` = '$description' WHERE `datacollector`.`sno` = $sno";
        $result=mysqli_query($conn,$sql);


        if($result){
          echo '<div class="alert alert-success alert-dismissible" role="alert">
          <strong>SUCCESS</strong> your record has been updated!! <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
      }
      else{
          echo '<div class="alert alert-success alert-dismissible" role="alert">
          <strong>Something got wrong! </strong>your response has npt been submitted. <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
      }


    }




    // for insertion
    else{
        $title=$_POST['title'];
        $description=$_POST['description'];
        
        
        $sql="INSERT INTO `datacollector` (`title`, `description`) VALUES ('$title', '$description')";
        $result=mysqli_query($conn,$sql);
        if($result){
            echo '<div class="alert alert-success alert-dismissible" role="alert">
            <strong>SUCCESS</strong> your record has been inserted!! <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
        else{
            echo '<div class="alert alert-success alert-dismissible" role="alert">
            <strong>Something got wrong! </strong>your response has npt been submitted. <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    }
}
    
?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>INotes</title>

  <!-- bootstrap css link -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">


  <!-- data table css link -->
  <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">


</head>

<body>




  <!-- modal khtm -->



  <!-- navbar start here -->

  <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">iNotes</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact Us</a>
          </li>

        </ul>
        <form class="d-flex" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>

  <!-- navbar ends here -->


  <div class="container my-4">
    <!-- form start -->
    <h1>Add a Note</h1>
    <form aciton="/crud/index.php" method="post">
      <div class="mb-3">
        <label for="title" class="form-label">Note Title</label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">


        <!-- text area started -->
        <div class="mb-3 my-3">
          <label for="description" class="form-label">Note Description
          </label>
          <textarea class="form-control" id="description" name="description" rows="6"></textarea>
        </div>
        <!-- text area ended -->
        <button type="submit" class="btn btn-primary">Add Notes</button>
    </form>

    <!-- form ends -->
  </div>
  <div class="container">


    <!-- table start here -->
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">Sno.</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>

        <?php

        // selecting/displaying querry
        $sql="SELECT * FROM `datacollector`";
        $result=mysqli_query($conn,$sql);
// find number or rows
$num= mysqli_num_rows($result);
if($num>0)
{
    $sno=0;
    while($row=mysqli_fetch_assoc($result))
    {   
       ++$sno;
        echo "  <tr>
        <th scope='row'>". $sno."</th>
        <td>".$row['title']."</td>
        <td>".$row['description']."</td>
        <td><button class=' edit btn btn-sm btn-primary mx-1 my-1' id=".$row['sno'].">Edit</button>  <button class='delete btn btn-sm btn-danger mx-1 my-1' id=d".$row['sno']." >Delete</button></td>
      </tr>";
    }
}

    ?>




      </tbody>
    </table>
    <!-- table ends here -->
  </div>


  <!-- modal edit krna -->

  <!-- Button trigger modal -->
  <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
  Edit Modal
</button> -->

  <!-- Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Text</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form aciton="/crud/index.php" method="post">
          <div class="modal-body">

            <div class="mb-3">
              <input type="hidden" name="snoEdit" id="snoEdit">
              <label for="titleEdit" class="form-label">Note Title</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">


              <!-- text area started -->
              <div class="mb-3 my-3">
                <label for="descriptionEdit" class="form-label">Note Description
                </label>
                <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="6"></textarea>
              </div>
              <!-- text area ended -->
              <!-- <button type="submit" class="btn btn-primary">Update Notes</button> -->

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </form>
      </div>
    </div>


    <!-- bootstrap js link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
      crossorigin="anonymous"></script>

    <!-- jquerry link -->

    <script src="https://code.jquery.com/jquery-3.6.0.js"
      integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <!-- data table js link -->
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>



    <script>
      $(document).ready(function () {
        $('#myTable').DataTable();
      });
    </script>

    <script>

      // edit javascript

      edits = document.getElementsByClassName('edit');
      Array.from(edits).forEach((element) => {
        element.addEventListener("click", (e) => {
          tr = e.target.parentNode.parentNode;
          title = tr.getElementsByTagName("td")[0].innerText;
          description = tr.getElementsByTagName("td")[1].innerText;
          console.log(title, description);
          descriptionEdit.value = description;
          titleEdit.value = title;
          snoEdit.value = e.target.id;
          console.log(e.target.id);
          $('#editModal').modal('toggle');
        })
      })

      // delete javascript

      deletes = document.getElementsByClassName('delete');
      Array.from(deletes).forEach((element) => {
        element.addEventListener("click", (e) => {
          sno = e.target.id.substr(1,);
          if (confirm("Press a button!")) {
            console.log("yes");
            window.location = `/crud/index.php?delete=${sno}`;
          }
          else {
            console.log("no");
          }
        })
      })


    </script>


</body>

</html>