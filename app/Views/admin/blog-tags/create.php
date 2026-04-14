<form method="POST" action="/admin/posts/store">

    <label>Slug</label>
    <input type="text" name="slug" required>

    <h3>English</h3>
    <input type="text" name="title_en">
    <textarea name="content_en"></textarea>

    <h3>Polish</h3>
    <input type="text" name="title_pl">
    <textarea name="content_pl"></textarea>

    <button type="submit">Save</button>

</form>