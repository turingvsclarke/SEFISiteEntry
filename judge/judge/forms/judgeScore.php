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


    } catch (PDOException $e) {
        echo "didn't work " . $e;
    }

    $conn = null;

?>
<div id="judgeScore" hidden>
    <h2>Judge scoring</h2>
    <form method="POST" action="judge/judgeScore.php">
        <label for="projNum">project number</label><br/>
        <input type="text" name="projNum" list="projList">
            <datalist id="projList">
                <option value="project 1">
                <option value="project 2">
                <option value="project 3">
                <option value="project 4">
                <option value="project 5">
            </datalist><br/><br/>
        <label for="score">Score</label><br/>
        <input type="number" min="1" max="100" name="score"><br/><br/>

        <button type="submit">submit</button>
    </form>
</div>
