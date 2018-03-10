	$(document).ready(function(){
		$("#selectLanguage").change(function(){
			$.ajax({
				url : "controleur.php",
				data : {
					'action' : 'changeLanguage',
					'language' : $("#selectLanguage option:selected").val()
				},
				success : location.reload()
			});
		});
		$("#send").click(function(){
			var oQuery={};
			$("#headerSearch input").each(function(){
				var key= $(this).attr("name");
				var value=$(this).val();
				if(value!="")
					oQuery[key]=value;
				console.log(oQuery);
			});
			$("#headerSearch select").each(function(){
				var key= $(this).attr("name");
				var value=$(this).val();
				console.log(key);
				console.log(value);
				if(value!=null){
					oQuery[key]=value;
					console.log(oQuery);

				}
			});
			console.log(oQuery);
			if(!$.isEmptyObject(oQuery)){
				$.getJSON( "controleur.php",
				{
					"action":"Search",
					"data":oQuery
				},
				function(oRep){	
					console.log(oRep);
					if(oRep.length!=0)
						$("#results").html(JSON.stringify(oRep));
					else 
						$("#results").html("No results found");
				}
				);
			}
		});
	});