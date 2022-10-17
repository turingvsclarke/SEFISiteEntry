<?php 

    // mysql server
    $srv_hostname = "localhost";
    $srv_username = "ryeades";
    $srv_password = "ryeades";

    try {
        $conn = new PDO("mysql:host=$srv_hostname;dbname=ryeades_db",$srv_username,$srv_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM SCHOOL";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $schools = $stmt->fetchAll();

        $sql = "SELECT ProjectID,ProjectNumber FROM PROJECT";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $projects = $stmt->fetchAll();

    } catch (PDOException $e) {
        echo "didn't work " . $e;
    }

?>


<div >
    <form id="newStudent" method="POST" action="actions/newStudent.php">
        <label for="firstName">First name</label><br/>
        <input type="text" name="firstName"><br/><br/>
        <label for="lastName">Last name</label><br/>
        <input type="text" name="lastName"><br/><br/>
        <label for="middleName">Middle name</label><br/>
        <input type="text" name="middleName"><br/><br/>
        <label for="grade">Grade</label><br/>
        <input type="number" name="grade"><br/><br/>
        <label for="gender">Gender</label><br/>
        <input type="radio" name="gender" value="male"><label for="male">male</label>
        <input type="radio" name="gender" value="female"><label for="female">female</label>
        <input type="radio" name="gender" value="other"><label for="other">other</label>
        <br/><br/>
        <label for="school">School</label><br/>
        <select>
            <option selected>-- select --</option>
            <?php for($i=0;$i<count($schools);$i++) echo "<option value='".$schools[$i]['SchoolID']."'>".$schools[$i]['SchoolName']."</option>" ?>
        </select><br/><br/>
        <label for="projNum">Project number</label><br/>
        <input type="text" name="projNum" list="projList">
            <datalist id="projList">
                <option value="project 1">
                <option value="project 2">
                <option value="project 3">
                <option value="project 4">
                <option value="project 5">
            </datalist><br/><br/>
        <label for="year">Year</label><br/>
        <input type="number" min="2020" name="year"><br/><br/>
        <br/><br/>
        <button type="submit">submit</button><span id="newStudentResponse"></span>
    </form>
</div>
