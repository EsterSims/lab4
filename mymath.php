<?php
require_once(__DIR__ . '/vendor/autoload.php');
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Lab 4 - Math</title>
    <script type="text/javascript">
    </script>
	
	
  </head>
  <body>
    <h1>Math PHP Library</h1>
	<h2> Algebra Examples</h2>
	<?php 
	use MathPHP\Algebra;

// Greatest common divisor (GCD)
$x = 8;
$y = 12;
$gcd = Algebra::gcd($x, $y);
echo " Greatest common divisor of: $x and $y is $gcd";


// Least common multiple (LCM)
$xx = 5;
$yy = 2;
$lcm = Algebra::lcm($xx, $yy);
echo "<br />Least common multiple of $xx and $yy is:  $lcm ";

// Factors of an integer
$factors = Algebra::factors($y); // returns [1, 2, 3, 4, 6, 12]
$arrlength = count($factors);
echo "<br />Factors of the integer $y is:";
for($x = 0; $x < $arrlength; $x++) {
    echo $factors[$x];
    echo " , ";
}

echo "<h2> Arithmetic Examples</h2> ";

use MathPHP\Arithmetic;
$xy = 8;
$³√x = Arithmetic::cubeRoot(-$xy); // -2
$myCubeRoot = Arithmetic::cubeRoot($xy); // 2

echo "Cube root of minus $xy is $³√x";

echo " <br />";
echo "Cube root of $xy is $myCubeRoot";


echo " <br />";
echo "<h2> Statistics Examples</h2> ";

use MathPHP\Statistics\Average;

$numbers = [13, 18, 13, 14, 13, 16, 14, 21, 13];

// Mean, median, mode
$arrlength = count($numbers);
echo "<br />The integers are: ";
for($x = 0; $x < $arrlength; $x++) {
    echo $numbers[$x];
    echo " , ";
}
$mean   = Average::mean($numbers);
echo "<br />Mean of the integers is: $mean ";
$median = Average::median($numbers);
echo "<br />Median of the integers is: $median";

$mode   = Average::mode($numbers); // Returns an array — may be multimodal
$arrlength = count($mode);
echo "<br />Mode of the integers is: ";

for($x = 0; $x < $arrlength; $x++) {
    echo $mode[$x];
    echo " , ";
}
echo " <br />";

echo "<h2> Descriptive - Statistics Examples</h2> ";

use MathPHP\Statistics\Descriptive;

$numbers = [13, 18, 13, 14, 13, 16, 14, 21, 13];

// Range and midrange
$range    = Descriptive::range($numbers);
$midrange = Descriptive::midrange($numbers);

// Variance (population and sample)
$σ² = Descriptive::populationVariance($numbers); // n degrees of freedom
$S² = Descriptive::sampleVariance($numbers);     // n - 1 degrees of freedom

// Variance (Custom degrees of freedom)
$df = 5;                                    // degrees of freedom
$S² = Descriptive::variance($numbers, $df); // can specify custom degrees of freedom

// Standard deviation (Uses population variance)
$σ = Descriptive::sd($numbers);                // same as standardDeviation;
$σ = Descriptive::standardDeviation($numbers); // same as sd;

// SD+ (Standard deviation for a sample; uses sample variance)
$SD＋ = Descriptive::sd($numbers, Descriptive::SAMPLE); // SAMPLE constant = true
$SD＋ = Descriptive::standardDeviation($numbers, true); // same as sd with SAMPLE constant

// Coefficient of variation (cᵥ)
$cᵥ = Descriptive::coefficientOfVariation($numbers);

// MAD - mean/median absolute deviations
$mean_mad   = Descriptive::meanAbsoluteDeviation($numbers);
$median_mad = Descriptive::medianAbsoluteDeviation($numbers);

// Quartiles (inclusive and exclusive methods)
// [0% => 13, Q1 => 13, Q2 => 14, Q3 => 17, 100% => 21, IQR => 4]
$quartiles = Descriptive::quartiles($numbers);          // Has optional parameter to specify method. Default is Exclusive
$quartiles = Descriptive::quartilesExclusive($numbers);
$quartiles = Descriptive::quartilesInclusive($numbers);

// IQR - Interquartile range
$IQR = Descriptive::interquartileRange($numbers); // Same as IQR; has optional parameter to specify quartile method.
$IQR = Descriptive::IQR($numbers);                // Same as interquartileRange; has optional parameter to specify quartile method.

// Percentiles
$twentieth_percentile    = Descriptive::percentile($numbers, 20);
$ninety_fifth_percentile = Descriptive::percentile($numbers, 95);

// Midhinge
$midhinge = Descriptive::midhinge($numbers);

// Describe a list of numbers - descriptive stats report
$stats = Descriptive::describe($numbers); // Has optional parameter to set population or sample calculations

$arrlength = count($numbers);
echo "The Array of the numbers is: ";

for($x = 0; $x < $arrlength; $x++) {
    echo $numbers[$x];
    echo " , ";
}
echo " <br />";
echo " The stats report:<br />";
print_r($stats);
/* Array (
    [n]          => 9
    [min]        => 13
    [max]        => 21
    [mean]       => 15
    [median]     => 14
    [mode]       => Array ( [0] => 13 )
    [range]      => 8
    [midrange]   => 17
    [variance]   => 8
    [sd]         => 2.8284271247462
    [cv]         => 0.18856180831641
    [mean_mad]   => 2.2222222222222
    [median_mad] => 1
    [quartiles]  => Array (
            [0%]   => 13
            [Q1]   => 13
            [Q2]   => 14
            [Q3]   => 17
            [100%] => 21
            [IQR]  => 4
        )
    [midhinge]   => 15
    [skewness]   => 1.4915533665654
    [ses]        => 0.71713716560064
    [kurtosis]   => 0.1728515625
    [sek]        => 1.3997084244475
    [sem]        => 0.94280904158206
    [ci_95]      => Array (
            [ci]          => 1.8478680091392
            [lower_bound] => 13.152131990861
            [upper_bound] => 16.847868009139
        )
    [ci_99]      => Array (
            [ci]          => 2.4285158135783
            [lower_bound] => 12.571484186422
            [upper_bound] => 17.428515813578
        )
) */

// Five number summary - five most important sample percentiles
$summary = Descriptive::fiveNumberSummary($numbers);
// [min, Q1, median, Q3, max]
echo " <br /><br />";

echo " The stats Summery is:<br />";
print_r($summary);
echo " <br />";
echo " <br />";

?>

    <script type="text/javascript">
    </script>
	
  </body>
</html>
