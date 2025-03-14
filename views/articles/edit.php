<<div class="container">
    <h3>Uredi novico</h3>
    <form action="/articles/update?id=<?php echo $article->id; ?>" method="POST">
        <input type="hidden" name="id" value="<?php echo $article->id; ?>">

        <div class="form-group mb-3">
            <label for="title">Naslov:</label>
            <input type="text" id="title" name="title" class="form-control" value="<?php echo htmlspecialchars($article->title); ?>" required>
        </div>

        <div class="form-group mb-3">
            <label for="abstract">Povzetek:</label>
            <textarea id="abstract" name="abstract" class="form-control" rows="3" required><?php echo htmlspecialchars($article->abstract); ?></textarea>
        </div>

        <div class="form-group mb-3">
            <label for="content">Vsebina:</label>
            <textarea id="content" name="content" class="form-control" rows="10" required><?php echo htmlspecialchars($article->text); ?></textarea>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-success">Shrani spremembe</button>
        </div>
    </form>
</div>
