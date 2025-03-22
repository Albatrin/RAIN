<div class="container">
    <p><strong>Uporabniško ime:</strong> <?php echo htmlspecialchars($user->username); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user->email); ?></p>
    <p><strong>Število objavljenih novic:</strong> <?php echo $articleCount; ?></p>
    <p><strong>Število napisanih komentarjev:</strong> <?php echo $commentCount; ?></p>
</div>
