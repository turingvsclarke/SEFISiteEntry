<div >
    <form id="newProject" method="POST" action="admin/newProject.php">
        <label for="projNum">Project number</label><br/>
        <input type="number" name="projNum"><br/><br/>
        <label for="title">Title</label><br/>
        <input type="text" name="title"><br/><br/>
        <label for="abstract">Abstract</label><br/>
        <input type="text" name="abstract"><br/><br/>
        <label for="gradeLevel">Grade Level</label><br/>
        <select>
            <option selected>-- select --</option>
            <option value="">1 - 2</option>
            <option value="">3 - 4</option>
            <option value="">5 - 6</option>
            <option value="">7 - 8</option>
            <option value="">9 - 10</option>
        </select><br/><br/>
        <label for="category">Category</label><br/>
        <select>
            <option selected>-- select --</option>
            <option value="">category 1</option>
            <option value="">category 2</option>
            <option value="">category 3</option>
            <option value="">category 4</option>
            <option value="">category 5</option>
        </select><br/><br/>
        <label for="booth">Booth number</label><br/>
        <input type="number" name="booth"><br/><br/>
        <label for="cn">CourseNetwork ID</label><br/>
        <input type="number" name="cn"><br/><br/>
        <label for="year">Year</label><br/>
        <input type="number" min="2020" name="year"><br/>
        <br/><br/>
        <button type="submit">submit</button><span id="newProjectResponse"></span>
    </form>
</div>