<div class="container">
    <h3>Objavi novico</h3>
    <form action="/articles/store" method="POST">
        <div class="form-group mb-3">
            <label for="title">Naslov:</label>
            <input type="text" id="title" name="title" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label for="abstract">Povzetek:</label>
            <textarea id="abstract" name="abstract" class="form-control" rows="3" required></textarea>
        </div>

        <div class="form-group mb-3">
            <label for="text">Vsebina:</label> 
            <textarea id="text" name="text" class="form-control" rows="10" required></textarea>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Objavi</button>
        </div>
    </form>
</div>
