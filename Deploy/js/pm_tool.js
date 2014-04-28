$(document).ready(function () {
	$("#recordSect").hide();
	$.ajax({type: "GET", url: "xml/NavigationSettings.xml", dataType: "xml", success: xmlParserNav});
});

function xmlParserNav(xml) {
	$(xml).find("NavigationTool").each(function () {
		if ($(this).attr("enabled") == "true") {
			//Create the Navigation section of the page
			/*This code creates the Navigation section of the page.  Each function in Navigation has a Section header div which contains an icon div and a title div.  Below the section header there is a view div for each of the views available in each section.  The view divs each also contain an icon div and a title div.  The ids for each element are set to the id from the settings file, pre-pended with a 2 character code for the element.  For example, a nav tool with id 100 will have Section div sd100; Section header sh100; Icon div hi100; Icon image im100; Title div ti100.  Gets the Tool Name and Tool Icon from the xml*/
			var titleTxt = $(this).children("Name").text(), imgLoc = $(this).children("Icon").text(), idNum = $(this).attr("recId"), recSectVis = $(this).attr("recListVisible"),appendTxt = "<div id='sd" + idNum + "' class='navSection'></div>";
			/*Create the Navigation Section for this tool as a DIV element.  The id for the element will be 'navTOOL' where TOOL is the Name
			The class will be 'navSection'*/
			$("#navigation").append(appendTxt);
			//Create the Section Header element
			appendTxt = "<div id='sh" + idNum + "' class='navSectHdr'></div>";
			$("#sd" + idNum + "").append(appendTxt);
			//Create a div for the Icon portion of the section header
			appendTxt = "<div id='hi" + idNum + "' class='navSectHdrIco'></div>";
			$("#sh" + idNum + "").append(appendTxt);
			//Create the IMG element for the Section Icon
			appendTxt = "<img id='im" + idNum + "' class='svg navIcon' src='" + imgLoc + "' alt='" + titleTxt + "'></img>";
			$("#hi" + idNum + "").append(appendTxt);
			//Create a div for the text portion of the section header
			appendTxt = "<div id='ti" + idNum + "' class='navSectHdrTitle'>" + titleTxt + "</div>";
			$("#sh" + idNum + "").append(appendTxt);
			appendTxt = "<div id='rsv" + idNum + "' class='rsv'>" + recSectVis + "</div>";
			$("#sh" + idNum + "").append(appendTxt);
			$(".rsv").hide();
			//Loop thru the views and create DIVs for each view
			$(this).find("ToolView").each(function() {
				//If the view is disabled, skip it
				if($(this).attr("enabled")=="true") {
					//Get the view Title and Id
					var vwTitleTxt = $(this).find("Name").text(), vwIdNum = $(this).attr("recId"), vwURL = $(this).find("ReferenceURL").text(), vwRecEle = $(this).find("RecEle").text(), vwPrimEle = $(this).find("PrimEle").text(), vwSecEle = $(this).find("SecEle").text(), vwTerEle = $(this).find("TerEle").text(), vwFiltEle = $(this).find("FilterEle").text(), vwGrpEle = $(this).find("GroupEle").attr("gID"), vwSrtEle = $(this).find("SortEle").text(), vwGrpLUE = $(this).find("GroupEle").attr("luElem"), vwGrpLUA = $(this).find("GroupEle").attr("luAttr");
					imgLoc = $(this).find("Icon").text();
					//Create the View div
					appendTxt = "<div id='vw" + vwIdNum + "' class='navItem'></div>";
					$("#sd"+ idNum +"").append(appendTxt);
					//Insert the definitional information divs
					appendTxt = "<div class='lu' id='ReferenceURL" + vwIdNum + "'>" + vwURL + "</div>";
					$("#vw"+ vwIdNum +"").append(appendTxt);
					appendTxt = "<div class='lu' id='RecEle" + vwIdNum + "'>" + vwRecEle + "</div>";
					$("#vw"+ vwIdNum +"").append(appendTxt);
					appendTxt = "<div class='lu' id='PrimEle" + vwIdNum + "'>" + vwPrimEle + "</div>";
					$("#vw"+ vwIdNum +"").append(appendTxt);
					appendTxt = "<div class='lu' id='SecEle" + vwIdNum + "'>" + vwSecEle + "</div>";
					$("#vw"+ vwIdNum +"").append(appendTxt);
					appendTxt = "<div class='lu' id='TerEle" + vwIdNum + "'>" + vwTerEle + "</div>";
					$("#vw"+ vwIdNum +"").append(appendTxt);
					appendTxt = "<div class='lu' id='FiltEle" + vwIdNum + "'>" + vwFiltEle + "</div>";
					$("#vw"+ vwIdNum +"").append(appendTxt);
					appendTxt = "<div class='lu' id='GrpEle" + vwIdNum + "'>" + vwGrpEle + "</div>";
					$("#vw"+ vwIdNum +"").append(appendTxt);
					appendTxt = "<div class='lu' id='GrpLUE" + vwIdNum + "'>" + vwGrpLUE + "</div>";
					$("#vw"+ vwIdNum +"").append(appendTxt);
					appendTxt = "<div class='lu' id='GrpLUA" + vwIdNum + "'>" + vwGrpLUA + "</div>";
					$("#vw"+ vwIdNum +"").append(appendTxt);
					appendTxt = "<div class='lu' id='SortEle" + vwIdNum + "'>" + vwSrtEle + "</div>";
					$("#vw"+ vwIdNum +"").append(appendTxt);
					//Create the view icon div
					appendTxt = "<div id='vi" + vwIdNum + "' class='navItemIco'></div>";
					$("#vw"+ vwIdNum +"").append(appendTxt);
					//Create the icon img
					appendTxt = "<img id='ic" + vwIdNum + "' class='svg navItemIcon' src='" + imgLoc + "' alt='" + titleTxt + "'></img>";
					$("#vi"+ vwIdNum +"").append(appendTxt);
					//Create the view text div
					appendTxt = "<div id='vt" + vwIdNum + "' class='navItemTitle'>" + vwTitleTxt + "</div>";
					$("#vw"+ vwIdNum +"").append(appendTxt);
					if($(this).parent().attr("collapsed")=="true"){$("#vw"+ vwIdNum +"").hide();}
					$(".lu").hide();
					}
				});
			}
		/*Replace all SVG images with inline SVG*/
		jQuery('img.navItemIcon,img.navIcon').each(function(){
			var $img = jQuery(this), imgID = $img.attr('id'), imgClass = $img.attr('class'), imgURL = $img.attr('src');
			jQuery.get(imgURL, function(data) {
				// Get the SVG tag, ignore the rest
				var $svg = jQuery(data).find('svg');
				// Add replaced image's ID to the new SVG
				if(typeof imgID !== 'undefined') {
					$svg = $svg.attr('id', imgID);
				}
				// Add replaced image's classes to the new SVG
				if(typeof imgClass !== 'undefined') {
					$svg = $svg.attr('class', imgClass+' replaced-svg');
				}
				// Remove any invalid XML tags as per http://validator.w3.org
				$svg = $svg.removeAttr('xmlns:a');
				// Replace image with new SVG
				$img.replaceWith($svg);
			}, 'xml');
		});
	});
	$(".navSectHdr").click(function() {
		var idTxt = this.id;
		if ($(this).children(".rsv").first().text() == 'true'){$("#recordSect").show();}
		else {$("#recordSect").hide();}
		$(".navSectHdrActive").removeClass("navSectHdrActive").addClass("navSectHdr");
		$(".navSectHdrSubActive").removeClass("navSectHdrSubActive").addClass("navSectHdr");
		$(".navItemActive").removeClass("navItemActive").addClass("navItem");
		$(".navItem").hide();
		$(this).addClass("navSectHdrActive");
		$("#"+idTxt+"").parent().find(".navItem").each(function() {
			$(this).show();
			});
		});
	$(".navItem").click(function() {
		var idTxt = this.id;
		$(".navSectHdrActive").removeClass("navSectHdrActive").addClass("navSectHdrSubActive");
		$(".navItemActive").removeClass("navItemActive").addClass("navItem");
		$("#"+idTxt+"").removeClass("navItem").addClass("navItemActive");
		$("#recordList").empty();
		if($("#"+idTxt.replace('vw','ReferenceURL')+"").get(0)){
			$.ajax({
				type: "GET",
				url: $("#"+idTxt.replace('vw','ReferenceURL')+"").text(),
				dataType: "xml",
				success: xmlParserRecords
				});
			}
		});
	}
function xmlParserRecords(xml) {
	var selElem = $(".navItemActive").first().attr("id"), recNav = [], refElem, recElem, primElem, secElem, terElem, filtElem, grpElem, srtElem, grpLUE, grpLUA;
	$("#" + selElem + "").children(".lu").each(function () {
		var rType = $(this).attr("id");
		rType = rType.substring(0,rType.length - 3);
		recNav.push([rType, $(this).text()]);
		if (rType == "ReferenceURL") {refElem = $(this).text();}
		if (rType == "RecEle") {recElem = $(this).text();}
		if (rType == "PrimEle") {primElem = $(this).text();}
		if (rType == "SecEle") {secElem = $(this).text();}
		if (rType == "TerEle") {terElem = $(this).text();}
		if (rType == "FiltEle") {filtElem = $(this).text();}
		if (rType == "GrpEle") {grpElem = $(this).text();}
		if (rType == "GrpLUE") {grpLUE = $(this).text();}
		if (rType == "GrpLUA") {grpLUA = $(this).text();}
		if (rType == "SortEle") {srtElem = $(this).text();}
	});
	//TODO - Add code to incorporate Filtering, Sorting, and Grouping
	//Group Records
	var grps = [];
	$(xml).find(recElem).each(function () {
		var grpID = $(this).find(grpElem).first().text();
		if (grps.indexOf(grpID)==-1) {
			grps.push(grpID);
		}
	});
	grps.sort();
	var gpNames = $(xml).find(grpLUE).children(grpElem).attr(grpLUA).split(';');
	for (i=0;i<grps.length;i++) {
		var nGpIdx = grps[i];
		$("#recordList").append('<div id="g' + grps[i] + '" class="recSect"><div id="gHd' + grps[i] + '" class="recSectHdr"><div class="recSectHdrTitle">' + gpNames[nGpIdx] + '</div></div></div>');
	}
	$(xml).find(recElem).each(function () {
		var issueTitle = $(this).find(secElem).first().text(), issueID = $(this).find(primElem).first().text(),grpID = $(this).find(grpElem).first().text();
		if(issueTitle.length>25){issueTitle = issueTitle.substring(0,21) + '...';}
		$("#g" + grpID + "").append('<div id="r' + issueID + '" class="recItm"><b>' + issueTitle + '</b></div>');
	});
	//alert(recElem + " is the Record Element.  " + primElem + " is the primary Element.");
}