<?php

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

<div >
    <form id="newJudge" method="POST" action="actions/newJudge.php">
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
        <button type="submit">submit</button><span id="newJudgeResponse"></span>
    </form>
</div>
