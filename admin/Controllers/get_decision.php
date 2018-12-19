<?php
	include("../akses.php");
	include("../../db_login.php");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	$curStep = $_GET['step'];

	//do the db query here
	echo '
	<div class="clearfix">
		<div class="pull-right tableTools-container"></div>
	</div>
	<div class="table-header">
		View Tabel Workflow
	</div>
	<div class="box-body table-responsive">
		<table id="dynamic-table_detail" class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th>NO</th>
					<th>DECISION ID</th>
					<th>DECISION DESC</th>
					<th>NEXT STEP</th>
					<th>NEXT STEP NAME</th>
					<th class="nosort"><center>ACTION</th>
				</tr>
			</thead>			
			<tbody>';
				$no = 1;
				$query = pg_query($conn, "SELECT decision_id, decision_description, next_step, next_step_desc FROM public.tbl_r_general_workflow where current_step = $curStep order by decision_id; ");
				while ($result = pg_fetch_array($query)){ echo'
				<tr>
					<td><center><span class="badge badge-info">'.$no.'</span></td>
					<td>'.$result['decision_id'].'</td>
					<td>'.$result['decision_description'].'</td>
					<td>'.$result['next_step'].'</td>
					<td>'.$result['next_step_desc'].'</td>
					<td>
						<center><button id="selectDecision" class="btn btn-success btn-minier" onclick="selectDecision()"><i class="fa fa-check "></i></button>
					</td>
				</tr>';
				$no++;
				}echo'
			</tbody>
		</table>
	</div>';
	
	
?>
	