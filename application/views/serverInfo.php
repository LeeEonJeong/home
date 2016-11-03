<div class="span10">
	<!-- 서버정보 -->
	<div class="container-fluid">
		<div class="row-fluid">
			<span></span>
			<div class="span12" id='serveractiondiv'>
					<h5>
						<span id="selectvolumeid" style="display:none"></span>
						<span id="isAdditional" style="display:none"></span>
					</h5>
					<br>
					<table id="volumeaction_table" class="table table-condensed" >
					 	<tr>
					 		<th class="subtitle">추가기능</th>
					 		<th>
					 			<input class = 'btn' id='osinitializebtn' type='button' value='OS초기화'/>
					 			<input class = 'btn' id='resetpwdbtn' type='button' value='비밀번호초기화'/>
					 			<input class = 'btn btn-danger' id='deletevmbtn' type='button' value='삭제'/>
					 		</th> 
					 	</tr> 
					</table>
			</div>
				
			<div class="span12" id='serverinfodiv'> 
				<br>
				<table id="serverinfo_table" class="table table-condensed" >
				 	<tr>
				 		<th class="subtitle">인스턴스명</th>
				 		<th id='displayname'></th>
				 		<th class="subtitle">호스트명</th>
				 		<th id='hostname'></th>
				 	</tr>
				 	<tr>
				 		<th class="subtitle">서버 ID</th>
				 		<th colspan="3" id='vmid'></th>
				 	</tr>
				 	
				 	<tr>
				 		<th class="subtitle">내부주소</th>
				 		<th  id="inneraddr"></th> 
				 		<th class="subtitle">외부주소</th>
				 		<th  id="outeraddr"></th> 
				 	</tr>
				 	
				 	<tr>
				 		<th class="subtitle">운영체제</th>
				 		<th id='templatename'></th>
				 		<th class="subtitle">데이터센터</th>
				 		<th id='zonename'></th>
				 	</tr>
				 	
				 	<tr>
				 		<th class="subtitle">CPU/메모리</th>
				 		<th id='serviceofferingname'></th>
				 		<th class="subtitle">생성시간</th>
				 		<th id='created'></th>
				 	</tr>
				 	<tr>
				 		<th class="subtitle">상태</th>
				 		<th colspan="3" id='state'></th>
				 	</tr>
				 					 	 
				</table>
			</div>
			
			
			<div class="span12" id='servervolumeinfodiv'>
				<br>
				<table id="servervolumeinfo_table" class="table table-condensed" >
					<thead>
						<tr>
							<th class="subtitle"></th>
							<th class="subtitle">이름</th>
							<th class="subtitle">타입</th>
							<th class="subtitle">용량</th>
							<th class="subtitle">생성일시</th> 
						</tr>
					</thead>
				 	<tbody>
				 	</tbody>
				</table>
			</div>
	</div>