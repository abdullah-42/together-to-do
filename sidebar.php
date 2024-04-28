<div class="sidebar">
    <h3>WEB Projektgruppe:</h3>
    <div class="user-list">
        <?php
            include("config.php");

            // Fetch and display user data
            $userid = $_SESSION["user_id"];
            $usercolor = $_SESSION["color"];

            echo "<li class='user-list-item'>";
            echo "<div class='user-info'>";
            echo "<strong style='color:{$usercolor};'>{$_SESSION['username']}</strong>";
            echo "<span style='color:{$usercolor};' class='user-position'>{$_SESSION['position']}</span>";
            echo "<span class='user-email'>{$_SESSION['email']}</span>";
            echo "<div class='add-btn-container'><button class='add-btn' onclick='toggleTaskForm()'>+</button></div>";
            echo "</div>";
            echo "</li>";

            $sql = "SELECT * FROM registrations";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if ($row['id'] != $userid) {
                        $userColor = isset($row['color']) ? $row['color'] : "default_color"; 
                        
                        echo "<li class='user-list-item'>";
                        echo "<div class='user-info'>";
                        echo "<strong style='color:{$userColor};'>{$row['name']}</strong>";
                        echo "<span style='color:{$userColor};' class='user-position'>{$row['position']}</span>";
                        echo "<span class='user-email'>{$row['email']}</span>";
                        echo "</div>";
                        echo "</li>";
                    }
                }
            } else {
                echo "Du hast noch keine Projektmitglieder";
            }

            // Close the database connection
            $conn->close();
        ?>
    </div>

</div>

<script>
function toggleTaskForm() {
    var taskForm = document.getElementById('taskForm');
    taskForm.style.display = (taskForm.style.display === 'none') ? 'flex' : 'none';
}
</script>