<?php
function drawLogged(){

  global $wpdb;
  $logged = $wpdb->prefix . "logged_ips";


  $loggedData = $wpdb->get_results(
    "
    SELECT ID, date, address, post_ID, page_name, page_url
    FROM $logged
    "
    );

  ?>
   <div class="wrap">


    <h3>Logged IPs</h3>
    <table class="widefat">
      <thead>
        <tr>
          <th>#</th>
          <th>IP adress</th>
          <th>Date</th>
          <th>Post ID</th>
          <th>Post Name</th>
          <th>Post Link</th>
        </tr>
      </thead>
        <tfoot>
        <tr>
          <th>#</th>
          <th>IP adress</th>
          <th>Date</th>
          <th>Post ID</th>
          <th>Post Name</th>
          <th>Post Link</th>
        </tr>
        </tfoot>
        <tbody>
        <?php
          foreach ($loggedData as $loggedData) {
        ?>
          <tr>
        <?php
          echo "<td>".$loggedData->ID."</td>";
          echo"<td>".$loggedData->address."</td>";
          echo"<td>".$loggedData->date."</td>";
          echo "<td>".$loggedData->post_ID."</td>";
          echo "<td>".$loggedData->page_name."</td>";
          echo "<td> <a href='".$loggedData->page_url."'>Link</a></td>";
        ?>
          <tr>
        <?php
          }
        ?>
        </tbody>
      </table>
  </div>
  <?php
}
?>