<div class="container">
    <h3>Objavi novico</h3>
    <form action="/objavi-novico" method="POST">
        <div class="form-group">
            <label for="naslov">Naslov:</label>
            <input type="text" id="naslov" name="naslov" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="vsebina">Vsebina:</label>
            <textarea id="vsebina" name="vsebina" class="form-control" rows="10" required></textarea>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Objavi</button>
        </div>
    </form>
</div>