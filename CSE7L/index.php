<?php
require_once('Controller.php');

$taskManager = new TaskManager();

// Handle user-related actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addUser'])) {
        $userName = $_POST['userName'];
        $taskManager->addUser($userName);
    } elseif (isset($_POST['updateUser'])) {
        $userId = $_POST['userId'];
        $userName = $_POST['userName'];
        $taskManager->updateUser($userId, $userName);
    } elseif (isset($_POST['deleteUser'])) {
        $userId = $_POST['userId'];
        $taskManager->deleteUser($userId);
    }

    // Handle task-related actions
    elseif (isset($_POST['addTask'])) {
        $taskName = $_POST['taskName'];
        $userId = $_POST['taskUser'];
        $taskManager->addTaskWithUser($taskName, $userId);
    } elseif (isset($_POST['updateTask'])) {
        $taskId = $_POST['taskId'];
        $taskName = $_POST['taskName'];
        $userId = $_POST['taskUser'];
        $taskManager->updateTask($taskId, $taskName, $userId);
    } elseif (isset($_POST['deleteTask'])) {
        $taskId = $_POST['taskId'];
        $taskManager->deleteTask($taskId);
    }
}

$tasks = $taskManager->getTasks();
$users = $taskManager->getUsers();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">

        <!-- Add User Form -->
        <form method="post" class="mt-5">
            <label for="userName" class="form-label">New User</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="userName" name="userName" placeholder="User" aria-label="User" aria-describedby="button-addon2">
                <button type="submit" class="btn btn-primary" name="addUser" id="button-addon2">Add User</button>
            </div>
        </form>

        <!-- Users List -->
        <h3>Users</h3>
        <ul class="list-group">
            <?php foreach ($users as $user) : ?>
                <li class="list-group-item">
                    <form method="post">
                        <input type="hidden" name="userId" value="<?php echo $user['userId']; ?>">
                        <input type="text" name="userName" value="<?php echo $user['name']; ?>">
                        <button type="submit" class="btn btn-primary" name="updateUser">Update</button>
                        <button type="submit" class="btn btn-danger" name="deleteUser">Delete</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>

        <!-- Tasks Form -->
        <form method="post" class="mt-5">
            <label for="taskName" class="form-label">New Task</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="taskName" name="taskName" placeholder="Task" aria-label="Task" aria-describedby="button-addon2">
                <select name="taskUser">
                    <?php foreach ($users as $user) : ?>
                        <option value="<?php echo $user['userId']; ?>"><?php echo $user['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-primary" name="addTask" id="button-addon2">Add Task</button>
            </div>
        </form>

        <!-- Tasks List -->
        <h3>Tasks</h3>
        <ul class="list-group">
            <?php foreach ($tasks as $task) : ?>
                <li class="list-group-item">
                    <form method="post">
                        <input type="hidden" name="taskId" value="<?php echo $task['taskId']; ?>">
                        <input type="text" name="taskName" value="<?php echo $task['taskName']; ?>">
                        <select name="taskUser">
                            <?php foreach ($users as $user) : ?>
                                <option value="<?php echo $user['userId']; ?>" <?php echo ($user['userId'] == $task['userId']) ? 'selected' : ''; ?>><?php echo $user['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn-primary" name="updateTask">Update</button>
                        <button type="submit" class="btn btn-danger" name="deleteTask">Delete</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>