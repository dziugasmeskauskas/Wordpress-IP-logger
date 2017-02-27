<?php
function drawForm(){
  ?> 
  <h3>Optional IPs</h3><div id="logThis">Currently logging <?php echo get_option('Which_ip_to_logg');?> IP's</div>

  <form  id="checkIPs" class="checkIPs" />
    <input type="radio" name="logIP" value="all" id="all" > Log all IP's<br>
    <input type="radio" name="logIP" value="selected" id="selected"> Log selected IP's<br>
  </form>
  <br>
  <form  id="addAddress" class="addAddress" />
    <input type="text" name="ROUTE"  placeholder="IP address" id="dname" />
    <input type="submit" value="Add" class="button-primary" >
  </form>
  <?php
}
?>