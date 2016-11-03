<?php include 'connectCIPModal.php'?>
<?php include 'disconnectCIPModal.php'?>

<span style="display:none" id="where" >nasvolume</span>

<!--  NAS볼륨 검색하기 -->
	<div class="container-fluid">
		<div class="row-fluid" >
			<div class="span7"  >
				<h5>NAS볼륨 검색하기</h5>
				<form>
					<div class="custom-search-input">
						<select id='zonename'>
			   					<option value='all'>존을 선택하세요.</option>
								<option value="eceb5d65-6571-4696-875f-5a17949f3317">KOR-Central A</option>
								<option value="9845bd17-d438-4bde-816d-1b12f37d5080">KOR-Central B</option>
								<option value="dfd6f03d-dae5-458e-a2ea-cb6a55d0d994">KOR-HA</option>
								<option value="95e2f517-d64a-4866-8585-5177c256f7c7">KOR-Seoul M</option>
								<option value="3e8ce14a-09f1-416c-83b3-df95af9d6308">JPN</option>
								<option value="b7eb18c8-876d-4dc6-9215-3bd455bb05be">US-West</option>
						</select>
						<input type="text" class="input-medium search-query" placeholder="검색할  NAS볼륨명을  입력해 주세요." />
						<span class="input-group-btn">
							<button type="button">
								<i class="icon-search fa-10x"></i> 검색
							</button>
						</span> 
					</div> 
				</form>
			</div>
			<div class="span5" >
			<div class="nav pull-right">
				<br><br> 
					<a class="btn btn-primary" href="naslist/orderNas">NAS생성</a> 
			</div> 
			</div>
		</div>
	</div>

<script>
$( 
//-----------------------------
		function (){
			$('#nasdiv').hide();
			$('#connectservermanagediv').hide();
			$('#cifsaccountmanagediv').hide();
			$('#nasdiv').prev('span').text('NAS볼륨을 선택해 주세요.');
 
			$('#nasvolumelist_table tr').click(
					function(){
						$('#nasdiv').prev('span').hide();
						$('#nasdiv').show();
						$('#connectservermanagediv').hide();
						$('#cifsaccountmanagediv').hide();
						$('#nasvolumeinfodiv').prev('span').remove();
						$('#nasvolumeinfoMenu').addClass('active');
						$('#connectserverManageMenu').removeClass('active');
						 
						
						$('#selectnasvolume').html($(this).find('#nasvolumename').text());

						nasvolumeid = $(this).find('span:first').text();

						$('#nasselectvolumeid').html(nasvolumeid);
 
						$.ajax({
							type:"GET",
	 	 					url:"/naslist/searchNas/"+nasvolumeid,
	 	 					dataType:'json',
	 	 					success:function(data){
	 	 	 					nas = data.response;
	 	 	 					
	 	 	 					$('#name').html(nas.name);
	 	 	 					$('#nasvolumeinfo_table #nasId').html(nas.id);
	 	 	 					$('#nasvolumeinfo_table #name').html(nas.name);
	 	 	 					$('#nasvolumeinfo_table #volumetype').html(nas.volumetype);
	 	 	 					$('#nasvolumeinfo_table #totalsize').html(nas.totalsize / 1073741824);
	 	 	 					$('#nasvolumeinfo_table #created').html(nas.created);
	 	 	 					$('#nasvolumeinfo_table #usageplantype').html(nas.usageplantype);
	 	 	 					$('#nasvolumeinfo_table #filesused').html(nas.filesused);
	 	 	 					$('#nasvolumeinfo_table #filestotal').html(nas.filestotal);
	 	 	 					$('#nasvolumeinfo_table #ipslashpath').html(nas.ip+"/"+nas.path);
	 	 	 					  
	 	 					},
	 	 					error:function(){
	 	 	 					alert('수행실패');
	 	 					}
						});
					}
			);
			 

			$('#deletenasvolumebtn').click(
					function(){
						nasvolumeid = $('#nasId').html(); 
						showLoadingModal();
						$.ajax({
							type:"GET",
	 	 					url:"/naslist/deleteVolume/"+nasvolumeid,
	 	 					dataType:'json',
	 	 					success:function(data){ 
	 	 	 					 window.location.reload();
	 	 					},
	 	 					error:function(){
	 	 	 					 setModalMsg('NAS 볼륨 삭제 실패');
	 	 					},
	 	 					complete:function(){
	 	 						setTimeout(function(){},2000);
		 	 					$('#loadingModal').modal('hide');
	 	 					}
						});
					}
			);

			$('#nasvolumeinfoMenu').click(
					function(){
						$('#connectserverManageMenu').removeClass('active');
						$(this).addClass('active');
						$('#cifsAccountManageMenu').removeClass('active');
						$('#connectservermanagediv').hide();
						$('#cifsaccountmanagediv').hide();
						$('#nasdiv').show();
					 
					}
			);

			$('#connectserverManageMenu').click(
					function(){
						$('#nasdiv').prev('span').hide();
						
						$('#nasvolumeinfoMenu').removeClass('active');
						$(this).addClass('active');
						$('#cifsAccountManageMenu').removeClass('active');
						$('#nasdiv').hide();
						$('#connectservermanagediv').show();
						$('#cifsaccountmanagediv').hide();

						$('#connectserverinfo_table tbody').empty();
						$.ajax({
							type:'GET',
							url:'/cloudlist/getVMsForNAS',
							dataType: 'json',
							success : function(data){ 
								
								for(i=0; i<data.length; i++){
								 vm = data[i];
								 if(vm.useNas){
									 use = '사용중'
								 }else{
									 use = '-'
								 }
								  
								 $('#connectserverinfo_table tbody').append($('<tr></tr>'))
								 	.append(
											 $('<td></td>').html(use),
											 $('<td></td>').html(vm.zonename),
											 $('<td></td>').html(vm.displayname),
											 $('<td></td>').html(vm.templatedisplaytext),
											 $('<td></td>').html(vm.serviceofferingname),
											 $('<td></td>').html(vm.state)
									);
								}
							},
							error : function( ){ 
								alert('실행실패');
							}
						}); //ajax
					 
					}
			);

			$('#cifsAccountManageMenu').click(
					function(){
						<?php ?>		//asdfasdf
						//workgroup 이름 가져오기
						$.ajax({
							type:'GET',
							url:'/cifsAccount/getWorkGroupName', 
							success : function(data){
							  	$('#cifsworkgroupname').val(data);
							},
							error : function( ){ 
								alert('workgroup 이름 가져오기 실패');
							}
						}); //ajax
						getCurrentCifsAccount();			 
					}
			);

			function getCurrentCifsAccount(){
				$('#nasdiv').prev('span').hide();
				$('#nasdiv').hide();
				$('#connectservermanagediv').hide();
				$('#cifsaccountmanagediv').show();

				$('#nasvolumeinfoMenu').removeClass('active');
				$('#connectserverManageMenu').removeClass('active');
				$('#cifsAccountManageMenu').addClass('active');
			 

				$.ajax({
					type:'GET',
					url:'/cifsAccount/listcifsAccounts',
					dataType: 'json',
					success : function(data){
						$('#cifsaccountlist_table tbody').empty(); 
						result = data.listcifsaccountsresponse;
						
						status = result.status;
						count = result.totalcount;
						accounts = result.response; //배열(Object)로 
//							showObj(response);
//							alert(status);
//							alert(count); 

						if(status == 'success'){ 
							 for(key in accounts){
								 $('#cifsaccountlist_table tbody').append($("<tr></tr>"))
								 .append(
										 $('<td></td>').html(accounts[key]),
										 $('<td></td>').html(" <a  class='modifycifsaccount btn'>수정<span style='display:none'>"+accounts[key]+"</span></a> <a  class='deletecifsaccount btn'>삭제<span style='display:none'>"+accounts[key]+"</span></a>")
								);
							}
						}
						else{
							setModalMsg('cifs계정 불러오기를 실패하였습니다.').modal();
						}   
					},
					error : function( ){ 
						alert('실행실패');
					}
				}); //ajax
			}

		

			$('#connectcipbtn').click(
					function(){ 
						$.ajax({
							type:'GET',
							url:'/cloudlist/getVMsForNAS',
							dataType: 'json',
							success : function(data){ 
								$('#connectcipModal #connectcipserverlist_table tbody').empty();
								$count = 0; 
								for(i=0; i<data.length; i++){
									 vm = data[i]; 
									 
									 if( vm.state == 'Running' && vm.useNas == false){
										$count++;
									 	$('#connectcipModal #connectcipserverlist_table tbody').append($('<tr></tr>'))
									 	.append(
												 $('<td></td>').html("<input type='checkbox' name='selectconnectvm' value= '"+ vm.vmid + "/" + vm.zonecipid + "'/>"), 
												 $('<td></td>').html(vm.zonename),
												 $('<td></td>').html(vm.displayname),
												 $('<td></td>').html(vm.templatedisplaytext),
												 $('<td></td>').html(vm.serviceofferingname),
												 $('<td></td>').html(vm.state),
												 $('<td></td>').html('')
										);
									}
								} 
								if($count == 0){
									setModalMsg('현재 CIP에 연결할 서버가 없습니다.').modal();
								}else{ 
									$('#connectcipModal').modal();
								}
							},
							error : function( ){ 
								alert('실행실패');
							}
						}); //ajax
					}
			);

			$('#disconnectcipbtn').click(
					function(){ 
						$.ajax({
							type:'GET',
							url:'/cloudlist/getVMsForNAS',
							dataType: 'json',
							success : function(data){
								//alert(data.length);
								$('#disconnectcipModal #disconnectcpiserverlist_table tbody').empty();

								$useNasCount = 0;
								for(i=0; i<data.length; i++){
									 vm = data[i]; 
									 if(vm.useNas == true && vm.state=='Running'){
										 $useNasCount++;
									 	$('#disconnectcipModal #disconnectcpiserverlist_table tbody').append($('<tr></tr>'))
									 	.append(
												 $('<td></td>').html("<input type='checkbox' name='selectdisconnectvm' value= '"+ vm.vmid + "/" + vm.nicid + "'/>"), 
												 $('<td></td>').html(vm.zonename),
												 $('<td></td>').html(vm.displayname),
												 $('<td></td>').html(vm.templatedisplaytext),
												 $('<td></td>').html(vm.serviceofferingname),
												 $('<td></td>').html(vm.state),
												 $('<td></td>').html('')
										);
									}
								}
								if($useNasCount == 0){
									setModalMsg('현재 CIP에 연결된 서버가 없습니다.').modal();
								}else{
									$('#disconnectcipModal').modal();
								}
							},
							error : function( ){ 
								alert('실행실패');
							}
						}); //ajax
					}
			);
 

			$('#addcifsaccountbtn').click(
					function(){
						$('#cifsAccountModal h4').html("CIFS 계정 추가");
						$('#cifsAccountModal #cifsid').val('');
						$('#cifsAccountModal #cifspwd').val('');
						$('#cifsAccountModal #cifsid').attr('placeholder', 'CIFS 아이디');
						$('#cifsAccountModal #cifsid').prop('disabled',false);
						$('#cifsAccountModal #cifsaccountModalbtn').html('추가');
						$('#cifsAccountModal').modal();
					}
			); 

			$(document).on("click",".modifycifsaccount",function(){  
				cifsid = $(this).children('span').html();
				 
				$('#cifsAccountModal #title').html("CIFS 계정  수정");
				$('#cifsAccountModal #cifsid').val(cifsid);
				$('#cifsAccountModal #cifsid').attr('disabled',true);
				$('#cifsAccountModal #cifsaccountModalbtn').html('수정');
				$('#cifsAccountModal #cifspwd').val('');
				$('#cifsAccountModal').modal();
 
			});
				
			$(document).on("click",".deletecifsaccount",function(){  
				cifsid = $(this).children('span').html();

				$.ajax({
					type:'GET',
					url:'/cifsAccount/deleteCifsAccount/'+cifsid,
					dataType: 'json',
					success : function(data){ 
						 showObj(data);
						 if(data.status == 'success'){
							 setModalMsg(cifsid+'계정이 삭제되었습니다.').modal();
							 getCurrentCifsAccount();
						 }else if(data.errortext){
							 setModalMsg(data.errortext).modal();
						 }else{
							 setModalMsg('계정삭제 실행 실패').modal();
						 }
					},
					error : function( ){ 
						setModalMsg('계정삭제 실행 실패(error)').modal();
					}
				}); //ajax
			});

			$('#cifsAccountModal #cifsaccountModalbtn').click(
					function(){  
						action = $(this).html();
					 	cifsid = $('#cifsAccountModal #cifsid').val();
					 	cifspwd = $('#cifsAccountModal #cifspwd').val();
						//formData = $('#cifsAccountModal form').serialize();
						formData = '';
						formData += 'cifsid='+cifsid; 
						formData += '&cifspwd='+cifspwd; 
// 					 	alert(formData);
					 	
						if(action == '추가'){
							$.ajax({
								type:'POST',
								url:'/cifsAccount/addCifsAccount',
								dataType: 'json',
								data : formData,
								success : function(data){ 
									showObj(data); 
									 if(data.status == 'success'){
										 setModalMsg(cifsid+'계정이 생성되었습니다.').modal();
										 getCurrentCifsAccount();
									 }else if(data.errortext){
										 setModalMsg(data.errortext).modal();
									 }else{
										 setModalMsg('계정생성 실행 실패').modal();
									 }
								},
								error : function( ){							
									setModalMsg('계정생성 실행 실패(error)').modal();
								},
								complete : function(){
									$('#cifsAccountModal').modal('hide');
								}
							}); //ajax
						}else if(action == '수정'){
							alert('수정');
							$.ajax({
								type:'POST',
								url:'/cifsAccount/updateCifsAccount',
								data : formData,
								dataType: 'json',
								success : function(data){ 
									// showObj(data);
									 if(data.status == 'success'){
										 setModalMsg(cifsid+'계정이 수정되었습니다.').modal();
									 }else if(data.errortext){
										 setModalMsg(data.errortext).modal();
									 }else{ 
										 setModalMsg('계정수정 실행 실패').modal();
									 }
								},
								error : function( ){  
									setModalMsg('계정수정 실행 실패(error)').modal();
								},
								complete : function(){
									$('#cifsAccountModal').modal('hide');
								}
							}); //ajax
						}else{
							$(this).parents('.modal').hide();
						}
					}
			);

			$('#cifsworkgroupbtn').click( 
					function(){
						$newcifsworkgroupname = $('#cifsworkgroupname').val();
						if($newcifsworkgroupname ==''){
							alert('빈칸입니다.'); 
						}else{
// 							alert($newcifsworkgroupname);
							$.ajax({
								type:'GET',
								url:'/cifsAccount/updateAccountForNas/'+$newcifsworkgroupname, 
								dataType: 'json',
								success : function(data){ 
// 									 showObj(data);
									 if(data.status == 'success'){
										 setModalMsg(data.response.cifsworkgroup+'으로 워크그룹명이 변경되었습니다.').modal();
									 }else if(data.errortext){ 
										 setModalMsg(data.errortext).modal();
									 }else{  
										 setModalMsg('워크그룹 이름 변경 실패').modal();
									 }
								},
								error : function( ){  
									setModalMsg('워크그룹 이름 변경 실패(error)').modal();
								}
							}); //ajax
						}
					}
			);		 
}
//-----------------------------			
);  
</script>
<div id='result'></div>


  <!-- 서버 연결 Modal -->
  <div class="modal fade" id="connectServerModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">서버 연결</h4>
        </div>
        <div class="modal-body"> 
        	<p>
      	  		<span id='volumename'></span> 
	          	<span id='volumeid' style='display: none'></span> 
          		스토리지에 연결할 클라우드 서버를 선택해 주세요.
       		</p>
       	</div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">취소</button>
          <button type='button' id ='connectServerModalBtn' class='btn btn-primary'>연결하기</button>
        </div>
      </div>
      
    </div>
  </div>
  
   <!-- cifs 계정   Modal -->
  <div class="modal fade" id="cifsAccountModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id='title'>타이틀입니다.</h4>
        </div>
        <div class="modal-body">  
        	<form> 
        		<label for="cifsid"  >CIFS ID</label>
				<input type="text"   id="cifsid" name = 'cifsid'placeholder="CIFS 아이디">
        		<label for="cifspwd">CIFS PASSWORD</label>
        		<input type="text"   id="cifspwd" name='cifspwd' placeholder="CIFS 비밀번호">
        	</form>  
        		<ul>
        			<li>ID는 6자리 이상 20자리 이하여야 하며 영문, 숫자의 조합으로 구성</li>
        			<li> Password는 8자리 이상 14자리 이하여야 하며, 영문, 숫자, 특수문자 ()-_.의 조합으로 구성</li>
        		</ul>
       	</div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">취소</button>
          <button type='button' id ='cifsaccountModalbtn' class='btn btn-primary'></button>
        </div>
      </div>
      
    </div>
  </div>
 
 
 <!-- 볼륨목록-->
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12" >
				<h5>NAS볼륨 목록 (총 <?= $nasvolumeCount?>건)</h5>
				<table class="table table-hover" id="nasvolumelist_table">
					<thead>
						<tr>
							<td></td>
							<td>zone</td>
							<td>볼륨명</td>
							<td>신청용량(GB)</td>
							<td>현재 사용량(GB)</td>
							<td>프로토콜</td>
						</tr>
					</thead>
					<tbody>
					
						<?php 
						for($i = 0; $i < $nasvolumeCount; $i ++) {
							if ($nasvolumeCount == 1) {
								$nasvolume = $nasVolumes;
							} else {
								$nasvolume = $nasVolumes[$i];
							}
							
							$totalsize = $nasvolume['totalsize'] / 1073741824;
							$usedsize = $nasvolume['usedsize'] / 1073741824;
					 
							echo "<tr><td>";
							echo "<span style='display:none' id='nasvolumeid'>" . $nasvolume ['id'] . "</span>";
							echo $i + 1;
							echo "</td><td id='zonename'>";
							echo "<span style='display:none' id='zoneid'>" . $nasvolume ['zonename'] . "</span>";
							echo $nasvolume ['zonename']; //zonename
							echo "</td><td id='nasvolumename'>";
							echo $nasvolume ['name'];
							echo "</td> <td>";
							echo $totalsize;
							echo "</td> <td>";
							echo $usedsize ; 
							echo "</td> <td>";
							echo $nasvolume['volumetype'] ; 
							echo "</td></tr>";
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

<!-- 볼륨상세 정보 -->
<div class="container-fluid">
	 <div class="row-fluid"> 