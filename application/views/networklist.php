
<span style="display:none" id="where" >network</span>

<!-- 설명추가  모달 -->
<div class="modal fade" id='ipdescModal' role="dialog">
    <div class="modal-dialog">   
	    <div class="modal-content">
	    	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal">&times;</button>
	        	<h4 class="modal-title">IP 설명추가</h4>
	      	</div>
	        <div class="modal-body">
		        <form>
			        <label for='ip'>IP</label>
			        <input type='text' name='ip' id='ip'/>
			        <input style='display: none' name='ipid' id='ipid'/>
			        <label for='ipdesc'>설명</label>
			       	<input type="text" name='ipdesc' id='ipdesc'>
			    </form>
		    </div>
	       	<div class="modal-footer">
	        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	         	<input type="button" class="btn btn-primary" id="ipdescModalbtn"class="btn" value="확인"/>
	      	</div> 
	    </div> 
    </div>
</div> 

<!--  네트워크검색하기 -->
	<div class="container-fluid">
		<div class="row-fluid" >
			<div class="span7"  >
				<h5>네트워크 검색하기</h5>
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
						<input type="text" class="input-medium search-query"	placeholder="검색할 서버명을  입력해 주세요." />
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
					<a class="btn btn-primary" href="/orderCloud">IP 추가 신청</a> 
			</div> 
			</div>
		</div>
	</div>

<script>
$(
		function (){ 
			$('#networkinfodiv').prev('span').text('네트워크를 선택해 주세요.');
			$('#networkinfodiv').hide(); 
			
		 	//나중에 staticnat 기능 추가
		 	$('#staticnat').prop('disabled',true);
			$('#ipaddrdesc').prop('disabled',false); 
		 	
			$("#networklist_table tr").click(function(){
				//publicip = $(this).find('form').val();
			 	$('#networkinfodiv').show();
			 	$('#firewallinfo').hide();
			 	$('#portforwardinginfo').hide();
			 	$('#publicipinfo').show(); 

			 	$('#networkinfoMenu').addClass('active');	
			 	$('#firwallMenu').removeClass('active');	
			 	$('#portforwardingMenu').removeClass('active');
			 	$('#networkinfodiv').prev('span').remove();
			 	
			 	
			 	form = $(this).find('form');
			 	var formData = form.serialize(); 
			 	$.ajax({
					type : "POST",
					url: '/networklist/getPublicIpInfo',
					data : formData,
					dataType:'json',
					success : function(publicip){
						if(publicip.isstaticnat == 'true'){ 
						 	$('#portforwardingMenu').hide();
						} else{
							$('#portforwardingMenu').show();
						}
						$('#selectipaddress').html(publicip.ipaddress);
						$('#selectipaddressid').html(publicip.id);
						$('#zoneid').html(publicip.zoneid);
						$('#publicipinfo #ipaddress').html(publicip.ipaddress);
						$('#publicipinfo #id').html(publicip.id);
						$('#publicipinfo #allocated').html(publicip.allocated);
						$('#publicipinfo #state').html(publicip.state);
						$('#publicipinfo #desc').html(publicip.desc); 

						issourcenat = '';
						if(publicip.issourcenat === 'true'){
							issourcenat = '예'
							$('#deleteip').prop('disabled',true);
						}else{
							issourcenat = '아니오'
							$('#deleteip').prop('disabled',false);
						}
						$('#publicipinfo #issourcenat').html(issourcenat);
						
					},
					error : function( ){  
						alert('실행실패');
					}
			 	});
			});

			$('#ipaddrdesc').click(
					function(){ 
						$ip = $('#publicipinfo_table #ipaddress').html();
						$ipid = $('#publicipinfo_table #id').html();
						$ipdesc = $('#publicipinfo_table #desc').html();
						
						$("#ipdescModal #ip").val($ip);
						$("#ipdescModal #ip").prop('disabled',true);
						$("#ipdescModal #ipid").val($ipid); 
						$("#ipdescModal #ipdesc").val($ipdesc);

						$('#ipdescModal').modal();
					}
			);

			$('#ipdescModal #ipdescModalbtn').click(
					function(){
						$ipid = $("#ipdescModal #ipid").val(); 
						$desc = $("#ipdescModal #ipdesc").val();  
						$.ajax({
							type:'GET',
							url:'/networklist/updateIpAddress/'+$desc+"/"+$ipid,
							dataType: 'json',
							success : function(data){
								//showObj(data);
								if(data.success == 'true'){
									window.location.reload();
								}else{
									setModalMsg('IP설명추가실패').modal();
								}
							},
							error : function( ){  
								setModalMsg('IP설명추가실패(error)').modal();
							}
						});
					}
			);

			$('#deleteip').click(
					function(){
						$ipid = $('#publicipinfo_table #id').html();
						 
						$.ajax({
							type:'GET',
							url:'/networklist/disassociateIpAddress/'+$ipid, //비동기
							dataType: 'json',
							success : function(data){
								showObj(data);
								 if(data.jobid){
									async(data.jobid,'IP 삭제');
								}else{
									window.location.reload();
									setModalMsg('IP삭제 실패').modal();
								}
							},
							error : function( ){  
								setModalMsg('IP삭제 실패(error)').modal();
							}
						});
					}
			);
			 

			$('#networkinfoMenu').click(function(){
				$('#networkinfodiv').show();
			 	$('#firewallinfo').hide();
			 	$('#portforwardinginfo').hide();
			 	$('#publicipinfo').show(); 

			 	$('#networkinfoMenu').addClass('active');	
			 	$('#firwallMenu').removeClass('active');	
			 	$('#portforwardingMenu').removeClass('active');
			 	$('#networkinfodiv').prev('span').remove();
			 	 
			}); 

			$('#firwallMenu').click(function(){
			 	$('#portforwardinginfo').hide();
			 	$('#publicipinfo').hide();
			 	$('#firewallinfo').show();
			 	$('#firewallinfo_table tbody').remove(); 
			 	
				$('#firwallMenu').addClass('active');
				$('#portforwardingMenu').removeClass('active');
				$('#networkinfoMenu').removeClass('active');
			 	
				selectipaddressid = $('#selectipaddressid').text(); 
				
				$.ajax({
					type:"GET",
					url: '/networklist/getlistFireWallInfoByIpAddress/'+selectipaddressid,
					dataType:'json',
					success : function(data){ 
						if(data==null){
							setModalMsg('방화벽 규칙이 없습니다.').modal();
						}else{
							$('#firewallinfo_table').append('<tbody></tbody>');
							count = data.count;
							firewallrules = data.firewallrule;
							
							for(i=0; i<count; i++){
								if(count==1){
									firewallrule = firewallrules;
								}else{
									firewallrule = firewallrules[i];
								}
								
								$('#firewallinfo_table tbody').append(
										$('<tr></tr>').append(
											$('<td></td>').html(firewallrule.cidrlist)).append(
											$('<td></td>').html(firewallrule.protocol)).append(
											$('<td></td>').html(firewallrule.startport)).append(
											$('<td></td>').html(firewallrule.endport)).append(
											$('<td></td>').html("<span class='modifyportforwardinglink'>수정</span>  |  <span style='color:red' class='deletefirewall'>삭제<span style='display:none'>"+firewallrule.id+"</span></span>")
										)
								);		
							}
						}
					},
					error : function( ){  
						alert('실행실패');
					}
				});
			});

			$('#portforwardingMenu').click(function(){ 
					$('#firewallinfo').hide();
				 	$('#publicipinfo').hide();
				 	$('#portforwardinginfo').show();
				 	$('#portforwardinginfo_table tbody').remove(); 
				 	$('#serverlist').children().remove(); 
				 	$('#portforwardingMenu').addClass('active');
					$('#firwallMenu').removeClass('active');
					$('#networkinfoMenu').removeClass('active');	
					
					selectipaddressid = $('#selectipaddressid').text();
					zoneid = $('#zoneid').text(); 
					
					$.ajax({
						type:"GET",
						url: '/networklist/getlistPortForwardingRulesByIpAdress/'+selectipaddressid, 
						dataType:'json',
						success : function(data){
 							if(data == null){
 	 							setModalMsg('포트포워딩 규칙이 없습니다.').modal();
 							}else{
 								count = data.count;
 		 					 	portforwardingrules = data.portforwardingrule;
								$('#portforwardinginfo_table').append('<tbody></tbody>');
								for(i=0; i<count; i++){
									if(count==1){
										portforwardingrule = portforwardingrules;
									}else{
										portforwardingrule = portforwardingrules[i]; 
									}									
									$('#portforwardinginfo_table tbody').append(
											$('<tr></tr>').append($('<td></td>').html(portforwardingrule.virtualmachinedisplayname))
														  .append($('<td></td>').html(portforwardingrule.publicport+' - '+portforwardingrule.publicendport))
														  .append($('<td></td>').html(portforwardingrule.privateport+' - '+portforwardingrule.privateendport))
														  .append($('<td></td>').html(portforwardingrule.protocol))
														  .append($('<td></td>').html(''))
														  .append($('<td></td>').html("<span class='modifyportforwardinglink'>수정</span>  |  <span style='color:red' class='deleteportforwarding'>삭제<span style='display:none'>"+portforwardingrule.id+"</span></span>"))
														  .append($('<span></span>').attr({id:'portforwardingid', style: 'display:none'}).html(portforwardingrule.id)) 
									).attr({id:i});  
								}
 							}
						},
						error : function( ){  
							alert('실행실패'); 
						}
					});//ajax 

					$.ajax({
						type:'GET',
						url:'/cloudlist/getVMsByZoneId/'+zoneid,
						dataType: 'json',
						success : function(data){
							if(data == null){
							}else{
								vms = data.virtualmachine;
								count = data.count;
							 
								for(i=0; i<count; i++){
									if(count==1){
										vm = vms;
									}else{
										vm=vms[i];
									}
									$('#portforwardinginfo #serverlist').append(
											$('<option></option>').attr({
												'value' : vm.displayname,
												'id' : vm.id
											}).html(vm.displayname)
									);
								}
							}
						},
						error : function( ){  
							alert('실행실패');
						}
					});
				 	
			}) //portforwardingMenu click 
	 

		$(document).on("click",".deleteportforwarding",function(){  
			portforwardingid = $(this).children('span').html();
			$.ajax({
				type:'GET',
				url:'/networklist/deletePortForwardingRule/'+portforwardingid,
				dataType: 'json',
				success : function(data){
					 jobid = data.jobid; 
					 async(jobid,'DELETE PORTFORWARDINGRULE'); 
				},
				error : function( ){  
					setModalMsg('실행실패!').modal(); 
				}
			});
		});

		$(document).on("click",".deletefirewall",function(){ 
			firewallid = $(this).children('span').html();
			alert(firewallid);
			$.ajax({
				type:'GET',
				url:'/networklist/deleteFirewallRule/'+firewallid,
				dataType: 'json',
				success : function(data){
					window.location.reload();
					//비동기맞나? 너무빨리끝남..
// 					 jobid = data.jobid; 
// 					 async(jobid,'DELETE FIREWALLRULE'); 
				},
				error : function( ){  
					setModalMsg('실행실패!').modal(); 
				}
			});
		});
			
		$('#createportforwardingbtn').click(
			function(){
				selectipaddressid = {name : 'ipaddressid', value : $('#selectipaddressid').text()};
				virtualmachineid = {name : 'virtualmachineid', value : $('#serverlist option:selected').attr('id')};
				protocol = {name : 'protocol', value : $('#portforwardingprotocol option:selected').val() };
 
				form = $('#createportforwardingform');
			 	var formData = form.serializeArray(); 
			 	formData.push(selectipaddressid,virtualmachineid,protocol); 
			 	
				$.ajax({
					type:'POST',
					url:'/networklist/createPortForwarding',
					data : formData,
					dataType: 'json',
					success : function(data){
						 jobid = data.jobid; 
						 async(jobid,'CREATE PORTFORWARDING'); 
					},
					error : function( ){  
						setModalMsg('실행실패!').modal(); 
					}
				});
			}

			
		);

		$('#createfirewallbtn').click(
				function(){ 
					selectipaddressid = {name : 'ipaddressid', value : $('#selectipaddressid').text()};
					protocol = {name : 'protocol', value : $('#firewallprotocol option:selected').val() };
	 
					form = $('#createportfirewallform');
				 	var formData = form.serializeArray();  
				 	formData.push(selectipaddressid, protocol);
 
				 	$.ajax({
						type:'POST',
						url:'/networklist/createFirewallRule',
						data : formData,
						dataType: 'json',
						success : function(data){ 
							 jobid = data.jobid; 
							 async(jobid,'CREATE FIREWALL'); 
						},
						error : function( ){  
							setModalMsg('실행실패!').modal(); 
						}
					}); 
		}); 
});  
</script> 
<!-- 네트워크목록--> 
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12" > 
				<h5>네트워크목록 (총 <?= $publicIpCount?>건) </h5>
				<table class="table table-hover" id="networklist_table">
					<thead>
						<tr>
							<td>번호</td>
							<td>공인IP</td>
							<td>위치</td>
							<td>설명</td>
							<td>StaticNat</td>
							<td>기본IP</td>
						</tr>
					</thead>
					<tbody>
		<?php
	 
		for($i = 0; $i < $publicIpCount; $i ++) {
			if ($publicIpCount == 1) {
				$publicIp = $publicIps['publicipaddress'];
			} else {
				$publicIp = $publicIps['publicipaddress'][$i];
			}
			 
			echo "<tr><form><td>";
			echo "<input type='hidden' name='publicip' value='" . $publicIp ['id'] . "'/>";
			echo $i + 1;
			echo "</td><td>";
			echo $publicIp ['ipaddress'];
			echo "</td> <td>";
			echo $publicIp ['zonename']; 
			echo "</td><td>";
			echo $publicIp['desc'];
			echo "</td><td>";
			if($publicIp['isstaticnat'] == 'true'){
				echo $publicIp['virtualmachinename'];
			}else{
				echo '-';
			}
			echo "</td><td>";
			if($publicIp['issourcenat'] == "true"){
				echo "<span style='color:blue'>YES</span>";
			}else{
				echo "<span style='color:red'>NO</span>";
			}
			echo "</form></tr>";
			 
		}
		?>
		</tbody>
				</table>
			</div>
		</div>
</div>

<!-- 서버관리메뉴 와 서브정보 -->
<div class="container-fluid">
	 <div class="row-fluid"> 