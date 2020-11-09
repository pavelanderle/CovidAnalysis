<?php
// source: templates/covidAnalysis.latte

use Latte\Runtime as LR;

class Templateb4914075be extends Latte\Runtime\Template
{

	function main()
	{
		extract($this->params);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>CovidAnalysis</title>
</head>

<body>
    <div class="container">
        <div class="jumbotron">
            <h1 class="display-4">Covid Analysis</h1>
            <p class="lead">Statistic about Covid in CZ</p>
            <hr class="my-4">
            <p>Only for March 2020</p>
        </div>
        <form method="get" action="#">
            <div class="form-group">
                <label for="kraj">Vyber kraj</label>
                <select id="kraj" class="custom-select" name="kraj">
<?php
		$iterations = 0;
		foreach ($krajList as $item) {
			?>                    <option value="<?php echo LR\Filters::escapeHtmlAttr($item[0]) /* line 33 */ ?>"><?php
			echo LR\Filters::escapeHtmlText($item[1]) /* line 33 */ ?></option>
<?php
			$iterations++;
		}
?>                </select>
            </div>
            <input class="form-control" type="submit" value="Zobraz">
        </form>
        <h2 class="mt-5 mb-3">Analýza pro <?php echo LR\Filters::escapeHtmlText($resultCovidInKraj[5]) /* line 38 */ ?></h2>

        <div class="d-flex flex-row">
            <h3 class="col">Celkový počet nakažených: <?php echo LR\Filters::escapeHtmlText($resultCovidInKraj[0]) /* line 41 */ ?></h3>
            <h3 class="col">Průměrný věk: <?php echo LR\Filters::escapeHtmlText(call_user_func($this->filters->number, $resultCovidInKraj[3], 1)) /* line 42 */ ?></h3>
        </div>
        <div class="d-flex flex-row">
            <h3 class="col">Celkový počet nakažených mužů: <?php echo LR\Filters::escapeHtmlText($resultCovidInKraj[1]) /* line 45 */ ?></h3>
            <h3 class="col">Celkový počet nakažených žen: <?php echo LR\Filters::escapeHtmlText($resultCovidInKraj[2]) /* line 46 */ ?></h3>
        </div>
        <div class="d-flex flex-row">
            <h3 class="col">Celkový počet nakažených v cizině: <?php echo LR\Filters::escapeHtmlText($resultCovidInKraj[4]) /* line 49 */ ?></h3>
            <h3 class="col">Celkový počet nakažených v ČR: <?php echo LR\Filters::escapeHtmlText($resultCovidInKraj[0]-$resultCovidInKraj[4]) /* line 50 */ ?></h3>
        </div>

        <h3 class="mt-5 mb-3">Počet nakažených dle země nákazy</h3>

        <table class="table table-light">
<?php
		$iterations = 0;
		foreach ($resultImpactForeign as $item) {
?>                <tr>
                    <td><?php echo LR\Filters::escapeHtmlText($item[0]) /* line 57 */ ?></td>
                    <td><?php echo LR\Filters::escapeHtmlText($item[1]) /* line 58 */ ?></td>
                </tr>
<?php
			$iterations++;
		}
?>
        </table>
    </div>
    
</body>

</html><?php
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		if (isset($this->params['item'])) trigger_error('Variable $item overwritten in foreach on line 32, 56');
		
	}

}
