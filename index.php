<?php 
include_once("checklogin.php");
$operator = $_SESSION['operator_user'];
$lastlogin = $_SESSION['lastlogin'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="/favicon.ico" />
<title>machineBill 台帐系统</title>
  <script language="javascript" type="text/javascript" src="/js/jquery-1.4.4.min.js"></script>
  <script language="javascript" type="text/javascript" src="/js/jquery.easyui.min.js"></script>
  <script language="javascript" type="text/javascript" src="/js/jquery.flot.min.js"></script>
  <script language="javascript" type="text/javascript" src="/js/main.js"></script>
  <script language="javascript" type="text/javascript" src="/js/locale/easyui-lang-zh_CN.js"></script>
  <!--[if IE]>
    <script language="javascript" type="text/javascript" src="/js/excanvas.min.js"></script>
  <![endif]-->
  <!--[if lt IE 7]>
    <script language="javascript" type="text/javascript" src="/js/MSIE.PNG.js"></script>
  <![endif]-->
  <link rel="stylesheet" type="text/css" href="/js/themes/gray/easyui.css" />
  <link rel="stylesheet" type="text/css" href="/js/themes/icon.css" />
  <link rel="stylesheet" type="text/css" href="/css/main.css" />
</head>
<body class="easyui-layout">
  <div id="header" region="north" border="false" style="height:70px;background:#FFFFFF;">
  <h1>machineBill 台帐系统</h1>
  <h2>你好<span><?php echo $operator; ?></span>你上次登录时间:<span><?php echo $lastlogin; ?></span></h2>
  <div class="toolbar">
  <a id="addP" href="#" class="easyui-linkbutton" onclick="javascript:addProvince()" iconCls="icon-add">添加省份</a>
  <a id="editP" href="#" class="easyui-linkbutton" onclick="javascript:editProvince()" iconCls="icon-edit">编辑省份</a>
  <a id="delP" href="#" class="easyui-linkbutton" onclick="javascript:delProvince()" iconCls="icon-remove">删除省份</a>
  <a id="addS" href="#" class="easyui-linkbutton" onclick="javascript:addServer()" iconCls="icon-add">添加服务器</a>
  <a id="editS" href="#" class="easyui-linkbutton" onclick="javascript:editServer()" iconCls="icon-edit">编辑服务器</a>
  <a id="delS" href="#" class="easyui-linkbutton" onclick="javascript:delServer()" iconCls="icon-remove">删除服务器</a>
  <a id="collapseAll" href="#" class="easyui-linkbutton" onclick="javascript:collapseAll()">全部收缩</a>
  <a id="expandAll" href="#" class="easyui-linkbutton" onclick="javascript:expandAll()">全部展开</a>
  <a href="logout.php" class="easyui-linkbutton">登出</a>
  </div>
  </div>
  <!-- <div region="west" split="true" title="菜单" style="width:150px;padding:10px;">west content</div>  -->
  <div region="center" title="数据报表"> 
      <div  class="easyui-tabs" fit="true" border="false">
        <div title="图表" icon="icon-ok" style="overflow:hidden;padding:5px;margin-left: 10px;">
            <div id="flot" style="margin-top:20px;position: relative;">
            <div id="placeholder" style="width:800px;height:300px"></div>
                <p class="graphControls">
                <a href="" id="Bars" class="easyui-linkbutton tuxing">柱状图</a>
                <a href="" id="Lines" class="easyui-linkbutton tuxing">线图</a>
                <a href="" id="changeColor" class="easyui-linkbutton">图形变色</a>
               </p>
              <p id="choices"></p>
            </div>
         </div>
        <div title="数据" id="ttdiv"  icon="icon-ok" style="padding:10px;"> 
          <table id="tt"></table>
        <div id="addProvince" class="easyui-window reloadtable" closed="true" modal="true" resizable="false" maximizable="false" minimizable="false" title="添加省份" style="width:300px;height:350px;">
        <div class="note"></div>  
        <form id="addProvinceForm" method="post">
        <table>
          <tr>
            <td>省份名称:</td>
            <td><input class="easyui-validatebox" name="province" required="true" validType="minLength[2]"></td>
          </tr>
         <tr>
          <td>应该提供服务器数量:</td>
          <td><input class="easyui-validatebox" name="serverPlanNumber" required="true" validType="number"></td>
        </tr>
         <tr>
          <td>实际提供服务器数量(只读):</td>
         <td><input class="easyui-validatebox" name="serverActualNumber"  readonly="readonly"></td>
        </tr>
         <tr>
         <td>备注:</td>
         <td><textarea class="easyui-validatebox" name="remarks" style="height:100px;"></textarea></td>
        </tr>
       </table>
       <div class="submit"><a href="#" class="easyui-linkbutton" onclick="javascript:addProvinceFormSubmit()">提交</a></div>
       </form>
       </div>
         <div id="editProvince" class="easyui-window reloadtable" closed="true" modal="true" resizable="false" maximizable="false"  minimizable="false"  title="编辑省份" style="width:300px;height:400px;">
         <div class="selectone">
                      请选择编辑的省份 :         
          <input id="selectEditProvince" class="easyui-combobox provinceList" value="" />
         </div>
         <div class="note"></div>
        <form id="editProvinceForm" method="post">
        <table>       
          <tr>
            <td>省份名称:</td>
            <td><input class="easyui-validatebox" name="province" required="true" validType="minLength[2]"></td>
          </tr>
         <tr>
          <td>应该提供服务器数量:</td>
          <td><input class="easyui-validatebox" name="serverPlanNumber" required="true" validType="number"></td>
        </tr>
         <tr>
          <td>实际提供服务器数量(只读):</td>
         <td><input class="easyui-validatebox" name="serverActualNumber" readonly="readonly" ></td>
        </tr>
         <tr>
         <td>备注:</td>
         <td><textarea class="easyui-validatebox" name="remarks" style="height:100px;"></textarea></td>
        </tr>
       </table>
       <input type="hidden" name="provinceid" value="" />
       <div class="submit"><a href="#" class="easyui-linkbutton" onclick="javascript:editProvinceFormSubmit()">提交</a></div>
       </form>
        </div>
          <div id="delProvince" class="easyui-window reloadtable" closed="true" modal="true" resizable="false" maximizable="false"  minimizable="false" title="删除省份" style="width:300px;height:300px;">
          <div class="selectone" style="padding-top: 10px;">
                           请选择要删除的省份 (警告,删除省份会导致该省份下面的服务器一并删除，请慎重):
          <input id="selectDelProvince" class="easyui-combobox provinceList"  value="" />
          <div class="note"></div>
          <div class="submit" style="margin-top: 30px;"><a href="#" class="easyui-linkbutton" onclick="javascript:delProvinceFormSubmit()">提交</a></div>
          </div>
         </div>
          <div id="addServer" class="easyui-window reloadtable" closed="true" modal="true" resizable="false" maximizable="false"  minimizable="false" title="添加服务器" style="width:300px;height:550px;">
          <div class="note"></div>
          <form id="addServerForm" method="post">
          <table>
          <tr>
            <td>所属省份:</td>
            <td><input name="province" class="easyui-combobox provinceList" required="true" value="" /></td>
          </tr>
          <tr>
            <td>服务器序号:</td>
            <td><input class="easyui-validatebox"  name="serverNumber" required="true" validType="number"></td>
          </tr>
         <tr>
          <td>放置地点:</td>
          <td><input class="easyui-validatebox" name="area" required="true" validType="minLength[2]"></td>
        </tr>
         <tr>
          <td>IP地址:</td>
         <td><input class="easyui-validatebox" name="ip" required="true" validType="minLength[7]"></td>
        </tr>
        <tr>
          <td>是否能Ping通:</td>
         <td>
         <select class="easyui-combobox option1" name="ping" required="true" panelHeight="auto">
           <option value="1">是</option>
          <option value="0">否</option>
        </select>
         </td>
        </tr>
        <tr>
          <td>是否能登陆:</td>
         <td>
         <select class="easyui-combobox option1" name="login" required="true" panelHeight="auto">
           <option value="1">是</option>
          <option value="0">否</option>
        </select>
         </td>
        </tr>
        <tr>
          <td>是否需要跳板:</td>
         <td>
        <select class="easyui-combobox option1" name="proxylogin" required="true" panelHeight="auto">
           <option value="1">是</option>
          <option value="0">否</option>
        </select>
         </td>
        </tr>      
        <tr>
          <td>分光网卡:</td>
         <td><textarea class="easyui-validatebox" name="eth" style="height:100px;" required="true"></textarea></td>
        </tr>  
         <tr>
         <td>备注:</td>
         <td><textarea class="easyui-validatebox" name="remarks" style="height:100px;"></textarea></td>
        </tr>
       </table>
       <div class="submit"><a href="#" class="easyui-linkbutton" onclick="javascript:addServerFormSubmit()">提交</a></div>
       </form> 
          </div>
          <div id="editServer" class="easyui-window reloadtable" closed="true" modal="true" resizable="false" maximizable="false"  minimizable="false" title="编辑服务器" style="width:300px;height:550px;">
         <div class="selectone">
                            请选择要编辑的机器: <input id="selectEditServer" class="easyui-combotree serverList" value="" style="width:200px;" />
         </div>
         <div class="note"></div>
         <form id="editServerForm" method="post">
          <table>
          <tr>
            <td>服务器序号:</td>
            <td><input class="easyui-validatebox"  name="serverNumber" required="true" validType="number"></td>
          </tr>
         <tr>
          <td>放置地点:</td>
          <td><input class="easyui-validatebox" name="area" required="true" validType="minLength[2]"></td>
        </tr>
         <tr>
          <td>IP地址:</td>
         <td><input class="easyui-validatebox" name="ip" required="true" validType="minLength[7]"></td>
        </tr>
        <tr>
          <td>是否能Ping通:</td>
         <td>
         <select class="easyui-combobox option1" name="ping" required="true" panelHeight="auto">
           <option value="1">是</option>
           <option value="0">否</option>
        </select>
         </td>
        </tr>
        <tr>
          <td>是否能登陆:</td>
         <td>
         <select class="easyui-combobox option1" name="login" required="true" panelHeight="auto">
           <option value="1">是</option>
          <option value="0">否</option>
        </select>
         </td>
        </tr>
        <tr>
          <td>是否需要跳板:</td>
         <td>
        <select class="easyui-combobox option1" name="proxylogin" required="true" panelHeight="auto">
           <option value="1">是</option>
          <option value="0">否</option>
        </select>
         </td>
        </tr>      
        <tr>
          <td>分光网卡:</td>
         <td><textarea class="easyui-validatebox" name="eth" style="height:100px;"></textarea></td>
        </tr>  
         <tr>
         <td>备注:</td>
         <td><textarea class="easyui-validatebox" name="remarks" style="height:100px;"></textarea></td>
        </tr>
       </table>
       <input type="hidden" name="serverID" value="" />
       <div class="submit"><a href="#" class="easyui-linkbutton" onclick="javascript:editServerFormSubmit()">提交</a></div>
       </form>        
          </div>
          <div id="delServer" class="easyui-window reloadtable" closed="true" modal="true" resizable="false" maximizable="false"  minimizable="false" title="删除服务器" style="width:300px;height:300px;">
        <div class="selectone">
                      请选择要删除的机器: <input id="selectDelServer" class="easyui-combotree serverList" value="" style="width:200px;"/>
         </div> 
         <div class="note"></div>
          <div class="submit" style="margin-top: 30px;"><a href="#" class="easyui-linkbutton" onclick="javascript:delServerFormSubmit()">提交</a></div>
          </div>
        </div>
       <div title="操作历史" icon="icon-ok" style="padding:5px;" href="/history.php" cache="false"></div>
      </div>
  </div>
  <!--  <div id="statusbar" region="south" border="true">状态栏</div>-->
  <div id="mm" class="easyui-menu" style="width:120px;">
   <div iconCls="icon-add" onclick="javascript:addProvince()">添加省份</div>
   <div iconCls="icon-edit" onclick="javascript:editProvince()">编辑省份</div>
   <div iconCls="icon-remove" onclick="javascript:delProvince()">删除省份</div>
   <div iconCls="icon-add" onclick="javascript:addServer()">添加服务器</div>
   <div iconCls="icon-edit" onclick="javascript:editServer()">编辑服务器</div>
   <div iconCls="icon-remove" onclick="javascript:delServer()">删除服务器</div>
   <div onclick="collapseAll()">全部收缩</div>
   <div onclick="expandAll()">全部展开</div>
  </div>
</body>
</html>
