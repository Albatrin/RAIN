<div class="container">
    <h3>Spremeni geslo</h3>
    <form action="/users/update_password" method="POST">
        <div class="form-group mb-3">
            <label for="old_password">Staro geslo:</label>
            <input type="password" id="old_password" name="old_password" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label for="new_password">Novo geslo:</label>
            <input type="password" id="new_password" name="new_password" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label for="confirm_new_password">Potrdi novo geslo:</label>
            <input type="password" id="confirm_new_password" name="confirm_new_password" class="form-control" required>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Spremeni geslo</button>
        </div>
    </form>
</div>