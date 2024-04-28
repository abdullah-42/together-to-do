  <nav>
      <img style=" float: left" src="img/logo.svg">
      <div class="nav-container">
          <a style=" float: left" href="index.php">Home</a>
          <a style="float: right;" href="profile.php">Profile</a>
          <a style="float: right;" href="logout.php">Logout</a>
      </div>


      <div id="taskForm" style="display: none;">
          <form action="add_tasks.php" method="post">
              <h4>Erstelle ein neues TO-DO</h4>
              <label for="title">Title:</label>
              <input type="text" id="title" name="title" required>

              <label for="description">Description:</label>
              <textarea id="description" name="description" required></textarea>

              <label for="startDateTime">Start Date and Time:</label>
              <input type="datetime-local" id="startDateTime" name="startDateTime" required>

              <label for="endDateTime">End Date and Time:</label>
              <input type="datetime-local" id="endDateTime" name="endDateTime" required>

              <button class="red-btn" onclick="toggleTaskForm()">Abbrechen</button>
              <input class="input-btn" type="submit" value="Speichern">
          </form>
      </div>

      <script>
      function toggleTaskForm() {
          var taskForm = document.getElementById('taskForm');
          taskForm.style.display = (taskForm.style.display === 'none') ? 'flex' : 'none';
      }
      </script>

  </nav>