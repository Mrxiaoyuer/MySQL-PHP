<?php
  require('header.php');        // 导航栏
?>


<br>
<h1 class="text-center"> Patient's Information List</h1>
<br>
<div id="container">
	<br>
	<div class="col-md-offset-1 col-md-3 panel panel-info">
		<div class="panel-body">
	    <?php

			$con = new mysqli("57306aae8f8cf.bj.cdb.myqcloud.com:5651", "cdb_outerroot", "jiangli77", "HearthStone");
			if(mysqli_connect_errno()){
					echo mysqli_connect_error();
			}

	    $ans = $con->query("select * from Patient where Pat_ID=".$_GET['id']."");

	    while ($now = $ans->fetch_assoc()){
	        echo "Pat_ID : " . $now["Pat_ID"] . "<br>". "<br>";
			    echo "Pat_name : " . $now["Pat_name"] . "<br>". "<br>";
			    echo "Sex : " . $now["Sex"] . "<br>". "<br>";
			    echo "Bed_No : " . $now["Bed_No"] . "<br>". "<br>";
			    echo "Primary_doc : " . $now["Primary_doc"] . "<br>". "<br>";
			    $bns = $con->query("select content from Prescription where Pat_ID= $now[Primary_doc] and Doc_ID=$now[Pat_ID]")->fetch_object();
          if($bns) $bns=$bns->content;
			    //echo "Prescription: " . $bns . "<br>" . "<br>";
			    //echo "<a href='patient.php?id=$now[Pat_ID]' class='btn btn-info'>RePrescrip</a>" . "&nbsp";
    			//echo "<a href='addsurgery.php?id=$now[Pat_ID]' class='btn btn-info'>ArrangeOper</a>";
    			$bns = $con->query("select content from Prescription where Pat_ID= $now[Pat_ID] ")->fetch_object();
    			if($bns) {
             $bns=$bns->content;
    					echo "Prescription: " . $bns . "<br>" . "<br>";
    			}
					else{
						echo "Prescription: " . "None" . "<br>" . "<br>";
					}
					echo "<a href='Prescription.php?id=$now[Pat_ID]' class='btn btn-info'>RePrescrip</a>" . "&nbsp";
					echo "<a href='addsurgery.php?id=$now[Pat_ID]' class='btn btn-info'>ArrangeOper</a>" . "<br>" . "<br>";
          if($now["Assigned"] == -1)
    				echo "<a href = '_SendAssignRoomReq.php?id=$now[Pat_ID]' class='btn btn-info'> Assign Room</a>";
    			elseif($now["Assigned"] != 0 && $now["Assigned"] != -1)
    			{
    				echo "<a href = '_SendRecycleRoomReq.php?id=$now[Pat_ID]' class='btn btn-info'>Recycle Room</a>";
    			}
    	  }
	    ?>
		</div>
	</div>
	<div class="col-md-offset-1 col-md-6 panel panel-info">
		<div class="panel-heading text-center"><h4>Opeartion List</h4></div>
		<div class="panel-body">
			<table class="table table-hover">
				<tr>
					<th>ID</th>
					<th>OpTime</th>
					<th>Doc_ID</th>
					<th>OpRoom_ID</th>
					<th>Operation</th>
				</tr>
				<tbody>
					<?php
						$cns = $con->query("select * from Surgery where Patient_ID=".$_GET['id']."");
						while ($now = $cns->fetch_assoc()){
								echo "<tr>";
								echo "<td>" . $now["id"] . "</td>";
								echo "<td>" . $now["OpTime"] . "</td>";
								echo "<td>" . $now["Doctor_ID"] . "</td>";
								echo "<td>" . $now["OpRoom_ID"] . "</td>";
								echo "<td>" .  "<a href='cancelSurgery.php?id=$now[id]' class='btn btn-info'>Cancel</a>" . "</td>";
								echo "</tr>";
						}
					 ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="col-md-offset-1 col-md-6 panel panel-info">
		<div class="panel-heading text-center"><h4>Rountine Bills</h4></div>
		<div class="panel-body">
			<table class="table table-hover">
				<tr>
					<th>bills_ID</th>
					<th>Pat_ID</th>
					<th>Amount</th>
					<th>Card_Balance</th>
					<th>Date</th>
					<th>Operation</th>
				</tr>
				<tbody>
					<?php
						$cns = $con->query("select * from Bills where Pat_ID=".$_GET['id']."");
						while ($now = $cns->fetch_assoc()){
								echo "<tr>";
								echo "<td>" . $now["id"] . "</td>";
								echo "<td>" . $now["Pat_ID"] . "</td>";
								echo "<td>" . $now["Amount"] . "</td>";
								echo "<td>" . $now["Card_Balance"] . "</td>";
								echo "<td>" . $now["Date"] . "</td>";
								echo "<td>" .  "<a href='Reimburse.php?id=$now[id]' class='btn btn-info'>Reimburse</a>" . "</td>";
								echo "</tr>";
						}
					 ?>
				</tbody>
			</table>
		</div>
	</div>


<?php
  require('footer.php');        // 底部
?>
