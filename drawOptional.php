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
        <th>IP adress</t>
      </tr>
    </thead>
      <tfoot>
      <tr>
        <th>#</th>
        <th>IP adress</th>
      </tr>
      </tfoot>
      <tbody>
      <?php
        foreach ($optionalData as $optionalData) {
      ?>
        <tr>
      <?php
        echo "<td>".$optionalData->ID."</td>";
        echo"<td>".$optionalData->address."</td>";
      ?>
        <tr>
      <?php
        }
      ?>
      </tbody>
    </table>

   
  <?php
}
?>