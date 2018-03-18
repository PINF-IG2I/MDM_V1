	var tabDocs;
	$(document).ready(function(){

		//When the user wants to leave the edit box
		// $("#leaveEdit").click(function() {
		// 	$("#editDoc").dialog('close');
		// });

		//When the language is changed
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

		//When the user wants to display results of the search
		$("#send").click(function(){
			var oQuery={};
			$("#headerSearch input").each(function(){
				var key= $(this).attr("name");
				var value=$(this).val();
				if(value!="")
					oQuery[key]=value;
			});
			$("#headerSearch select").each(function(){
				var key= $(this).attr("name");
				var value=$(this).val();
				if(value!=null){
					oQuery[key]=value;

				}
			});
			if(!$.isEmptyObject(oQuery)){
				$.getJSON( "controleur.php",
				{
					"action":"Search",
					"data":oQuery
				},
				function(oRep){	
					console.log(oRep);
					if(oRep.length!=0) {
					tabDocs=oRep;
						var oTable = $("<table>").attr("class","table table-hover");
						oTable.append("<thead><tr><th>Id</th><th></th><th>Language</th><th>Name</th><th>Subject</th><th>Site</th><th>Responsible</th><th>Status</th><th>Component</th><th>Subsystem</th></tr></thead><tbody id='tableResults'>");
						$.each(oRep,function(i,val) {
							var oRow = $("<tr id='" + val["id_doc"] + "'>").attr({"data-toggle":"modal","data-target":"#editDoc"}).on("click",editDocu);
							oRow.append("<th>" + val["id_doc"]+ "</th><th>" + val["version"] + "</th><th>"
								+ val["language"] + "</th><th>" + val["name"] + "</th><th>" + val["subject"] + "</th><th>"
								+ val["site"] + "</th><th>" + val["pic"] + "</th><th>" + val["status"] + "</th><th>" 
								+ val["component_name"] + "</th><th>" + val["subsystem_name"] + "</th></tr>");
							oTable.append(oRow);
						});
						oTable.append("</tbody></table");

						$("#results").html(oTable);
						$("#exportButton").show();
						$("#searchValues").attr("value",JSON.stringify(oRep));
					}
					else 
						$("#results").html("No results found");
				}
				);
			}
		});

		//When a document is deleted


		//When a document is changed


		//Popup box that displays when a user clicks on a document
		// $('#editDoc').dialog({
		// 	autoOpen:false,
		// 	width:1200,
		// 	modal:true
		// });
		// $("#editDoc").dialog('close');


		
		
	});