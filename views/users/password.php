<div class="container">
    <h3>Spremeni geslo</h3>
    
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    
    <?php if (!empty($success)): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>
    
    <form action="/users/update_password" method="POST">
        <div class="form-group">
            <label for="old_password">Staro geslo</label>
            <input type="password" id="old_password" name="old_password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="new_password">Novo geslo</label>
            <input type="password" id="new_password" name="new_password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Potrdi novo geslo</label>
            <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Spremeni geslo</button>
    </form>
</div>