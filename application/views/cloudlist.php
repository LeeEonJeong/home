<span style="display:none" id="where" >cloudlist</span>
 
<!-- 서버검색하기 -->
	<div class="container-fluid">
		<div class="row-fluid" >
			<div class="span7"  >
				<h5>서버검색하기</h5>
				<form>
					<div id='searchvmdiv' class = "custom-search-input">
						<select id='zonename'>
			   					<option value='all'>존을 선택하세요.</option>
								<option value="eceb5d65-6571-4696-875f-5a17949f3317">KOR-Central A</option>
								<option value="9845bd17-d438-4bde-816d-1b12f37d5080">KOR-Central B</option>
								<option value="dfd6f03d-dae5-458e-a2ea-cb6a55d0d994">KOR-HA</option>
								<option value="95e2f517-d64a-4866-8585-5177c256f7c7">KOR-Seoul M</option>
								<option value="3e8ce14a-09f1-416c-83b3-df95af9d6308">JPN</option>
								<option value="b7eb18c8-876d-4dc6-9215-3bd455bb05be">US-West</option>
							</select>
							<input type="text" class="input-medium search-query" id='searchword'	placeholder="검색할 서버명을  입력해 주세요." />
						<span class="input-group-btn">
							<button  id='searchvmbtn' type="button">
								<i class="icon-search fa-10x"></i> 검색
							</button>
						</span> 
					</div> 
				</form>
			</div>
			<div class="span5" >
			<div class="nav pull-right">
				<br><br> 
					<a class="btn btn-primary" href="/orderCloud">서버 생성하기</a> 
			</div> 
			</div>
		</div>
	</div>
<script>
$(
		function(){ 
			function setModalMsg(msg){ 
				 $('#msgModal #msg').empty();
				 $('#msgModal #msg').html(msg);
				 return $('#msgModal');
			} 
			
			function showLoadingModal(){
				$('#loadingModal').modal({backdrop:"static", keyboard:false}); 
			}

			function async(jobid, processname){
				 showLoadingModal();
				 $.ajax({
					 type:'GET',
					 url:'/asyncProcess/queryAsyncJobResult/'+jobid,
					 dataType:'json',
					 success : function(data){  
						 if(data === 'error'){ 
							 setModalMsg(processname + '실행이 실패하였습니다..(aync)').modal();
						 }
					 },
					 error:function(){ 
						 setModalMsg(processname + '실행이 실패하였습니다..(aync)').modal(); 
					 },
					 complete:function(){
						 $('#loadingModal').modal('hide');
						 window.location.reload();
					 }
				 }); 
			} 
			
			$('#serveractiondiv').hide();
			$('#serverinfodiv').hide();
			$('#servervolumeinfodiv').hide();
			$('#serveractiondiv').prev('span').text('서버를 선택해 주세요.');	

			$('#serverlist_table tbody tr').each(
				function(index){ 
					vmstate = $('#state'+index).text();
				 
					switch(vmstate){
						case 'Running': 
							$('#'+index+'start').prop('disabled',true);
							$('#'+index+'stop').prop('disabled',false);
							$('#'+index+'reboot').prop('disabled',false);
							break;
						case 'Stopped':
							$('#'+index+'start').prop('disabled',false);
							$('#'+index+'stop').prop('disabled',true);
							$('#'+index+'reboot').prop('disabled',true);
							break;
						default : //Starting , Stopping
							$('#'+index+'start').prop('disabled',true);
							$('#'+index+'stop').prop('disabled',true);
							$('#'+index+'reboot').prop('disabled',true);
							break;
					}
				}
			);

			$('#searchvmbtn').click(
					function(){ 
						zoneid = $('#searchvmdiv #zonename option:selected').val(); 
						searchword = $('#searchvmdiv #searchword').val();
 
						if(zoneid=='all' && searchword==''){
							window.location.href = '/cloudlist';
						}else if(searchword==''){  
							window.location.href = '/cloudlist/showSearchResultByZoneId/'+zoneid;
						}else{ 
							window.location.href = '/cloudlist/showSearchResult/'+zoneid+'/'+searchword;	 
						} 
						 
					}
			);
			
			$(":button").click(	 
				function(){
				    name = $(this)[0].id;
				    formindex = name.replace(/[^0-9]/g,"");
					action = name.substring(1);
					var formData = $("#form"+formindex).serialize();
					 
					if(action=='start'){ 
						$.ajax({
								type : "POST",
								url: '/cloudlist/startVM',
								dataType: 'json',
								data : formData,
								success : function(data){
									 jobid = data.jobid; 
									 async(jobid,'SERVER START'); 
								},
								error : function( ){  
									 setModalMsg('실행실패!').modal(); 
								}
						}); 
					}else if(action == 'stop'){ 
						$.ajax({
							type : "POST",
							url: '/cloudlist/stopVM',
							data : formData,
							dataType: 'json',
							success : function(data){
								 jobid = data.jobid; 
								 async(jobid,'SERVER STOP'); 
							},
							error : function( ){  
								setModalMsg('실행실패!').modal(); 
							}
						}); 
					}else if(action == 'reboot'){ 
						$.ajax({
							type : "POST",
							url: '/cloudlist/stopVM',
							data : formData,
							dataType: 'json',
							success : function(data){
								 jobid = data.jobid; 
								 async(jobid,'SERVER REBOOT'); 
							},
							error : function( ){  
								setModalMsg('실행실패!').modal(); 
							}
					}); 
				}  
		});

		$('#osinitializebtn').click(
				function(){
					vmid = $('#serverlist_table #vmid').text(); 
					showLoadingModal();
					$.ajax({
						type:'GET',
						url:'/cloudlist/initializeOS/'+vmid,
						dataType: 'json',
						success : function(data){
							 jobid = data.jobid; 
							 async(jobid,'SERVER 초기화'); 
						},
						error : function( ){ 
							setModalMsg('실행실패!').modal(); 
						}
					}); 
				}
		);

		$('#resetpwdbtn').click(
				function(){
					vmid = $('#serverlist_table #vmid').text(); 
					showLoadingModal();
					$.ajax({
						type:'GET',
						url:'/cloudlist/resetPwdVM/'+vmid,
						dataType: 'json',
						success : function(data){
							 jobid = data.jobid; 
							 async(jobid,'SERVER 비밀번호 초기화'); 
						},
						error : function( ){ 
							setModalMsg('실행실패!').modal(); 
						}
					});
				}
		); 

		$('#deletevmbtn').click(
				function(){
					vmid = $('#serverlist_table #vmid').text(); 
					showLoadingModal();
					$.ajax({
						type:'GET',
						url:'/cloudlist/deleteVM/'+vmid,
						dataType: 'json',
						success : function(data){
							 jobid = data.jobid; 
							 async(jobid,'SERVER 비밀번호 초기화'); 
						},
						error : function( ){ 
							setModalMsg('실행실패!').modal(); 
						}
					});
				}
		); 

		$('#serverlist_table tr').click(
				function(){
					$('#serveractiondiv').show();
					$('#serverinfodiv').show();
					$('#servervolumeinfodiv').hide();
					$('#serveractiondiv').prev('span').empty();
					
					$('#serverinfoMenu').addClass('active');
					$('#diskinfoMenu').removeClass('active');
					
				    formindex =$(this).index();
					formdata = $("#form"+formindex).serializeArray()[0]; //어차피하나(vmid)
					vmid = formdata['value']; 
					state = $('#serverlist_table #state'+formindex).text(); 
					
					if(state=='Stopped'){
						$('#osinitializebtn').prop('disabled',false);
						$('#resetpwdbtn').prop('disabled',false);
						$('#deletevmbtn').prop('disabled',false); 
					}else{
						$('#osinitializebtn').prop('disabled',true);
						$('#resetpwdbtn').prop('disabled',true);
						$('#deletevmbtn').prop('disabled',true);
					}
 
 					$.ajax({
 	 					type:"GET",
 	 					url:"/cloudlist/searchVM/"+vmid,
 	 					dataType:'json',
 	 					success:function(data){
 	 	 					vm = data.virtualmachine;
 	 	 					 	 	 	 				
 	 	 					$('#serveractiondiv').prev('span').html("<h5>선택된 서버 : <span id='selectvmid' style='display:none'>"+vm.id+"</span>" + vm.displayname + "</h5>"); 
 	 	 					$('#serverinfo_table #displayname').html(vm.displayname);
 	 	 					$('#serverinfo_table #hostname').html(vm.name);
 	 	 					$('#serverinfo_table #vmid').html(vm.id);
 
							networks = vm.nic;
							
							if($.isArray(vm.nic)){
								inneraddr = [];
								for(key in networks){ 
									ipaddress = networks[key]['ipaddress']; 
									inneraddr.push(ipaddress);
								}
								inneraddr = inneraddr.join("/");
							}else{
								inneraddr = networks.ipaddress;
							} 
							
 	 	 					$('#serverinfo_table #inneraddr').html(inneraddr);

 	 	 					$.ajax({
 	 							type : "GET",
 	 							url: '/networklist/getPublicIpAddressByZoneId/'+vm.zoneid, 
 	 							dataType:'json',
 	 							success : function(data){
 	 								publicipaddresses = data.publicipaddress;
 	 	 							count = data.count;
 	 								if(count == 1 ){ //존마다 하나(기본제공)
 	 									$('#outeraddr').html(publicipaddresses.ipaddress);
 	 	 							}else{ 
 	 									outeraddr = [];
 	 									$.each(publicipaddresses, function(key,value){
 	 										ipaddress = value.ipaddress;
 	 										outeraddr.push(ipaddress);
 	 									});
 	 									$('#outeraddr').html(outeraddr.join("/"));
 	 	 							}
 	 							},
 	 							error : function( ){  
 	 								alert('실행실패');
 	 							}
 	 					 	});
 	 	 					
 	 	 					$('#outeraddr').html(outeraddr);
 	 	 					$('#templatename').html(vm.templatename);
 	 	 					$('#serverinfo_table #zonename').html(vm.zonename);
 	 	 					$('#serverinfo_table #serviceofferingname').html(vm.serviceofferingname);
 	 	 					$('#serverinfo_table #created').html(vm.created);
 	 	 					$('#serverinfo_table #state').html(vm.state);
 	 					},
 	 					error:function(){
 	 	 					alert('수행실패');
 	 					}
					});
				}
		);

		$('#serverinfoMenu').click(
				function(){
					$('#serverinfoMenu').addClass('active');
					$('#diskinfoMenu').removeClass('active');
					$('#serveractiondiv').show();
					$('#serverinfodiv').show();
					$('#servervolumeinfodiv').hide();
					//selectserver = $('#serverinfodiv').prev('span').find('#selectvmid').text();
				}
		);
			 

		$('#diskinfoMenu').click(
			function(){
				$('#serverinfoMenu').removeClass('active');
				$('#diskinfoMenu').addClass('active');
				$('#serveractiondiv').hide();
				$('#serverinfodiv').hide();
				$('#servervolumeinfodiv').show();
				
				selectvmid = $('#serveractiondiv').prev('span').find('#selectvmid').text();
 
				$.ajax({
	 					type:"GET",
	 					url:"/volumelist/getVolumes/"+selectvmid,
	 					dataType:'json',
	 					success:function(data){
		 					$('#servervolumeinfo_table tbody').empty();
	 	 					count = data.count; 
	 	 					volumes = data.volume; 
	 	 					
	 	 					for(i=0; i<count;i++){
								volume = volumes[i];

		 	 					if(count==1){
									volume = volumes;
			 	 				}
								 
								datadisk = parseFloat(volume.size) / 1073741824 ;
							 
	 	 						$('#servervolumeinfo_table tbody').append($('<tr></tr>'));
	 	 						lasttr = $('#servervolumeinfo_table tbody tr:last');
	 	 						lasttr.append($('<td></td>').html(i+1));
	 	 						lasttr.append($('<td></td>').html(volume.name));
	 	 						lasttr.append($('<td></td>').html(volume.type));
	 	 						lasttr.append($('<td></td>').html(datadisk+' GB'));
	 	 						lasttr.append($('<td></td>').html(volume.created));
	 	 						 
	 	 					} 
 
	 					},
	 					error:function(){
	 	 					alert('수행실패');
	 					}
				});
			}
		); 
}); 

 
</script>
<div id='result'></div>
<!-- 서버목록 -->
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12"> 
				<h5>서버목록 (총 <?= $vmcount?>건)</h5>
				<table id="serverlist_table" class="table table-hover" >
					<thead>
						<tr>
							<td>번호</td>
							<td>계정명(displayname)</td>
							<td>운영체제(templatedisplaytext)</td>
							<td>데이터센터(zonename)</td>
							<td>생성시간(created)</td>
							<td>상태(state)</td>
							<td>제어</td>
						</tr>
					</thead>
					<tbody>
		<?php
	 
		for($i = 0; $i < $vmcount; $i ++) {
			if ($vmcount == 1) {
				$vm = $clouds['virtualmachine'];
			} else {
				$vm = $clouds['virtualmachine'][$i];
			}
			 
			echo "<tr><form id='form".$i."' method='post'><td>";
			echo "<input type='hidden' id='vmid' name='vmid' value='" . $vm ['id'] . "'/>";
			echo $i + 1;
			echo "</td><td id='displayname'>";
			echo $vm ['displayname'];
			echo "</td> <td id='templatedisplaytext'>";
			echo $vm ['templatedisplaytext'];
			echo "</td> <td id='zonename'>";
			echo $vm ['zonename'];
			echo "</td> <td id='created'>";
			echo $vm ['created'];
			echo "</td> <td id='state".$i."'>";
			echo $vm ['state'];
			echo "</td> <td>";
			echo "<input class = 'btn' id='".$i."start' type='button' value='시작'/>";
			echo "<input class = 'btn' id='".$i."stop'  type='button' value='정지'/>";
			echo "<input class = 'btn' id='".$i."reboot' type='button' value='재부팅'/>";
			echo "</td></form></tr>";
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