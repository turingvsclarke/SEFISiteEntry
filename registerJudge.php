<?php
    session_start();
    if (isset($_SESSION["user"])) {
        $type = $_SESSION["type"];
        $id = $_SESSION["id"];
        $email = $_SESSION["user"];
    }

    // mysql server
    $srv_hostname = "localhost";
    $srv_username = "ryeades";
    $srv_password = "ryeades";

    try {
        $conn = new PDO("mysql:host=$srv_hostname;dbname=ryeades_db",$srv_username,$srv_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM PROJECT_GRADE_LEVEL";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $gradeLevels = $stmt->fetchAll();

        $sql = "SELECT * FROM CATEGORY";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $categories = $stmt->fetchAll();


        $conn->exec($sql);

    } catch (PDOException $e) {
        echo "didn't work " . $e;
    }
?>

<!DOCTYPE html>
<html lang="en">
<title>W3.CSS Template</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="assets/css/w3.css">
<link rel="stylesheet" href="assets/css/w3-theme-black.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
<link rel="stylesheet" href="assets/css/font-awesome.min.css">
<link rel="stylesheet" href="assets/css/our.css">
<style>
html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif;}
.w3-sidebar {
  z-index: 3;
  width: 250px;
  top: 43px;
  bottom: 0;
  height: inherit;
}
</style>
<body>
<?php
    require "assets/navbar.php";
    require "assets/sidebar.php";	

?>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- Main content: shift it to the right by 250 pixels when the sidebar is visible -->
<div class="w3-main our-main" style="margin-left:250px">

  <div class="w3-row w3-padding-64">

    <div id="formSpace" class="w3-twothird w3-container">
      <h1 class="w3-text-teal">Register new Judge</h1><br/><br/><br/>
      <?php if (isset($_GET['invalid']) && $_GET['invalid']) echo "<p style='color:red;'>Invalid form, please try again</p>";?>
      <form method="POST" action="admin/actions/newJudge.php">
        <label for="firstName">First name</label><br/>
        <input type="text" name="firstName"><br/><br/>
        <label for="middleName">Middle name</label><br/>
        <input type="text" name="middleName"><br/><br/>
        <label for="lastName">Last name</label><br/>
        <input type="text" name="lastName"><br/><br/>
        <label for="title">Title</label><br/>
        <input type="text" name="title"><br/><br/>
        <p>gender</p>
        <label for="male">male</label>
        <input name="gender" type="radio" value="male">
        <label for="female">female</label>
        <input name="gender" type="radio" value="female">
        <label for="other">other</label>
        <input name="gender" type="radio" value="other"><br/><br/>
        <label for="gradeLevelPref">Preferred grade Level</label><br/>
        <select name = "gradeLevelPref">
            <option selected>-- select --</option>
            <?php for($i=0;$i<count($gradeLevels);$i++) echo "<option value='".$gradeLevels[$i]['GradeLevelID']."'>".$gradeLevels[$i]['LevelName']."</option>" ?>
        </select><br/><br/>
        <label for="categoryPref">Preferred category</label><br/>
        <select name="categoryPref">
            <option selected>-- select --</option>
            <?php for($i=0;$i<count($categories);$i++) echo "<option value='".$categories[$i]['CategoryID']."'>".$categories[$i]['CategoryName']."</option>" ?>
        </select><br/><br/>
        <label for="degree">Highest Degree Earned</label><br/>
        <input type="text" name="degree"><br/><br/>
        <label for="employer">Employer</label><br/>
        <input type="text" name="employer"><br/><br/>
        <label for="email">Email address</label><br/>
        <input type="text" name="email"><br/><br/>
        <label for="username">Username</label><br/>
        <input type="text" name="username"><br/><br/>
        <label for="password">Password</label><br/>
        <input type="password" name="password"><br/><br/>
        <label for="year">Year</label><br/>
        <input type="number" min="2020" name="year"><br/>
        <br/><br/>
        <button type="submit">submit</button>
    </form>

      <p hidden>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum
        dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>
    <div class="w3-third w3-container">

    </div>
  </div>

  <div style="display:none" class="w3-row">
    <div class="w3-twothird w3-container">
      <h1 class="w3-text-teal">Heading</h1>
      <p></p>
    </div>
    <div class="w3-third w3-container">

    </div>
  </div>

  <div style="display:none" class="w3-row w3-padding-64">
    <div class="w3-twothird w3-container">
      <h1 class="w3-text-teal">Heading</h1>
      <p></p>
    </div>
    <div class="w3-third w3-container">

    </div>
  </div>

  <!-- Pagination -->
  <div style="display:none" class="w3-center w3-padding-32">
    <div class="w3-bar">
      <a class="w3-button w3-black" href="#">1</a>
      <a class="w3-button w3-hover-black" href="#">2</a>
      <a class="w3-button w3-hover-black" href="#">3</a>
      <a class="w3-button w3-hover-black" href="#">4</a>
      <a class="w3-button w3-hover-black" href="#">5</a>
      <a class="w3-button w3-hover-black" href="#">&raquo;</a>
    </div>
  </div>

  <footer id="myFooter">
    <div class="w3-container w3-theme-l2 w3-padding-32">
      <h4>Footer</h4>
    </div>

    <div class="w3-container w3-theme-l1">
      <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
    </div>
  </footer>

<!-- END MAIN -->
</div>

<!--- sidebar script-->
<script src="/assets/js/sidebar.js"></script>

</body>
</html>
