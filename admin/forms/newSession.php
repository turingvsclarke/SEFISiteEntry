<div >
    <form id="newSession" method="POST" action="actions/newSession.php">
        <label for="sessNum">Session number</label><br/>
        <input type="number" name="sessNum"><br/><br/>
        <label for="start">Start time</label><br/>
        <input type="time" min="00:00" max="23:00" name="start"><br/><br/>
        <label for="end">End time</label><br/>
        <input type="time" min="00:00" max="23:00" name="end">
        <br/><br/>
        <button type="submit">submit</button><span id="newSessionResponse"></span>
    </form>
</div>
