<?php
include_once 'Date.php';
include_once 'Project.php';
include_once 'Task.php';
$pid = $_GET['pid'];
$s = getTasksData($pid);
function getTasksData($pid)
{
    $p = getProjectFromID($pid);
    $tasks = getMajorTasks($pid);
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

        $s = "['$id', '$name', new Date($year, $month, $day), null, $duration, null, null]";
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

    function daysToMilliseconds(days) {
        return days * 24 * 60 * 60 * 1000;
    }

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
        // data.addRows([
        //     ['Research', 'Find sources',
        //         new Date(2015, 0, 1), new Date(2015, 0, 5), null,  100,  null],
        //     ['Write', 'Write paper',
        //         null, new Date(2015, 0, 9), daysToMilliseconds(3), 25, 'Research,Outline'],
        //     ['Cite', 'Create bibliography',
        //         null, new Date(2015, 0, 7), daysToMilliseconds(1), 20, 'Research'],
        //     ['Complete', 'Hand in paper',
        //         null, new Date(2015, 0, 10), daysToMilliseconds(1), 0, 'Cite,Write'],
        //     ['Outline', 'Outline paper',
        //         null, new Date(2015, 0, 6), daysToMilliseconds(1), 100, 'Research']
        // ]);

        var options = {
            height: 1000
        };

        var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

        chart.draw(data, options);
    }
</script>
<div id="chart_div"></div>
