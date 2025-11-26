<?php
session_start();
require_once 'config/database.php';

// Check if user is logged in
if(!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle post creation
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_post'])) {
    $title = mysqli_real_escape_string($conn, trim($_POST['title']));
    $content = mysqli_real_escape_string($conn, trim($_POST['content']));
    
    if(!empty($title) && !empty($content)) {
        $insert_query = "INSERT INTO posts (user_id, title, content) VALUES ($user_id, '$title', '$content')";
        
        if(mysqli_query($conn, $insert_query)) {
            $_SESSION['success'] = "Post created successfully!";
            header("Location: dashboard.php");
            exit();
        }
    }
}

// Handle post update
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_post'])) {
    $post_id = mysqli_real_escape_string($conn, $_POST['post_id']);
    $title = mysqli_real_escape_string($conn, trim($_POST['title']));
    $content = mysqli_real_escape_string($conn, trim($_POST['content']));
    
    $update_query = "UPDATE posts SET title = '$title', content = '$content' WHERE id = $post_id AND user_id = $user_id";
    
    if(mysqli_query($conn, $update_query)) {
        $_SESSION['success'] = "Post updated successfully!";
        header("Location: dashboard.php");
        exit();
    }
}

// Handle post deletion
if(isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $post_id = $_GET['delete'];
    $delete_query = "DELETE FROM posts WHERE id = $post_id AND user_id = $user_id";
    mysqli_query($conn, $delete_query);
    $_SESSION['success'] = "Post deleted successfully!";
    header("Location: dashboard.php");
    exit();
}

// Fetch user posts
$query = "SELECT * FROM posts WHERE user_id = $user_id ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
$posts = array();

while($row = mysqli_fetch_assoc($result)) {
    $posts[] = $row;
}

// Get post for editing if edit parameter exists
$edit_post = null;
if(isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $edit_query = "SELECT * FROM posts WHERE id = $edit_id AND user_id = $user_id";
    $edit_result = mysqli_query($conn, $edit_query);
    
    if(mysqli_num_rows($edit_result) == 1) {
        $edit_post = mysqli_fetch_assoc($edit_result);
    }
}

$page_title = "Dashboard - InstaSocial";
include 'includes/header.php';
?>

<nav class="navbar">
    <div class="nav-container">
        <h1>InstaSocial</h1>
        <div class="nav-right">
            <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
            <a href="logout.php" class="btn-logout">Logout</a>
        </div>
    </div>
</nav>

<div class="dashboard-container">
    <?php
    if(isset($_SESSION['success'])) {
        echo '<div class="success-message">' . $_SESSION['success'] . '</div>';
        unset($_SESSION['success']);
    }
    ?>
    
    <div class="create-post-section">
        <h2><?php echo $edit_post ? 'Edit Post' : 'Create New Post'; ?></h2>
        <form method="POST" class="post-form">
            <?php if($edit_post): ?>
                <input type="hidden" name="post_id" value="<?php echo $edit_post['id']; ?>">
            <?php endif; ?>
            
            <input type="text" name="title" placeholder="Post Title" 
                   value="<?php echo $edit_post ? htmlspecialchars($edit_post['title']) : ''; ?>" required>
            
            <textarea name="content" placeholder="What's on your mind?" rows="4" required><?php echo $edit_post ? htmlspecialchars($edit_post['content']) : ''; ?></textarea>
            
            <div class="form-buttons">
                <button type="submit" name="<?php echo $edit_post ? 'update_post' : 'create_post'; ?>" class="btn-primary">
                    <?php echo $edit_post ? 'Update Post' : 'Share Post'; ?>
                </button>
                <?php if($edit_post): ?>
                    <a href="dashboard.php" class="btn-cancel">Cancel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>
    
    <div class="posts-section">
        <h2>Your Posts</h2>
        <?php if(count($posts) > 0): ?>
            <?php foreach($posts as $post): ?>
                <div class="post-card">
                    <div class="post-header">
                        <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                        <span class="post-date"><?php echo date('M d, Y', strtotime($post['created_at'])); ?></span>
                    </div>
                    <div class="post-content">
                        <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                    </div>
                    <div class="post-actions">
                        <a href="?edit=<?php echo $post['id']; ?>" class="btn-edit">Edit</a>
                        <a href="?delete=<?php echo $post['id']; ?>" onclick="return confirm('Are you sure you want to delete this post?')" class="btn-delete">Delete</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-posts">No posts yet. Create your first post!</p>
        <?php endif; ?>
    </div>
</div>

<?php 
// Close connection
mysqli_close($conn);
include 'includes/footer.php'; 
?>