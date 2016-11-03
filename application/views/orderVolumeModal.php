 http://getbootstrap.com/2.3.2/scaffolding.html
 <script>
 $(
			function(){ 
				$('#orderVolumebtn').click(
						function(){
							diskname = $('#diskname').val();
							zoneid = $('#zonename option:selected').val();
							usageplantype = $(':radio[name="usageplantype"]:checked').val();
							diskofferingid = $('#diskoffering option:selected').val(); 
							orderdata = 
							{
								'diskname' : diskname,
								'zoneid' : zoneid,
								'diskofferingid' : diskofferingid,
								'usageplantype' : usageplantype
							}  
							$("#ordereVolumeModal").modal('hide'); 
	 						showObj(orderdata);

	 						$.ajax({
								type : "POST",
								url: '/orderVolume/orderVolume',
								data : orderdata,
								dataType : 'json', 
								success : function(data)
								{  
// 									showObj(data);
									if(data.jobid){
										async(data.jobid, 'CREATE DATADISK');
									}else{
										setModalMsg('디스크 추가 실패').modal();
									}
								},
								error : function( ){  
									setModalMsg('디스크 추가 실패(error)').modal();
								}
							}); 			
						}
				); 
	});  
</script>
 
<!-- disk 추가 신청 modal  -->
<div class="modal fade" id='ordereVolumeModal' role="dialog">
  <div class="modal-dialog">
	  <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Disk 추가 신청</h4>
	      </div>
	      <div class="modal-body">
	        <table> 
			   		<tr id="servername">
			   			<td>스토리지명</td>
			   			<td colspan="2"><input type="text" id="diskname" /></td>
			   			 
			   		</tr>
			   		<tr>
			   			<td>위치</td>
			   			<td>
			   				<select id='zonename'>
			   					<option>존을 선택하세요.</option>
								<option value="eceb5d65-6571-4696-875f-5a17949f3317">KOR-Central A</option>
								<option value="9845bd17-d438-4bde-816d-1b12f37d5080">KOR-Central B</option>
								<option value="dfd6f03d-dae5-458e-a2ea-cb6a55d0d994">KOR-HA</option>
								<option value="95e2f517-d64a-4866-8585-5177c256f7c7">KOR-Seoul M</option>
								<option value="3e8ce14a-09f1-416c-83b3-df95af9d6308">JPN</option>
								<option value="b7eb18c8-876d-4dc6-9215-3bd455bb05be">US-West</option>
							</select>
			   			</td>
			   			 
			   		</tr>
			   		<tr>
			   			<td>요금제 선택</td>
				   		<td>
					   		<label class="radio-inline">
					   			<input type="radio" name="usageplantype" id="hourly" value="hourly" >시간요금제
					   		</label>
							<label class="radio-inline">
								<input type="radio" name="usageplantype" id="montly"value="monthly">월요금제
							</label>
				   		</td>
			   		</tr>
			   		<tr>
			   			<td>스토리지 용량</td>
				   		<td  colspan="3">
				   		 	<select id='diskoffering'>
				   		 		<option value="1539f7a2-93bd-45fb-af6d-13d4d428286d">10 GB</option>
				   		 		<option value="64ba2191-b22a-42a2-aaab-075b0235ac18">20 GB</option> 
				   		 		<option value="d4fc0ff3-91ee-40af-a2f3-9ec0eb4773f8">30 GB</option> 
				   		 		<option value="a7bbe834-c195-45ed-a668-2e4aadf0adb7">40 GB</option> 
				   		 		<option value="277d1cea-d51a-4570-af16-0b271795d2a0">50 GB</option>
				   		 		<option value="2791cad6-b68a-4412-8867-ca07e5d64ae4">60 GB</option> 
				   		 		<option value="698adf24-7ae2-4100-af56-a35ecd7bd67c">70 GB</option>
				   		 		<option value="78fe5777-8903-4193-bada-ee8686bc543a">80 GB</option> 
				   		 		<option value="4df2364f-1548-4d42-9d66-25fc3a195c5c">90 GB</option> 
				   		 		<option value="ef334e6f-f197-4988-9781-86c985e82591">100 GB</option> 
				   		 		<option value="e91d8b54-28c3-43a7-b3a4-439ced6fe282">110 GB</option>
				   		 		<option value="b67fea21-0360-4072-8877-815e9254ab73">120 GB</option> 
				   		 		<option value="b825b79c-7f31-47f8-b886-ed355253c9e9">130 GB</option>
				   		 		<option value="40f5cd46-ec3e-4ca3-9df5-f55d590149a1">140 GB</option>
				   		 		<option value="dc4ec8a0-c0f6-46af-a475-9fcec21bc2fa">150 GB</option> 
				   		 		<option value="dc4ec8a0-c0f6-46af-a475-9fcec21bc2fa">160 GB</option> 
				   		 		<option value="2b034310-4309-4f43-8e78-c94445c70783">170 GB</option> 
				   		 		<option value="d02fc827-2c52-423d-9a6c-d324e0fbb021">180 GB</option>
				   		 		<option value="ec59a93f-36bd-43d0-abe7-af70d97d8b1b">190 GB</option> 
				   		 		<option value="cbe4ccad-be3a-43f6-9abd-d2b6d7097e40">200 GB</option>
				   		 		<option value="dc467090-6649-43b2-abd0-4d8ea52d5f49">210 GB</option> 
				   		 		<option value="2527cce9-1b7a-4b4e-b6df-568c4a67678c">220 GB</option> 
				   		 		<option value="95da4d30-f215-47ad-b7b8-11ae3a055e03">230 GB</option> 
				   		 		<option value="a70e745c-ef31-4fbb-a62b-ff5af031f8a1">240 GB</option>
				   		 		<option value="e3782b90-3780-4c2c-85a1-48ccf304590e">250 GB</option> 
				   		 		<option value="600a22dc-8955-4fc6-a9d6-516c8db1ac5a">260 GB</option>
				   		 		<option value="bb0227cf-9ef6-4005-bd27-666f49481003">270 GB</option> 
				   		 		<option value="c96b005c-81a3-46ca-ad63-96cd271faf6b">280 GB</option> 
				   		 		<option value="1c7521b1-8753-427b-874b-a740e6e0184d">290 GB</option> 
				   		 		<option value="03ee7edf-a91f-4910-9e1c-551222bc6e94">300 GB</option> 
				   		 	</select>
				   		</td>
			   		</tr>  
			 	</table>  
	      </div>
	      <div class="modal-footer"> 
	       	 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	         <input type="button" class="btn btn-primary" id="orderVolumebtn" class="btn" value="확인"/>
	      </div>
	    </div> 
	</div>
</div>