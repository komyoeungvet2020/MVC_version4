<div class="container">
  <div class="row">

    <?php
    foreach ($data['student'] as $row) {
      ?>
      <div class="col-md-4"></div>
      <div class="col-md-4">
        <div class="hovereffect">
          <img class="img-responsive" src="Views/img/<?php echo $row['profile']; ?>" class="rounded-circle mb-5" width="200" height="250" alt="Profile">
          <div class="overlay">
            <h2>
              <a href="index.php?action=update_profile&id=<?php echo $row['id']; ?>" class="btn btn-primary">Change Profile</a>
            </h2>
          </div>
        </div>
      </div>
      <div class="col-md-4"></div>
      <table class="table table-border">
        <tr>
          <th class="header-table">ID</th>
          <td class="content"><?php echo $row['id']; ?></td>
        </tr>
        <tr>
          <th class="header-table">Fullname</th>
          <td class="content"><?php echo $row['name']; ?></td>
        </tr>
        <tr>
          <th class="header-table">Class</th>
          <td class="content"><?php echo $row['class']; ?></td>
        </tr>
        <tr>
          <th class="header-table">Score</th>
          <td class="content"><?php echo $row['mark']; ?></td>
        </tr>
        <tr>
          <th class="header-table">Gender</th>
          <td class="content"><?php echo $row['sex']; ?></td>
        </tr>
      <?php
      }
      ?>
      </table>
      <a class="btn btn-success pull-left mb-5" href="index.php?action=view">Back</a><br>
  </div>
</div>