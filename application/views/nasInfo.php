<div class="span10">
<!-- 볼륨정보 -->
	<div class="container-fluid">
		<div class="row-fluid">
			<span></span>
			<div id='nasdiv'>
				<div class="span12" id='nasvolumeactiondiv'>
					<h5>
						선택된 볼륨: <span id="selectnasvolume"></span>
						<span id="selectnasvolumeid" style="display:none"></span> 
					</h5>
					<br>
					<table id="nasvolumeaction_table" class="table table-condensed" >
					 	<tr>
					 		<th class="subtitle">기능</th>
					 		<th>
					 			<input class = 'btn' id='snapshotbtn' type='button' value='스냅샷' disabled='disabled' />
					 			<input class = 'btn btn-danger' id='deletenasvolumebtn' type='button' value='삭제'/>
					 		</th> 
					 	</tr> 
					</table>
				</div>
				
				
				<div class="span12" id='nasvolumeinfodiv'>
					
					<br>
					<table id="nasvolumeinfo_table" class="table table-condensed" >
						<tr>
					 		<th class="subtitle">id</th>
					 		<th id='nasId' colspan="3"></th>
					 	</tr>
					 	<tr>
					 		<th class="subtitle">볼륨명</th>
					 		<th id='name'></th>
					 		<th class="subtitle">프로토콜</th>
					 		<th id="volumetype"></th>
					 	</tr>
					 	<tr>
					 		<th class="subtitle">신청용량(GB)</th>
					 		<th id='totalsize'></th>
					 		<th class="subtitle">생성일시</th>
					 		<th id='created'></th>
					 	</tr>
					 	<tr>
					 		<th class="subtitle" >요금제</th>
					 		<th id='usageplantype' colspan="3" ><th> 
					 		<span id='zoneid' style='display:none' >nasvolumeinfo_table zoneid</span>
					 	</tr> 
					 	<tr>
					 		<th class="subtitle">현재파일 수</th>
					 		<th id='filesused'></th>
					 		<th class="subtitle">최대파일 수</th>
					 		<th id='filestotal'></th>
					 	</tr>
					 	<tr>
					 		<th class="subtitle">Mount path</th>
					 		<th colspan="3" id='ipslashpath'></th> 
					 	</tr>
					 	 
					</table>
				</div>
			</div>
				
				<div class="span12" id='connectservermanagediv'>
						<div  id='volumeactiondiv'> 
							<table id="volumeaction_table" class="table table-condensed" >
							 	<tr>
							 		<th class="subtitle">기능</th>
							 		<th>
							 			<input class = 'btn' id='connectcipbtn' type='button' value='CIP 연결' data-toggle='modal' data-taget='#connectCIPModal'/>
							 			<input class = 'btn' id='disconnectcipbtn' type='button' value='CIP 연결 해지' data-toggle='modal' data-taget='#disconnectCIPModal'/>
							 		</th> 
							 	</tr> 
							</table>
						</div>
					<br>
					<table id="connectserverinfo_table" class="table table-condensed" >
						<thead>
							<tr>
						 		<th class="subtitle">NAS사용여부</th>
						 		<th class="subtitle">zone</th>
						 		<th class="subtitle">서버명</th>
						 		<th class="subtitle">운영체제</th>
						 		<th class="subtitle">스펙(CPU,RAM)</th>
						 		<th class="subtitle">상태</th>
						 	</tr>
					 	</thead>
					 	<tbody>
					 	</tbody> 
					</table>
				</div>
				
				<div class="span12" id='cifsaccountmanagediv'>
					<br>
					<button class='btn pull-right' id='addcifsaccountbtn'>CIFS 계정 추가</button>
					<br>
					<h5>작업그룹</h5> 
					<input type='text' class="input-medium search-query"  id="cifsworkgroupname"> 
					<button class='btn' id='cifsworkgroupbtn'>변경</button> 
					 
					<br><br>
					<div class="row">
						<div class="span12">
						<table id="cifsaccountlist_table" class="table table-condensed" >
							<thead>
								<tr>
							 		<th id="cifsid"  class="subtitle">CIFS ID</th>
							 		<th class="subtitle">기능</th> 
							 	</tr>
						 	</thead>
						 	<tbody>
						 	</tbody> 
						</table> 
						</div>
					</div>
				</div>
			</div>
		</div>
 </div>