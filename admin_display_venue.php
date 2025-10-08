<?php
session_start();
include 'db_connect.php';

$sql = "SELECT venues.id, venues.name, venues.images, venue_types.id as type_id, venue_types.type, venues.venue_description
        FROM venues 
        JOIN venue_types ON venues.type_id = venue_types.id";

if (isset($_GET['category']) && !empty($_GET['category'])) {
    $category_id = $_GET['category'];
    $sql .= " WHERE venues.type_id = $category_id";
}

$sql_profile = "SELECT a_image FROM admins WHERE admin_id = ?";
$stmt_profile = $conn->prepare($sql_profile);
$stmt_profile->bind_param("s", $_SESSION['admin_id']);
$stmt_profile->execute();
$stmt_profile->bind_result($a_image);
$stmt_profile->fetch();
$stmt_profile->close();

// Set default image if u_image is empty
$default_image = 'images/profile.png';
$image_to_display = !empty($a_image) ? htmlspecialchars($a_image) : $default_image;

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>University Venue Management System</title>
  <link rel="stylesheet" href="admin_display_venue.css">
  <link rel="stylesheet" href="navi_bar_white.css">
  <style>
 .container{
    padding: 50px 20px;
    position: relative;
    font-family: 'Montserrat', Arial, sans-serif;
  }
  </style>
</head>
<body>
<div class="container">
    <div class="profile-icon" onclick="window.location.href='admin_profile.php'">
        <img src="<?php echo htmlspecialchars($image_to_display); ?>" alt="Profile Image">
    </div>
    <nav class="mynav">
      <ul>
        <li><a href="admin_mainmenu.php">Main Menu</a></li>
        <li><a href="logout.php">Log Out</a></li>
      </ul>
    </nav>
    <span class="target"></span>
    
    <div class="category-dropdown">
      <button class="dropbtn">SELECT CATEGORY</button>
      <div class="category-dropdown-content">
        <form action="admin_display_venue.php" method="GET">
          <button type="submit" name="category" value="">ALL CATEGORY</button>
          <?php
          $sql_categories = "SELECT * FROM venue_types";
          $result_categories = $conn->query($sql_categories);
          while ($row_category = $result_categories->fetch_assoc()) {
            echo '<button type="submit" name="category" value="' . $row_category['id'] . '">' . $row_category['type'] . '</button>';
          }
          ?>
        </form>
      </div>
    </div>

    <div class="container flip-card-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="flip-card" style="--hue: 220">
                        <div class="flip-card-inner">
                            <div class="card-front">
                                <figure>
                                    <img style=" width: 100%; height: 200px; object-fit: cover;" src="images/' . $row['images'] . '" alt="' . $row['name'] . '">
                                    <figcaption>' . $row['type'] . '</figcaption>
                                </figure>
                                <ul>
                                    <li>' . $row['name'] . '</li>
                                </ul>
                            </div>
                            <div class="card-back">
                                <figure>
                                    <img style=" width: 100%; height: 200px; object-fit: cover;" src=" images/' . $row['images'] . '" alt="' . $row['name'] . '">
                                </figure>
                                <p>'.$row['venue_description'].'</p>
                                <a href="admin_delete_venue.php?id=' . $row['id'] . '&name=' . urlencode($row['name']) . '&images=' . urlencode($row['images']) . '&type=' . urlencode($row['type']) . '"><button>Delete Venue</button></a>
                                <a href="#modal-opened" onclick="openEditModal(\'' . $row['id'] . '\', \'' . addslashes($row['name']) . '\', \'' . $row['type_id'] . '\', \'' . addslashes($row['venue_description']) . '\')"><button>Edit Venue</button></a>
                                <div class="design-container">
                                </div>
                            </div>
                        </div>
                    </div>';
            }
        } else {
            echo "No venues available.";
        }
        ?>
        
        <!-- Add New Venue Card -->
        <div class="flip-card" style="--hue: 220; " onclick="openForm()">
          <div class="flip-card-inner">
              <div class="card-front">
                  <figure>
                      <div class="img-bg"></div>
                      <img src="images/Addvenueicon2.png" alt="Add New Venue" style="display: block; margin: auto; max-width: 100%; max-height: 100%;">
                      <figcaption>Add New Venue</figcaption>
                  </figure>
              </div>
              <div class="card-back">
                  <figure>
                      <div class="img-bg"></div>
                      <img src="images/Addvenueicon2.png" alt="Add New Venue" style="display: block; margin: auto; max-width: 100%; max-height: 100%;">
                      </figure>
                      <button class="link-1" onclick="window.location.href='admin_add_venue.php';">Click to add</button>
                    <div class="design-container"></div>
              </div>
          </div>
      </div>
      <!--The popup edit form-->
      <div class="modal-container" id="modal-opened">
    <div class="modal">
        <div class="main">
            <a href="admin_display_venue.php" class="close-button">X</a>
            <form id="edit-venue-form" action="admin_update_venue.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="edit-venue-id" name="venue_id">
                <div>
                    <label for="edit-name" class="text-small-uppercase">Venue Name</label>
                    <input class="text-body" id="edit-name" name="name" type="text" required>
                </div>
                <div class="select-container">
                    <label for="edit-type_id" class="text-small-uppercase">Venue Type</label>
                    <select id="edit-type_id" name="type_id" required>
                        <?php
                        $result_categories->data_seek(0); // Reset pointer
                        while ($row_category = $result_categories->fetch_assoc()) {
                            $selected = ($row_category['id'] == $type_id) ? 'selected' : '';
                            echo '<option value="' . $row_category['id'] . '" ' . $selected . '>' . $row_category['type'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="edit-venue_description" class="text-small-uppercase">Venue Description</label>
                    <input class="text-body" id="edit-venue_description" name="venue_description" type="text" required>
                </div>
                <div>
                    <input style="font-weight:bold;"class="text-small-uppercase" id="submit-edit" type="submit" value="Save Changes">
                </div>
            </form>
        </div>
    </div>
</div>


<script src="navi_bar.js"></script>
<script>
  // Function to open edit modal with pre-filled data
  function openEditModal(id, name, type_id, description) {
    document.getElementById('edit-venue-id').value = id;
    document.getElementById('edit-name').value = name;
    document.getElementById('edit-type_id').value = type_id;
    document.getElementById('edit-venue_description').value = description;
    document.getElementById('modal-opened').style.display = 'block';
  }

  // Close modal when clicking outside of it
  window.onclick = function(event) {
    var modal = document.getElementById('modal-opened');
    if (event.target == modal) {
        modal.style.display = "none";
    }
  }
</script>
</body>
</html>
