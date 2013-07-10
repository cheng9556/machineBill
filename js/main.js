/**
 * WRITED BY LEO AT 2011/2/1
 */
(function($) {
	$.fn.loadingModalShow = function(fn){
		$loadingModal = jQuery('<div class="loadingModal" style="display:none;position:absolute;top:'
				+ this.position().top
				+ 'px;left:'
				+ this.position().left
				+ 'px;width:'
				+ this.width()
				+ 'px;height:'
				+ this.height()
				+ 'px;z-index: 50;padding-top:'
				+ this.css("padding-top")
				+ ';padding-right:'
				+ this.css("padding-right")
				+ ';padding-bottom:'
				+ this.css("padding-bottom")
				+ ';padding-left:'
				+ this.css("padding-left")
				+ '; text-align: center;vertical-align: middle;color: #000;background: #aaaaaa url(/images/bg.png) 50% 50% repeat-x; opacity: .70;filter:Alpha(Opacity=70);"><div>正在加载,请稍等... ...<img src="/images/loader.gif"></img></div></div>');
		$(this).append($loadingModal).find(".loadingModal").slideDown("slow", fn);// callback function
		return this;
	};
	$.fn.loadingModalHide = function(fn) {
		$(this).find(".loadingModal").slideUp("slow", function(){
					$(this).remove();
					fn;// callback function
				});
	};
})(jQuery);
var operateChange = 0;
function collapseAll(){
	var node = $('#tt').treegrid('getSelected');
	if (node){
		$('#tt').treegrid('collapseAll', node.code);
	} else {
		$('#tt').treegrid('collapseAll');
	}
}
function expandAll(){
	var node = $('#tt').treegrid('getSelected');
	if (node){
		$('#tt').treegrid('expandAll', node.code);
	} else {
		$('#tt').treegrid('expandAll');
	}
}
function addProvince(){
	$(".note").hide();
	$('#addProvinceForm').form('clear');
	$("input[name='serverActualNumber']").val(0);
	$('#addProvince').window('open');
	operateChange = 0;
}
function editProvince(){
	$(".note").hide();
	$("#editProvinceForm").hide();
	$('#editProvince').window('open');
	operateChange = 0;
}
function delProvince(){
	$(".note").hide();
	$('#delProvince').window('open');
	operateChange = 0;
}
function addServer(){
	$(".note").hide();
	$('#addServer').window('open');
	operateChange = 0;
}
function editServer(){
	$(".note").hide();
	$("#editServerForm").hide();
	$('#selectEditServer').combotree('setValue','');
	$('#editServer').window('open');
	operateChange = 0;
}
function delServer(){
	$(".note").hide();
	$("#delServer .submit").hide();
	$('#selectDelServer').combotree('setValue','');
	$('#delServer').window('open');
	operateChange = 0;
}

function addProvinceFormSubmit(){
	$("#addProvince .note").slideUp("slow");
	$("#addProvince").loadingModalShow(function(){
		var d = $("#addProvinceForm").serialize(); 
		$.ajax({
			   type: "POST",
			   url: "addProvince.php",
			   data: d,
			   cache: false,
			   success: function(data, textStatus){
				   $("#addProvince .note").html(data).slideDown("slow");
					//$(".provinceList").combobox('reload');
				   provinceListReload();
					operateChange = 1;
			   },
			   error: function(XMLHttpRequest, textStatus, errorThrown){
				   $("#addProvince .note").html("请求出现错误:"+textStatus).slideDown("slow");
			   },
			   complete: function(XMLHttpRequest, textStatus){
				   $("#addProvince").loadingModalHide();
			   }
			});
	});
}
function editProvinceFormSubmit(){
	$("#editProvince .note").slideUp("slow");
	$("#editProvince").loadingModalShow(function(){
		var d = $("#editProvinceForm").serialize(); 
		$.ajax({
			   type: "POST",
			   url: "editProvince.php",
			   data: d,
			   cache: false,
			   success: function(data, textStatus){
				   $("#editProvince .note").html(data).slideDown("slow");
				   operateChange = 1;
			   },
			   error: function(XMLHttpRequest, textStatus, errorThrown){
				   $("#editProvince .note").html("请求出现错误:"+textStatus).slideDown("slow");
			   },
			   complete: function(XMLHttpRequest, textStatus){
				   $("#editProvince").loadingModalHide();
			   }
			});
	});
}
function delProvinceFormSubmit(){
	$("#delProvince .note").slideUp("slow");
	var p = $("#selectDelProvince").combobox('getValue'),
		pname = $("#selectDelProvince").combobox('getText');
	$("#delProvince").loadingModalShow(function(){
	$.ajax({
		   type: "POST",
		   url: "delProvince.php",
		   data: 'id='+p+'&pname='+pname,
		   cache: false,
		   success: function(data, textStatus){
			   $("#delProvince .note").html(data).slideDown("slow");
			   $('#selectDelProvince').combobox('setValue','');
			   //$(".provinceList").combobox('reload');
			   provinceListReload();
			   operateChange = 1;
		   },
		   error: function(XMLHttpRequest, textStatus, errorThrown){
			   $("#delProvince .note").html("请求出现错误:"+textStatus).slideDown("slow");
		   },
		   complete: function(XMLHttpRequest, textStatus){
			   $("#delProvince").loadingModalHide();
		   }
		});
	});
}
function addServerFormSubmit(){
	$("#addServer .note").slideUp("slow");
	$("#addServer").loadingModalShow(function(){
	var d = $("#addServerForm").serialize();
	$.ajax({
		   type: "POST",
		   url: "addServer.php",
		   data: d,
		   cache: false,
		   success: function(data, textStatus){
			   $("#addServer .note").html(data).slideDown("slow");
			   //$(".serverList").combotree('reload');
			   serverListReload();
			   operateChange = 1;
		   },
		   error: function(XMLHttpRequest, textStatus, errorThrown){
			   $("#addServer .note").html("请求出现错误:"+textStatus).slideDown("slow");
		   },
		   complete: function(XMLHttpRequest, textStatus){
			   $("#addServer").loadingModalHide();
		   }
		});
	});
}
function editServerFormSubmit(){
	$("#editServer .note").slideUp("slow");
	$("#editServer").loadingModalShow(function(){
	var d = $("#editServerForm").serialize(),
		sname = $('#selectEditServer').combotree('tree').tree('getSelected').text;
	$.ajax({
		   type: "POST",
		   url: "editServer.php",
		   data: d+'&sname='+sname,
		   cache: false,
		   success: function(data, textStatus){
			   $("#editServer .note").html(data).slideDown("slow");
			   operateChange = 1;
		   },
		   error: function(XMLHttpRequest, textStatus, errorThrown){
			   $("#editServer .note").html("请求出现错误:"+textStatus).slideDown("slow");
		   },
		   complete: function(XMLHttpRequest, textStatus){
			   $("#editServer").loadingModalHide();
		   }
		});
	});
}
function delServerFormSubmit(){	
	$("#delServer .note").slideUp("slow");
	$("#delServer").loadingModalShow(function(){
	var d = $('#selectDelServer').combotree('tree').tree('getSelected').id,
		dname = $('#selectDelServer').combotree('tree').tree('getSelected').text;
	if( d == undefined || dname == undefined ){
		$("#delServer .note").html('请明确选择要编辑的机器').slideDown("slow");
		return;
	}
	$.ajax({
		   type: "POST",
		   url: "delServer.php",
		   data: 'id='+d+'&dname='+dname,
		   cache: false,
		   success: function(data, textStatus){
			   $("#delServer .note").html(data).slideDown("slow");
			   $('#selectDelServer').combotree('setValue','');
			   //$(".serverList").combotree('reload');
			   serverListReload();
			   operateChange = 1;
		   },
		   error: function(XMLHttpRequest, textStatus, errorThrown){
			   $("#delServer .note").html("请求出现错误:"+textStatus).slideDown("slow");
		   },
		   complete: function(XMLHttpRequest, textStatus){
			   $("#delServer").loadingModalHide();
		   }
		});
	});
}

$.extend($.fn.validatebox.defaults.rules, {
    minLength: {
        validator: function(value, param){
            return value.length >= param[0];
        },
        message: '请至少输入 {0} 字符.'
    },
    number: {
        validator: function (value, param) {
            return /^\d+$/.test(value);
        },
        message: '请输入数字.'
    }
});

// ///////Flot Start
// hard-code color indices to prevent them from shifting as
// countries are turned on/off
var provinceData=[];
var datasets=[];
var bars = true, lines = false;

function plotAccordingToChoices() {
	var data = [];
	$("#choices").find("input:checked").each(function () {
		var key = $(this).attr("name");
		if (key && datasets[key])
			data.push(datasets[key]);
	});
	if (data.length > 0)
		$.plot($("#placeholder"), data, {
			legend: { 
        // 	noColumns: 2,
				margin: [-120,5] 
			},
			yaxis:  { 
				min: 0,
        // 	autoscaleMargin: 0.2,
				labelWidth: 10,
				tickDecimals:0,
				tickSize: 1 
			},
			xaxis:  {
				min: 0 ,
				tickDecimals:0,
				ticks: provinceData
			},
			series: {
				lines:  { show: lines },
				bars:   { show: bars, barWidth: 0.5,align:"center" },                      
				points: { show: true }
			},
			grid:   { hoverable: true ,clickable: true}
		});
}
	
function showTooltip(x, y, contents) {
	$('<div id="tooltip">' + contents + '</div>').css( {
		position: 'absolute',
		display: 'none',
		top: y + 5,
		left: x + 5,
		border: '1px solid #fdd',
		padding: '2px',
		'background-color': '#fee',
		opacity: 0.80
	}).appendTo("body").fadeIn(200);
}

var colorVar = 2;
function changeColor(){
	if(colorVar > 20){
		colorVar = 1;
	}	
	reloadFlot();
}

function reloadFlot(){
		$.ajax({
			   type: "GET",
			   url: "/FlotData.php",
			   cache: false,
			   dataType: "script",
			   beforeSend: function(){
				   $("#placeholder").loadingModalShow(); 
			   },
			   success: function(data, textStatus){
				   var i = colorVar;
			        $.each(datasets, function(key, val) {
			            val.color = i;
			            i++;
			        });
			        colorVar = i;
			        // insert checkboxes
			        var choiceContainer = $("#choices");
			        choiceContainer.html("显示:");
			        $.each(datasets, function(key, val) {
			            choiceContainer.append('<br/><input type="checkbox" name="' + key +
			                                   '" checked="checked" id="id' + key + '">' +
			                                   '<label for="id' + key + '">'
			                                    + val.label + '</label>');
			        });
			        choiceContainer.find("input").click(plotAccordingToChoices);
			    	 plotAccordingToChoices();
			    	 
			    	var previousPoint = null;
			    	$("#placeholder").bind("plothover", function (event, pos, item) {
			    		$("#x").text(pos.x.toFixed(2));
			    		$("#y").text(pos.y.toFixed(2));
			    		if(item){
			    			if (previousPoint != item.datapoint) {
			    				previousPoint = item.datapoint;
			    	        
			    				$("#tooltip").remove();
			    				var x = item.datapoint[0].toFixed(0),
			    	            	y = item.datapoint[1].toFixed(0);
			    				showTooltip(item.pageX, item.pageY,item.series.label + " " + y);
			    			}
			    		}
			    		else {
			    			$("#tooltip").remove();
			    			previousPoint = null;            
			    		}
			    	});
			   },
			   error: function(XMLHttpRequest, textStatus, errorThrown){
				   $.messager.alert('错误','图表数据加载失败。请稍后再试。','error');
			   },
			   complete: function(XMLHttpRequest, textStatus){
				   $("#placeholder").loadingModalHide();
			   }
			});	
}

function provinceListReload(){
	$.ajax({
		   type: "GET",
		   url: "/provinceListJson.php",
		   cache: false,
		   dataType: "json",
		   success: function(data, textStatus){
			   $(".provinceList").combobox({
					//url:'provinceListJson.php',
			   		"data":data,
					valueField:'id',
					textField:'provinceName',
					panelHeight:"300",
					editable: false
				});
		   },
		   error: function(XMLHttpRequest, textStatus, errorThrown){
				$.messager.show({
					title:'错误',
					msg:'省份列表数据加载失败，你将不能编辑省份数据.',
					timeout:10000,
					showType:'slide'
				});
		   }
		});	
}

function serverListReload(){
	$.ajax({
		   type: "GET",
		   url: "/serverListJson.php",
		   cache: false,
		   dataType: "json",
		   success: function(data, textStatus){
			$(".serverList").combotree({
				//url:'serverListJson.php',
				"data":data,
				valueField:'id',
				textField:'text',
				panelHeight:"300",
				editable: false
			});
		   },
		   error: function(XMLHttpRequest, textStatus, errorThrown){
				$.messager.show({
					title:'错误',
					msg:'服务器列表数据加载失败，你将不能编辑服务器数据.',
					timeout:10000,
					showType:'slide'
				});
		   }
		});		
}

$(function() {
	////////////////////flot/////////////////////
    $(".graphControls .tuxing").click(function (e) {
        e.preventDefault();
        bars = $(this).attr("id").indexOf("Bars") != -1;
        lines = $(this).attr("id").indexOf("Lines") != -1;  
        plotAccordingToChoices();
    });
    reloadFlot();
    $("#changeColor").click(function(){
    	changeColor();
    	return false;
    });
    /////////////////////////////////////////////
    var ttheight = $(window).height() - 150;
	$('#tt').treegrid({
		rownumbers : false,
		remoteSort : false,
		nowrap : false,
		fitColumns : true,
		height: ttheight,
		animate:true,
		collapsible:true,
		striped: true,		
		loadMsg : "正在加载数据，请稍等... ...",
		treeField:'province',
		idField:'id',
		url : '/treeGridJson.php',
		// frozenColumns:[[
		// ]],
		columns : [ [
		{
			title:'省份',
			field:'province',
			width:300,
			formatter:function(value,rowData,rowIndex){
				  if((rowData.ping=='否')||(rowData.login=='否')){
					  return '<span style="color:red">'+value+'</span>';
				  }
					return value;
			 }
		},{
			field : 'area',
			title : '放置地点',
			width : 60,
			align : 'center'
		}, {
			field : 'ip',
			title : 'IP地址',
			width : 100,
			align : 'center'
		}, {
			field : 'ping',
			title : '能ping通',
			width : 40,
			align : 'center',
			formatter:function(value,rowData,rowIndex){
				  if(value=='否'){
					  return '<span style="color:red">'+value+'</span>';
				  }
					return value;
			 }
		}, {
			field : 'login',
			title : '能登录',
			width : 40,
			align : 'center',
			formatter:function(value,rowData,rowIndex){
				  if(value=='否'){
					  return '<span style="color:red">'+value+'</span>';
				  }
					return value;
			 }
		}, {
			field : 'proxylogin',
			title : '使用跳板',
			width : 40,
			align : 'center'
		}, {
			field : 'eth',
			title : '分光网卡',
			align : 'center',
			width : 250
		}, {
			field : 'remarks',
			title : '备注',
			align : 'center',
			width : 200,
			formatter:function(value,rowData,rowIndex){
				  if((rowData.ping=='否')||(rowData.login=='否')){
					  return '<span style="color:red">'+value+'</span>';
				  }
					return value;
			 }
		} ] ],
		onLoadSuccess: function(){
			// expandAll();
			// collapseAll();
			$.messager.show({
				title:'提示',
				msg:'最新数据加载成功。',
				timeout:5000,
				showType:'slide'
			});
		},
		onLoadError: function(){
			$.messager.alert('错误','表格数据加载失败。请刷新页面重试。','error');
		},
		onContextMenu: function(e,row){
			e.preventDefault();
			$(this).treegrid('unselectAll');
			$(this).treegrid('select', row.code);
			$('#mm').menu('show', {
				left: e.pageX,
				top: e.pageY
			});
		}
	});
	
	provinceListReload();
	serverListReload();
	$(".note").hide();
	$("#editProvinceForm").hide();
	$("#editServerForm").hide();
	$("#selectEditProvince").combobox({
		onSelect:function(){
			$("#editProvince .note").slideUp("slow");
			var p = $(this).combobox('getValue');
			$("#editProvinceForm").form('load','/editProvinceJson.php?action=edit&id='+p).fadeIn("slow");
		}
	});
	$('#selectEditServer').combotree({
		onSelect:function(){
			$("#editServer .note").slideUp("slow");
			var p = $('#selectEditServer').combotree('tree').tree('getSelected').id;
			if( p == undefined){
				$("#editServer .note").html('请明确选择要编辑的机器').slideDown("slow");
				$("#editServerForm").fadeOut('slow');
				return;
			}
			$("#editServerForm").form('load','/editServerJson.php?action=edit&id='+p).fadeIn("slow");
		}
	});
	$('#selectDelServer').combotree({
		onSelect:function(){
			$("#delServer .note").slideUp("slow");
			$('#delServer .submit').hide();
			var p = $('#selectDelServer').combotree('tree').tree('getSelected').id;
			if( p == undefined ){
				$("#delServer .note").html('请明确选择要编辑的机器').slideDown("slow");
				return;
			}
			$('#delServer .submit').fadeIn('slow');
		}
	});
	$(".reloadtable").window({
		onClose: function(){
			if(operateChange){
			$('#ttdiv').loadingModalShow(function(){
				$('#tt').treegrid('reload');
				$("#ttdiv").loadingModalHide();
				reloadFlot();
			});
			}
		}
	});
});
