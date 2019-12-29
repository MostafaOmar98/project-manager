<?php
set_time_limit(0);
include_once 'Date.php';
include_once 'Project.php';
include_once 'Task.php';
include_once 'CompletedTask.php';
$pid = $_GET['pid'];
$s = getTasksData($pid);
function getTasksData($pid)
{
    $tasks = getMajorTasks($pid);
    $ret = array();
    for ($i = 0; $i < sizeof($tasks); $i += 1)
    {
        $t = $tasks[$i];
        $completed = getCompletedTaskWithTid($t->getId());
        for ($j = 0; $j < sizeof($completed); $j += 1)
        {
            $c = $completed[$j];
            $id = $c->getTid();
            $name = $t->getName();
            $startDate = new Date($c->getStartDate());
            $year1 = $startDate->getYear();
            $month1 = $startDate->getMonth();
            $day1 = $startDate->getDay();

            $endDate = new Date($c->getEndDate());
            $year2 = $endDate->getYear();
            $month2 = $endDate->getMonth();
            $day2 = $endDate->getDay();
            $s = "['$id', '$name', new Date($year1, $month1, $day1), new Date($year2, $month2, $day2), null, 100, null]";
            array_push($ret, $s);
        }
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
