<div class="container">
    <h3>Seznam novic</h3>
    <div class="article">
        <h4><?php echo $article->title;?></h4>
        <p><b>Povzetek:</b> <?php echo $article->abstract;?></p>
        <p><?php echo $article->text; ?></p>
        <p>Objavil: <?php echo $article->user->username; ?>, <?php echo date_format(date_create($article->date), 'd. m. Y \ob H:i:s'); ?></p>
        <a href="/"><button>Nazaj</button></a>
    </div>
    
    <div class="comments-section mt-4">
        <h3>Komentarji</h3>
        
        <?php
        require_once('models/comments.php');
                $comments = Comment::find_by_article($article->id);
        if (!empty($comments)):
        ?>
            <div class="comments-list">
                <?php foreach($comments as $comment): ?>
                    <div class="comment card mb-3">
                        <div class="card-header d-flex justify-content-between">
                            <span class="fw-bold"><?php echo htmlspecialchars($comment->username); ?></span>
                            <span class="text-muted"><?php echo date_format(date_create($comment->created_at), 'd. m. Y \ob H:i:s'); ?></span>
                        </div>
                        <div class="card-body">
                            <?php echo nl2br(htmlspecialchars($comment->content)); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Ta članek še nima komentarjev.</p>
        <?php endif; ?>
        
        <?php if(isset($_SESSION["USER_ID"])): ?>
            <div class="comment-form mt-4">
                <h4>Dodaj komentar</h4>
                <form action="/comments/addComment" method="POST">
                    <input type="hidden" name="article_id" value="<?php echo $article->id; ?>">
                    <div class="form-group mb-3">
                        <textarea name="content" class="form-control" rows="3" placeholder="Vnesi svoj komentar..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Objavi komentar</button>
                </form>
            </div>
        <?php else: ?>
            <div class="alert alert-info mt-4">
                Za komentiranje se morate <a href="/auth/login">prijaviti</a>.
            </div>
        <?php endif; ?>
        
        <!-- Prikaz sporočil -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success mt-3"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger mt-3"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
    </div>
</div>