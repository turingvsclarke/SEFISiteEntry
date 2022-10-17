<div >
    <form id="newAdmin" method="POST" action="admin/newAdmin">
        <label for="username">username</label><br/>
        <input type="text" name="username"><br/><br/>
        <label for="password">password</label><br/>
        <input type="password" name="password"><br/><br/>
        <label for="level">level</label><br/>
        <select>
            <option selected>-- select --</option>
            <option value="">basic</option>
            <option value="">super</option>
            <option value="">chair</option>
        </select><br/><br/>
        <button type="submit">submit</button><span id="newAdminResponse"></span>
    </form>
</div>