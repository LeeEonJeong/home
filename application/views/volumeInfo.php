<div class="span10">
<!-- 볼륨정보 -->
	<div class="container-fluid">
		<div class="row-fluid">
			<span></span>
				<div class="span12" id='volumeactiondiv'>
					<h5>
						선택된 볼륨: <span id="selectvolume"></span>
						<span id="selectvolumeid" style="display:none"></span>
						<span id="isAdditional" style="display:none"></span>
					</h5>
					<br>
					<table id="volumeaction_table" class="table table-condensed" >
					 	<tr>
					 		<th class="subtitle">추가기능</th>
					 		<th>
					 			<input class = 'btn' id='connectserverbtn' type='button' value='서버연결'/>
					 			<input class = 'btn' id='detachserverbtn' type='button' value='서버연결해제'/>
					 			<input class = 'btn btn-danger' id='deletevolumebtn' type='button' value='삭제'/>
					 		</th> 
					 	</tr> 
					</table>
				</div>
				
				<div class="span12" id='volumeinfodiv'>
					
					<br>
					<table id="volumeinfo_table" class="table table-condensed" >
					 	<tr>
					 		<th class="subtitle">Disk이름</th>
					 		<th id='name'></th>
					 		<th class="subtitle">Disk id</th>
					 		<th id="volumeid"></th>
					 	</tr>
					 	<tr>
					 		<th class="subtitle">용량</th>
					 		<th id='disksize'></th>
					 		<th class="subtitle">생성일시</th>
					 		<th id='created'></th>
					 	</tr>
					 	
					 	<tr>
					 		<th class="subtitle">상태</th>
					 		<th id='state'><th> 
					 		<span id='zoneid' style='display:none' >volumeinfo_table zoneid</span>
					 	</tr> 
					 	<tr>
					 		<th class="subtitle">적용서버</th>
					 		<th colspan="3" id='vmdisplayname'></th> 
					 	</tr>
					</table>
				</div>
			</div>