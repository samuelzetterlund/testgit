<?php
include "inc/db.php"; //  H�mtar in databaskopplingen

?>


<HTML>
<HEAD>
<TITLE>Class Sync</TITLE>
<link rel='stylesheet' href='style.css'>
</head>
<body>
<center>
<br>
<table width='980' border='0'>
<tr><td class='top' align='right'><i>Rudbeck Class Sync</i></td></tr></table>
<br>
<table width='980' cellspacing='0' cellpadding='0'>
<tr height='15'><td colspan='10' bgcolor='white'></td></tr>
<tr><td rowspan='3' bgcolor='white' width='15'></td><td align='left'>
<table width='100%' border='0' cellpadding='5' bgcolor="#f2f2f2">
<tr valign='top'><td width='40%'>
<table border='0' width='100%'><tr><td><form>
<select name="URL" onchange="window.location.href= this.form.URL.options[this.form.URL.selectedIndex].value">
<?

//SELECT CLASS
//------------------------------------------------------------------------------------------------------------------                                
$sqlclass3 = $db->prepare("SELECT * FROM tbl_class ORDER BY class ASC");
$sqlclass3->execute();
  
if ($_GET['class'] == NULL)
  echo "<option value=0>Select class</option>";  

while ($rsclass3 = $sqlclass3->fetch(PDO::FETCH_ASSOC))
{
  if ($_GET['class'] == NULL)
    echo "<option value=index.php?class=" . $rsclass3['id'] . ">" . $rsclass3['class'] . "</option>";
  else
  {
    if ($_GET['class'] == $rsclass3['id'])
      echo "<option value=index.php?class=" . $rsclass3['id'] . " selected>" . $rsclass3['class'] . "</option>";
    else
      echo "<option value=index.php?class=" . $rsclass3['id'] . ">" . $rsclass3['class'] . "</option>";
  }
}
//------------------------------------------------------------------------------------------------------------------

?>
</select></form></td><td>
<?
//SELECT COURSE
//------------------------------------------------------------------------------------------------------------------
$sqlcourse = $db->prepare("SELECT tbl_course.* FROM (tbl_course INNER JOIN tbl_classcourse ON tbl_course.id = 
tbl_classcourse.idcourse) WHERE tbl_classcourse.idclass = ? ORDER BY tbl_course.course ASC");
$sqlcourse->execute(array($_GET['class']));
?>
</td></tr></table></td>

</tr>
<tr height='20'><td colspan='30'></td></tr>
<tr><td valign='top' colspan='30'>
<table border=0 width='100%'>
<tr><td class='cmd' width='3%'><b>W</b></td>
<td class='cmd' width='4%'><b>M</b></td>
<td class='cmd' width='3%'><b>D</b></td>
<td class='cmd' width='4%'><b>WD</b></td>
<?
while ($rscourse = $sqlcourse->fetch(PDO::FETCH_ASSOC))
  echo "<td class='cmd' width='80'><b>" . $rscourse['course'] . "</b></td>";
?>
<td></td>  
</tr>
<?
for ($i=0; $i<100; $i++)
{
  $timestamp = mktime(0, 0, 0, date("m"), date("d")+$i, date("y"));
  $day = date("Y-m-d", $timestamp);
  $month = substr($day,5,2);
  $year = substr($day,0,4);                                  
  $dayofweek = date("D", mktime(0, 0, 0, $month, substr($day,8,2), $year));
  
  if (($dayofweek != "Sun") && ($dayofweek != "Sat"))
  {
    echo "<tr>";
  
    //weeknumber
    echo "<td class='cmd'>";
    $weeknumber = date("W", mktime(0, 0, 0, $month, substr($day,8,2), $year));
    if ($newweeknumber != $weeknumber)
      echo $weeknumber;
    echo "</td>";
    
    //m�nad
    echo "<td class='cmd'>";
    if ($newmonth != $month)
      echo "<b>" . date("M", mktime(0, 0, 0, $month, substr($day,8,2), $year)) . "</b>";
    echo "</td>";
    
    //dag
    echo "<td class='cmd'>";
    if (($dayofweek != "Sun") && ($dayofweek != "Sat"))
      echo substr($day,8,2);
    echo "</td>";
      
    //day of week
    echo "<td class='cmd'>";
    if (($dayofweek != "Sun") && ($dayofweek != "Sat"))
      echo $dayofweek;
    echo "</td>";
    
    
    //uppdaterar variabler
    $newweeknumber = $weeknumber;
    $newmonth = $month;

    //kursceller
    $sqlcourse3 = $db->prepare("SELECT tbl_course.* FROM (tbl_classcourse INNER JOIN tbl_course ON 
    tbl_classcourse.idcourse = tbl_course.id) WHERE tbl_classcourse.idclass = ? ORDER BY tbl_course.course ASC");
    $sqlcourse3->execute(array($_GET['class']));
    while ($rscourse3 = $sqlcourse3->fetch(PDO::FETCH_ASSOC))
    {
      $sqltask = $db->prepare("SELECT tbl_user.user, tbl_task.id AS idtask, tbl_user.id, tbl_tasktype.tasktype FROM 
      ((tbl_task INNER JOIN tbl_tasktype ON tbl_task.idtasktype = tbl_tasktype.id) INNER JOIN tbl_user ON 
      tbl_task.iduser = tbl_user.id) WHERE tbl_task.day = ? AND tbl_task.idcourse = ?");
      $sqltask->execute(array($day, $rscourse3['id']));
      echo "<td class='cmd'>";
      while ($rstask = $sqltask->fetch(PDO::FETCH_ASSOC))
      {
        switch ($rstask['tasktype'])
        {
          case "Exam": $color = "#1aaeee";
                  break;
          case "Test": $color = "#f1d13d";
                  break;          
          case "HW": $color = "#db2dd5";
                  break;
        }         
        echo "<div style='background: " . $color . ";'>" . $rstask['tasktype'] . " (" . $rstask['user'] . ")";
        echo "</div>";
      }
      echo "</td>";

    }

    echo "</tr>";
    
    if ($dayofweek == "Sunday")
      echo "<tr height='30'><td colspan='4'></td></tr>";

  }
  else
    echo "<tr height='5'><td colspan='30'></td></tr>";
  
} 
?>
</td></tr>
</table>
</td></tr>
<tr><td>
</td></tr>
</table>
</td><td rowspan='3' bgcolor='white' width='15'></td></tr>
<tr height='15'><td colspan='10' bgcolor='white'></td></tr></table>
</body>
</html>
