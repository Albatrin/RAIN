<div class="container">
    <h3>Moje novice</h3>
    <?php if (count($articles) > 0): ?>
        <div class="articles">
            <?php foreach ($articles as $article): ?>
                <div class="article mb-4">
                    <h4><?php echo htmlspecialchars($article->title); ?></h4>
                    <p><?php echo htmlspecialchars($article->abstract); ?></p>
                    <p class="text-muted">Objavljeno: <?php echo date_format(date_create($article->date), 'd. m. Y \ob H:i:s'); ?></p>
                    <a href="/articles/show?id=<?php echo $article->id; ?>" class="btn btn-primary">Preberi več</a>
                    <a href="/articles/edit?id=<?php echo $article->id; ?>" class="btn btn-secondary">Uredi</a>
                    <a href="/articles/delete?id=<?php echo $article->id; ?>" class="btn btn-danger">Izbriši</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Trenutno še nimate nobene objavljene novice.</p>
    <?php endif; ?>
</div>