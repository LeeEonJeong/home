 
<div class="span10">
	<!-- 네트워크정보 -->
	<div class="container-fluid">
		<div class="row-fluid">
		<span></span>
		<div class="span12" id='networkinfodiv'>
			<h5>선택된 네트워크 : <span id="selectipaddress"></span></h5>
			
			<span  id="selectipaddressid" style="display: none"></span>
			<span  id="zoneid" style="display: none"></span>
			
<!--        ////////////////////////////////////////       -->
				<div id="publicipinfo">
					<table id="networkaction_table" class="table table-condensed" >
					 	<tr>
					 		<th class="subtitle">추가기능</th>
					 		<th>
					 			<input class = 'btn' id='staticnat' type='button' value='StaticNat'/>
					 			<input class = 'btn' id='ipaddrdesc' type='button' value='설명입력'/>
					 			<input class = 'btn btn-danger' id='deleteip' type='button' value='삭제'/>
					 		</th> 
					 	</tr> 
					</table>
					<br>
					<table class="table table-condensed" id="publicipinfo_table">
					 	<tr>
					 		<th class="subtitle">공인IP</th>
					 		<th id="ipaddress"></th>
					 		<th class="subtitle">IP ID</th>
					 		<th id="id"></th>
					 	</tr>
					 	<tr>
					 		<th class="subtitle">취득 날짜</th>
					 		<th id="allocated"></th>
					 		<th class="subtitle">주소 상태</th>
					 		<th id="state"></th>
					 	</tr>
					 	<tr>
					 		<th class="subtitle">설명</th>
					 		<th id="desc"></th>
					 		<th class="subtitle">기본IP</th>
					 		<th id="issourcenat"></th>
					 	</tr>					 
					</table>
				</div>
<!--        ////////////////////////////////////////       -->				
				<div id="firewallinfo"> 
					<h5>방화벽 추가</h5>
					<form id="createportfirewallform">
						<div class="nav pull-right" >
							<div id = "createfirewallbtn" class="btn">추가하기</div>
						</div>
						<br>
							<table style="width:100%">
								<thead>
									<tr>
										<th>Source CIDR</th>
										<th>프로토콜</th>
										<th>Start Port</th>
										<th>End Port</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th><input type="text" id="cidrlist" name='cidrlist' value="0.0.0.0/0"/></th>
										<th>
											<select id="firewallprotocol">
												<option  value="TCP">TCP</option>
												<option  value="UDP">UDP</option>
												<option  value="ICMP">ICMP</option>
											</select>
										</th>
										<th><input type="text" id="startport" name='startport' min='1' max='99999'/></th>
										<th><input type="text" id="endport" name='endport' min='1' max='99999'/></th>
									</tr>
								</tbody>
							</table>
					</form>
					<br>
					<h5>방화벽 리스트</h5>
					 <table id="firewallinfo_table" class="table table-condensed">
					 	<thead>
						 	<tr  style='background-color:#fefefe'>
						  		<th class="subtitle">cirlist</th>
						 		<th class="subtitle" >Protocol</th>
						 		<th class="subtitle" >Start Port</th>
						 		<th class="subtitle" >End Port</th>
						 		<th  class="subtitle" >삭제 및 수정</th>
						 	</tr>
					 	</thead>
					 	<tbody>
					 	</tbody>
					 </table>
				</div>
				
	<!--        ////////////////////////////////////////       -->			
				<div id="portforwardinginfo">
					<h5>포트포워딩 추가</h5>
					<form id="createportforwardingform">
						<div class="nav pull-right" >
							<input class="btn" id="createportforwardingbtn" value="추가하기"/>
						</div>
						<br>
						<table style="width:100%">
							<thead>
								<tr>
									<th>서버</th>
									<th>공용포트</th>
									<th>사설포트</th>
									<th>프로토콜</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th>
										<select id="serverlist">
										</select>
									</th>
									<th>
										<input type="text" size="10" id="startport" name="publicport" min='1' max='99999'/> - <input type="text"  name="publicendport"id="startport" min='1' max='99999' size="10"/>
									</th>
									<th>
										<input type="text"  size="10"id="startport"  name="privateport" min='1' max='99999'/> - <input type="text" id="startport" name="privateendport"  min='1' max='99999' size="10"/>
									</th>
									<th>
										<select id="portforwardingprotocol">
											<option  value="TCP">TCP</option>
											<option  value="UDP">UDP</option>
										</select>
									</th>
								</tr>
							</tbody>
						</table>
					</form>
					<br>
					<h5>포트포워딩 리스트</h5>
					 <table id="portforwardinginfo_table" class="table table-condensed">
					 	<thead>
						 	<tr style='background-color:#fefefe'>
						  		<th class="subtitle" >서버</th>
						 		<th class="subtitle" >공용포트</th>
						 		<th class="subtitle" >사설포트</th>
						 		<th class="subtitle">프로토콜</th>
						 		<th  class="subtitle">설명</th>
						 		<th  class="subtitle">삭제 및 수정</th>
						 	</tr>
					 	</thead>
					 </table>
				</div>
	<!--        ////////////////////////////////////////       -->
		</div><!-- networkinfodiv  -->
			</div>
		</div>
	</div>