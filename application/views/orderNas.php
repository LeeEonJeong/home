<script>
$(
	function(){ 
		$('#orderbtn').click(function(){  
			name = $('#nasvolumename').val();
			path = $('#mountPath').val();
			totalsize = parseInt($('#standardcapacity').text()) + parseInt($('#addcapacity').val());
			volumetype = $(':radio[name="protocol"]:checked').val();
			zoneid = $('#zonename option:selected').val();
			usageplantype = $(':radio[name="usageplantype"]:checked').val();
			
			orderdata = 
			{
				'name' : name,
				'path' : path,
				'totalsize' : totalsize,
				'volumetype' : volumetype,
				'usageplantype' : usageplantype,
				'zoneid' : 	zoneid
			} 
			showLoadingModal();
			 $.ajax({
					type : "POST",
					url: '/orderNas/addVolume',
					data : orderdata,
					dataType : 'json',
					success : function(data)
					{  
						showObj(data);
						if(data.errortext){ 
							setModalMsg(data.errortext).modal();
						}else if(data.status == 'success'){
							 volume = data.response;
							 location.href='/naslist';
							 setModalMsg(volume.name+"("+volume.volumetype+")"+"생성 되었습니다.").modal(); 
							  
						}
					},
					error : function( ){  
						setModalMsg('NAS 생성 실패(error)').modal();
					},
					complete : function(){
// 						setTimeout(function(){},3000); //3초있다가
						$('#loadingModal').modal('hide'); 
					}
			});	
		}); 
});  
</script>
<div id='result'class="span12">
			<h3>NAS볼륨생성</h3>
			<hr>
			  	<table id='nasvolumeorder_table'>
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
			   		<tr>
			   			<td>볼륨명</td>
			   			<td><input type="text" id="nasvolumename" /></td>
<!-- 			   			<td><input type="button" class='btn' value="중복확인"/></td> -->
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
			   			<td>기본용량</td>
			   			<td ><span id="standardcapacity" style='display: none'>1000</span> 1,000 GB </td>
			   		</tr> 
			   		<tr>
			   			<td>추가용량</td>
				   		<td><input id="addcapacity"type="text" value="0"/></td>
			   		</tr>
			   		<tr> 
			   			<td>프로토콜</td>
				   		<td>
					   		<label class="radio-inline">
					   			<input type="radio" name="protocol" id="NFS" value="nfs" >NFS
					   		</label>
							<label class="radio-inline">
					   			<input type="radio" name="protocol" id="CIFS" value="cifs" >CIFS
					   		</label>
					   		<label class="radio-inline">
					   			<input type="radio" name="protocol" id="iSCSI" value="iSCSI" >iSCSI (이거안됨)
					   		</label>
				   		</td>
			   		</tr>
			   		<tr>
			   			<td>mount Path</td>
			   			<td>
				   			 <input type="text" id="mountPath"/>
				   		</td> 
			   		</tr>
			   		<tr>
			   			<td><a href="./cloudlist" class="btn">취소</a></td>
			   			<td><input type="button" id="orderbtn"class="btn" value="신청"/></td>
			   		</tr>
			 	</table>  
</div>