<?php
function drawOptional(){

    global $wpdb;
    $optional = $wpdb->prefix . "optional_ips";

    $optionalData = $wpdb->get_results(
    "
    SELECT ID, address
    FROM $optional
    "
    );

  ?>
   <table class="widefat" id="optional">
    <thead>
      <tr>
        <th>#</th>
        <th>IP adress</th>
        <th>Delete</th>
      </tr>
    </thead>
      <tfoot>
      <tr>
        <th>#</th>
        <th>IP adress</th>
        <th>Delete</th>
      </tr>
      </tfoot>
      <tbody>
      <?php
      $numeric = 0;
        foreach ($optionalData as $optionalData) {
          $numeric++;
      ?>
        <tr <?php echo "data-id=".$optionalData->ID.""?> >
      <?php
        echo"<td>".$numeric."</td>";
        echo"<td>".$optionalData->address."</td>";
        echo"<td><button class='button-secondary deleteRow' type='button'>Delete</button></td>";
      ?>
        </tr>
      <?php
        }
      ?>
      </tbody>
    </table>
  <?php
}
?>