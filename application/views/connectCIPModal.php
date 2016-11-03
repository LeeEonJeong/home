 <script>
$(
		function(){ 
			$('#connectciporderbtn').click(
					function(){
						selectconnectvm = $("input:checkbox[name='selectconnectvm']:checked");
 
						if(selectconnectvm.length == 0){
							$(this).parents().find('.modal').modal('hide');
							return;
						} 
						
						$(this).parents().find('.modal').modal('hide');
 
						selectconnectvm.each(function(){ 
							vmidandzonecipid = this.value;
							temp = vmidandzonecipid.split('/');
							vmid = temp[0];
							zonecipid = temp[1]; 
// 	 						alert(vmid);
// 	 						alert(zonecipid);	 						
							$.ajax({
								type:'GET',
								url:'/naslist/addNicToVirtualMachine/'+zonecipid+'/'+vmid,
								dataType: 'json',
								success : function(data){
// 									showObj(data);
									 if(data.jobid){
									 	async(data.jobid,'CONNECT CIP');
									 }else{
										setModalMsg('CONNECT CIP 실패').modal();
									 } 
								},
								error : function( ){  
									 setModalMsg('CONNECT CIP 실패(error)').modal();
								}
							}); 
						}); //체크된 것들 모두 connect 실행 
					}
			); 
});  
</script>

<!-- disconnect cip modal  -->
<div class="modal fade" id='connectcipModal' role="dialog">
  <div class="modal-dialog">
	  <div class="modal-content">
	      <div class="modal-header"> 
	        <h4 class="modal-title">NAS cip 연결</h4>
	      </div>
	      <div class="modal-body"> 
	        <table id="connectcipserverlist_table"> 
			   		<thead>
				   		<tr>
				   			<th>선택</th>
				   			<th>Zone</th>
				   			<th>서버명</th>
				   			<th>운영체제</th>
				   			<th>스펙</th>
				   			<th>상태</th>
				   			<th>그룹</th>
				   		</tr>
			   		</thead>
			   		<tbody>
			   		</tbody>
			 	</table>  
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	         <input type="button" class="btn btn-primary" id="connectciporderbtn"class="btn" value="확인"/>
	      </div>
	    </div> 
	</div>
</div>