/**
* \file utils.js
* \brief This page is the one that handles the HTML document manipulation and traversal
* It also includes some event handling and Ajax, to send data to the controller
* \author TOPINF team
* \version 1.0
*/

var tabDocs;
$(document).ready(function(){

		// NAVIGATION BAR ///////////////////////////////////////////////////////

		// When the language is changed in the navigation bar
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

		// When the manager or administrator wants to add a baseline
		$("#baseline").click(function() {
			var oQuery={};
			// Every input from the user is stored into oQuery
			$("#newBaseline input").each(function(){
				var key= $(this).attr("name");
				var value=$(this).val();
				if(value!="")
					oQuery[key]=value;
			});
			$("#newBaseline select").each(function(){
				var key= $(this).attr("name");
				var value=$(this).val();
				if(value!=null){
					oQuery[key]=value;

				}
			});
			JSON.stringify(oQuery);
			// Then, the data is sent to the controller
			if(!$.isEmptyObject(oQuery)){
				$.getJSON("controleur.php",
				{
					"action":"addBaseline",
					"data":oQuery
				},
				function(){
				});
				$("#newBaseline").modal('toggle');
				location.reload();
			}
		});

		// When the manager or administrator wants to add a document
		// The process is the same as the Add Baseline event
		$("#document").click(function() {
			var oQuery={};
			$("#newDocument input").each(function(){
				if($(this).is(':checkbox')){
					if($(this).prop('checked')== true)
						var value=1;
					else
						var value=0;
				}
				else 
					var value=$(this).val();
				var key= $(this).attr("name");
				if(value!="")
					oQuery[key]=value;
			});
			$("#newDocument select").each(function(){
				var key= $(this).attr("name");
				var value=$(this).val();
				if(value!=null){
					oQuery[key]=value;

				}
			});
			if(!$.isEmptyObject(oQuery)){
				$.getJSON("controleur.php",
				{
					"action":"addDocument",
					"data":oQuery

				},
				function(){	
				});
				$("#newDocument input").each(function(){
					$(this).val("");
				});
				$("#newDocument").modal('toggle');
			}
		});


		// ADMINISTRATION PAGE ///////////////////////////////////////////////////////

		// When the users wants to display results of the user search
		$("#searchUser").click(function() {
			$.getJSON("controleur.php",
			{
				"action":"SearchUser",
				"userName":$("#userName").val()
			},
			// The controller sends back the possible user(s)
			// And the array is updated
			function(oRep) {
				$("#tabUsers").data("users",oRep);
				$("tr[data-toggle=modal]").remove();
				$.each(oRep,function(i,val) {
					var oRow = $("<tr id='" + val["id_user"] + "'>").attr({"data-toggle":"modal","data-target":"#editUser","onClick":"editUser(this)"}).css("cursor","pointer");
					oRow.append("<td>" + val["id_user"] + "</td><td>" + val["last_name"] + "</td><td>" 
						+ val["first_name"] + "</td><td>" + val["status"] + "</td><td>" 
						+ val["language"] + "</td>");
					if(val["isConnected"]==1)
						oRow.append("<td>" + val["isConnected"]+"<a href='controleur.php?action=forceLogout&id="+val["id_user"]+"' ><button type='button' class='btn-danger' id='disconnect'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button></a></td>");
					else
						oRow.append("<td>"+val["isConnected"]);
					oRow.append("</td>");
					$("#usersResult").append(oRow);
				})
			});
		});

		// When a user imports some data
		$('#upload').on("change",function(){
			// File informations
			var file = $("#file")[0].files[0];
			var formData = new FormData();
			formData  = {
				'action':'importDB',
				'file_name' : ($("#file")[0].files[0]).name,
				'file_type' : ($("#file")[0].files[0]).type
			};
			$.ajax({
				type:'POST',
				url:'controleur.php',
				data:formData,
				dataType:'json',
				encode:true
			});
		});

		// DOCUMENT DETAILS ///////////////////////////////////////////////////////

		// When the manager or administrator wants to edit the document
		$("#changeDoc").click(function() {
			var oQuery={};
			// Every input, checkbox or textarea is stored in oQuery
			$("#editDoc input").each(function(){
				if($(this).is(':checkbox')){
					if($(this).prop('checked')== true)
						var value=1;
					else
						var value=0;
				}
				else
					var value=$(this).val();
				var key= $(this).attr("name");
				oQuery[key]=value;
			});
			oQuery["remarks"]=$("#editDoc textarea").val();

			// Then the data is sent to the controller
			if(!$.isEmptyObject(oQuery)){
				$.getJSON( "controleur.php",
				{
					"action":"updateDoc",
					"data":oQuery
				},
				function(oRep){	
					if(oRep.length!=0) {
					}
				}
				);
				$("#send").trigger('click');
			}
		});

		// When an option is selected in the status dropdown
		$("#statusDoc").on('click','li a',function() {
			// The value is displayed
			$("#displayStatus").val($(this).html());
		})
		

		// SEARCH PAGE ///////////////////////////////////////////////////////

		// When the user wants to display results of the search
		$("#send").click(function(){
			var oQuery={};
			// Once again, every input is stored into oQuery
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
					$("#hiddenTab table tbody").remove();	
					if(oRep.length!=0) {
						tabDocs=oRep;
						//$("#hiddenTab table").append("<tbody id='tableResults'>");
						var oResult=$("<tbody id='tableResults'>");
						// Every matching document is displayed in an array below the form
						$.each(oRep,function(i,val) {
							var language="";
							if(val["language"]!="") language=val["language"];
							else language= val ["initial_language"];
							var oRow = $("<tr id='" + val["id_doc"] + "'>").attr({"data-toggle":"modal","data-target":"#editDoc"}).on("click",editDocu);
							oRow.append("<th>" + val["id_doc"]+ "</th><th>" + val["version"] + "</th><th>"
								+ language + "</th><th>" + val["reference"] + "</th><th>" + val["subject"] + "</th><th>"
								+ val["site"] + "</th><th>" + val["pic"] + "</th><th>" + val["status"] + "</th><th>" 
								+ val["component"] + "</th><th>" + val["product"] + "</th></tr>");
							oResult.append(oRow);
						});
						oResult.append("</tbody>");
						$("#hiddenDiv").hide();
						$("#hiddenTab").show();
						$("#hiddenTab table").append(oResult);
						$("#exportButton").show();
						$("#searchValues").attr("value",JSON.stringify(oRep));
					}
					else{ 
						$("#hiddenDiv").show();
						$("#hiddenTab").hide();
					}
				}
				);
			}
		});
	});