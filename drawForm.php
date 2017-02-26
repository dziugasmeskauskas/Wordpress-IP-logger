<?php
function drawForm(){

  ?>
 
  <h3>Optional IPs</h3>
  <form  id="checkIPs" class="checkIPs" />
    <input type="radio" name="logIP" value="all" id="all" > Log all IPs<br>
    <input type="radio" name="logIP" value="slected" id="selected"> Log selected IPs<br>

  </form>
  <br>
  <form  id="addAddress" class="addAddress" />
    <input type="text" name="ROUTE"  placeholder="IP address" id="dname" />
    <input type="submit" value="Add" class="button-primary" >
  </form>

  <?php
}


?>