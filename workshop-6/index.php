<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <?php include 'db.php'; ?>
        <h2>Student List</h2>
        <a href="create.php" class="btn">Add New Student</a>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Course</th>
                <th>Actions</th>
            </tr>
            <?php
            $stmt = $pdo->query("SELECT * FROM students");
            while ($row = $stmt->fetch()) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['course']}</td>
                    <td class='actions'>
                        <a href='update.php?id={$row['id']}' class='edit-link'>Edit</a>
                        <a href='#' onclick='confirmDelete({$row['id']}); return false;' class='delete-link'>Delete</a>
                    </td>
                </tr>";
            }
            ?>
        </table>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h3>System Warning</h3>
            <p>Initiating deletion sequence. This action is irreversible.<br>
                <span style="color: #ff0055; font-weight: bold;">Auto-abort in: <span id="timerCount">5</span>
                    seconds</span>
            </p>
            <div class="modal-actions">
                <button onclick="closeModal()" class="btn-cancel">Abort</button>
                <a id="confirmDeleteBtn" href="#" class="btn-confirm">Confirm</a>
            </div>
        </div>
    </div>

    <!-- Blast Effect Container -->
    <div id="blastEffect" class="blast-overlay">
        <div class="shockwave"></div>
        <div class="flash"></div>
    </div>

    <script>
        // Check for deletion flag in URL
        window.onload = function () {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('deleted')) {
                triggerBlast();
                // Clean URL
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        };

        function triggerBlast() {
            const blast = document.getElementById('blastEffect');
            blast.style.display = 'flex';

            // Play sound effect (optional, browser policy might block auto-play)
            // const audio = new Audio('explosion.mp3'); 
            // audio.play().catch(e => console.log(e));

            setTimeout(() => {
                blast.style.opacity = '0';
                setTimeout(() => {
                    blast.style.display = 'none';
                    blast.style.opacity = '1';
                }, 1000);
            }, 1500);
        }

        let deleteTimer;

        function confirmDelete(id) {
            document.getElementById('deleteModal').style.display = 'flex';
            document.getElementById('confirmDeleteBtn').href = 'delete.php?id=' + id;

            let timeLeft = 5;
            const timerDisplay = document.getElementById('timerCount');
            timerDisplay.innerText = timeLeft;

            // Clear any existing timer to prevent overlaps
            if (deleteTimer) clearInterval(deleteTimer);

            deleteTimer = setInterval(() => {
                timeLeft--;
                timerDisplay.innerText = timeLeft;

                if (timeLeft <= 0) {
                    closeModal();
                }
            }, 1000);
        }

        function closeModal() {
            document.getElementById('deleteModal').style.display = 'none';
            if (deleteTimer) clearInterval(deleteTimer);
        }

        // Close modal when clicking outside
        window.onclick = function (event) {
            var modal = document.getElementById('deleteModal');
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</body>

</html>