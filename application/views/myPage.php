<span style="display:none" id="where" >cloudlist</span>
 
<!-- 서버검색하기 -->
	<div class="container-fluid">
		<div class="row-fluid" >
			<div class="span12"  >
				<h5>내 정보</h5>
				<table class='table'>
					<thead>
						<tr>
							<th>계정ID / id</th>
							<th>계정이름 / name</th>
							<th>사용중인 공인 IP 총 수 /  iptotal</th>
							<th>	저장된 스냅샷의 총수/snapshottotal</th>
							<th>	계정 상태 state	</th>
							<th>사용 중인 템플릿의 총수 templatetotal</th>
							<th>	동작중인VM 총수 vmrunning	</th>
							<th>정지된 VM 총수  vmstopped</th>
							<th>사용중인 VM 총수 vmtotal</th>
							<th>사용중인 볼륨 총수 volumetotal	</th>
							<th>apikey user,apikey</th>
							<th>secretkey user.secretkey</th>
						</tr>
					</thead>
				</table>
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
});  
</script>
