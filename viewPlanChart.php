<?php
set_time_limit(0);
include_once 'Date.php';
include_once 'Project.php';
include_once 'Task.php';
$pid = $_GET['pid'];
$s = getTasksData($pid);
function getTasksData($pid)
{
    $tasks = getAllTasks($pid);
    $ret = array();
    for ($i = 0; $i < sizeof($tasks); $i += 1)
    {
        $t = $tasks[$i];
        $id = $t->getId();
        $name = $t->getName();
        $startDate = new Date($t->getStartDate());
        $year = $startDate->getYear();
        $month = $startDate->getMonth();
        $month -= 1;
        $day = $startDate->getDay();
        $workingDaysNeeded = $t->getWorkingDaysNeeded();
        $duration = $workingDaysNeeded * 24 * 60 * 60 * 1000;

        $s = "['$id', '$name', new Date($year, $month, $day), null, $duration, 0, null]";
//        echo $s . "<br><br>";
        array_push($ret, $s);
    }
    $ret = implode(" , ", $ret);
    $ret = "[" . $ret . "]";
    return $ret;
}
?>

<title>Charts</title>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['gantt']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Task ID');
        data.addColumn('string', 'Task Name');
        data.addColumn('date', 'Start Date');
        data.addColumn('date', 'End Date');
        data.addColumn('number', 'Duration');
        data.addColumn('number', 'Percent Complete');
        data.addColumn('string', 'Dependencies');

        data.addRows(<?php echo $s?>);

        var options = {
            height: 1000
        };

        var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

        chart.draw(data, options);
    }
</script>
<div id="chart_div"></div>
