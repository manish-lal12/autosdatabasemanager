<?php
require_once "pdo.php";
$failure = false;
$success = false;

// Ensure the 'name' parameter is passed in the URL
if (!isset($_GET['name'])) {
    die("Name parameter missing");
}
// Handle logout
elseif (isset($_POST['logout']) && $_POST['logout'] == 'Logout') {
    header('Location: index.php');
    return; // Stop further execution after redirection
}
// Handle form submission for adding a new automobile
elseif (isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])) {
    if (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {
        $failure = 'Mileage and year must be numeric';
    } elseif (strlen($_POST['make']) < 1) {
        $failure = 'Make is required';
    } else {
        // Insert automobile data into the database
        $stmt = $pdo->prepare('INSERT INTO autos (make, year, mileage) VALUES (:make, :year, :mileage)');
        $stmt->execute(array(
            ':make' => $_POST['make'],
            ':year' => $_POST['year'],
            ':mileage' => $_POST['mileage']
        ));
        $success = 'Record inserted';
    }
}

// Retrieve all automobiles from the database
$stmt = $pdo->query("SELECT make, year, mileage FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
    <?php require_once "bootstrap.php"; ?>
    <title>Tracking Autos for <?php echo htmlentities($_GET['name']); ?></title>
</head>

<body>
    <div class="container">
        <h1>Tracking Autos for <?php echo htmlentities($_GET['name']); ?></h1>

        <?php
        // Display failure message if any
        if ($failure !== false) {
            echo('<p style="color: red;">' . htmlentities($failure) . "</p>\n");
        }

        // Display success message if any
        if ($success !== false) {
            echo('<p style="color: green;">' . htmlentities($success) . "</p>\n");
        }
        ?>

        <!-- Form to add new automobile -->
        <form method="post">
            <p>Make: <input type="text" name="make" size="60" class="form-control" /></p>
            <p>Year: <input type="text" name="year" class="form-control" /></p>
            <p>Mileage: <input type="text" name="mileage" class="form-control" /></p>
            <input type="submit" value="Add" class="btn btn-primary">
            <input type="submit" name="logout" value="Logout" class="btn btn-default">
        </form>

        <h2>Automobiles</h2>
        <ul>
            <?php
            // Loop through and display the list of autos
            foreach ($rows as $row) {
                echo '<li>';
                echo htmlentities($row['make']) . ' ' . $row['year'] . ' / ' . $row['mileage'];
                echo '</li>';
            }
            ?>
        </ul>
    </div>
</body>

</html>
