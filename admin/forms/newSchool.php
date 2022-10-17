<div >
    <form id="newSchool" method="POST" action="admin/newSchool">
        <label for="name">School name</label><br/>
        <input type="text" name="name"><br/><br/>
        <label for="city">City</label><br/>
        <input type="text" name="city"><br/><br/>
        <label for="county">County</label><br/>
        <select>
            <option selected>-- select --</option>
            <option value="">county 1</option>
            <option value="">county 2</option>
            <option value="">county 3</option>
            <option value="">county 4</option>
            <option value="">county 5</option>
        </select><br/><br/>
        <button type="submit">submit</button><span id="newSchoolResponse"></span>
    </form>
</div>