<?php
namespace MathPHP\Statistics\Regression;

class LinearTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $points = [ [1,2], [2,3], [4,5], [5,7], [6,8] ];
        $regression = new Linear($points);
        $this->assertInstanceOf('MathPHP\Statistics\Regression\Regression', $regression);
        $this->assertInstanceOf('MathPHP\Statistics\Regression\Linear', $regression);
    }

    public function testGetPoints()
    {
        $points = [ [1,2], [2,3], [4,5], [5,7], [6,8] ];
        $regression = new Linear($points);
        $this->assertEquals($points, $regression->getPoints());
    }

    public function testGetXs()
    {
        $points = [ [1,2], [2,3], [4,5], [5,7], [6,8] ];
        $regression = new Linear($points);
        $this->assertEquals([1,2,4,5,6], $regression->getXs());
    }

    public function testGetYs()
    {
        $points = [ [1,2], [2,3], [4,5], [5,7], [6,8] ];
        $regression = new Linear($points);
        $this->assertEquals([2,3,5,7,8], $regression->getYs());
    }

    /**
     * @dataProvider dataProviderForEquation
     * Equation matches pattern y = mx + b
     */
    public function testGetEquation(array $points)
    {
        $regression = new Linear($points);
        $this->assertRegExp('/^y = -?\d+[.]\d+x [+] -?\d+[.]\d+$/', $regression->getEquation());
    }

    public function dataProviderForEquation()
    {
        return [
            [ [ [0,0], [1,1], [2,2], [3,3], [4,4] ] ],
            [ [ [1,2], [2,3], [4,5], [5,7], [6,8] ] ],
            [ [ [4,390], [9,580], [10,650], [14,730], [4,410], [7,530], [12,600], [22,790], [1,350], [3,400], [8,590], [11,640], [5,450], [6,520], [10,690], [11,690], [16,770], [13,700], [13,730], [10,640] ] ],
        ];
    }

    /**
     * @dataProvider dataProviderForParameters
     */
    public function testGetParameters(array $points, $m, $b)
    {
        $regression = new Linear($points);
        $parameters = $regression->getParameters();
        $this->assertEquals($m, $parameters['m'], '', 0.0001);
        $this->assertEquals($b, $parameters['b'], '', 0.0001);
    }

    public function dataProviderForParameters()
    {
        return [
            [
                [ [1,2], [2,3], [4,5], [5,7], [6,8] ],
                1.2209302325581, 0.60465116279069
            ],
            [
                [ [4,390], [9,580], [10,650], [14,730], [4,410], [7,530], [12,600], [22,790], [1,350], [3,400], [8,590], [11,640], [5,450], [6,520], [10,690], [11,690], [16,770], [13,700], [13,730], [10,640] ],
                25.326467777896, 353.16487949889
            ],
            // Example data from http://reliawiki.org/index.php/Simple_Linear_Regression_Analysis
            [
                [ [50,122], [53,118], [54,128], [55,121], [56,125], [59,136], [62,144], [65,142], [67,149], [71,161], [72,167], [74,168], [75,162], [76,171], [79,175], [80,182], [82,180], [85,183], [87,188], [90,200], [93,194], [94,206], [95,207], [97,210], [100,219] ],
                1.9952, 17.0016
            ],
            // Example data from http://faculty.cas.usf.edu/mbrannick/regression/regbas.html, http://www.alcula.com/calculators/statistics/linear-regression/
            [
                [ [61,105], [62,120], [63,120], [65,160], [65,120], [68,145], [69,175], [70,160], [72,185], [75,210] ],
                6.968085106383, -316.86170212766
            ],
            [
                [ [6,562], [3,421], [6,581], [9,630], [3,412], [9,560], [6,434], [3,443], [9,590], [6,570], [3,346], [9,672] ],
                 34.583333333333, 310.91666666667
            ],
            [
                [ [95,85], [85,95], [80,70], [70,65], [60,70] ],
                0.64383562, 26.780821917808
            ],
            [
                [ [1,1], [2,2], [3,1.3], [4,3.75], [5,2.25] ],
                0.425, 0.785
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForSampleSize
     */
    public function testGetSampleSize(array $points, $n)
    {
        $regression = new Linear($points);
        $this->assertEquals($n, $regression->getSampleSize());
    }

    public function dataProviderForSampleSize()
    {
        return [
            [
                [ [1,2], [2,3], [4,5], [5,7], [6,8] ], 5
            ],
            [
                [ [4,390], [9,580], [10,650], [14,730], [4,410], [7,530], [12,600], [22,790], [1,350], [3,400], [8,590], [11,640], [5,450], [6,520], [10,690], [11,690], [16,770], [13,700], [13,730], [10,640] ], 20
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForEvaluate
     */
    public function testEvaluate(array $points, $x, $y)
    {
        $regression = new Linear($points);
        $this->assertEquals($y, $regression->evaluate($x), '', 0.01);
    }

    public function dataProviderForEvaluate()
    {
        return [
            [
                [ [0,0], [1,1], [2,2], [3,3], [4,4] ], // y = x + 0
                5, 5,
            ],
            [
                [ [0,0], [1,1], [2,2], [3,3], [4,4] ], // y = x + 0
                18, 18,
            ],
            [
                [ [0,0], [1,2], [2,4], [3,6] ], // y = 2x + 0
                4, 8,
            ],
            [
                [ [0,1], [1,3.5], [2,6] ], // y = 2.5x + 1
                5, 13.5
            ],
            [
                [ [0,2], [1,1], [2,0], [3,-1] ], // y = -x + 2
                4, -2
            ],
            // Example data from http://reliawiki.org/index.php/Simple_Linear_Regression_Analysis
            [
                [ [50,122], [53,118], [54,128], [55,121], [56,125], [59,136], [62,144], [65,142], [67,149], [71,161], [72,167], [74,168], [75,162], [76,171], [79,175], [80,182], [82,180], [85,183], [87,188], [90,200], [93,194], [94,206], [95,207], [97,210], [100,219] ],
                93, 202.5552
            ],
        ];
    }
    
    /**
     * @dataProvider dataProviderForCI
     */
    public function testCI(array $points, $x, $p, $ci)
    {
        $regression = new Linear($points);
        $this->assertEquals($ci, $regression->CI($x, $p), '', .0000001);
    }
    
    public function dataProviderForCI()
    {
        return [
            [
                [ [1,2], [2,3], [4,5], [5,7], [6,8] ],
                2, .05, 0.651543596,
            ],
            [
                [ [1,2], [2,3], [4,5], [5,7], [6,8] ],
                3, .05, 0.518513005,
            ],
            [
               [ [1,2], [2,3], [4,5], [5,7], [6,8] ],
                3, .1, 0.383431307,
            ],
        ];
    }
    
    /**
     * @dataProvider dataProviderForPI
     */
    public function testPI(array $points, $x, $p, $q, $pi)
    {
        $regression = new Linear($points);
        $this->assertEquals($pi, $regression->PI($x, $p, $q), '', .0000001);
    }
    
    public function dataProviderForPI()
    {
        return [
            [
                [ [1,2], [2,3], [4,5], [5,7], [6,8] ],
                2, .05, 1, 1.281185007,
            ],
            [
                [ [1,2], [2,3], [4,5], [5,7], [6,8] ],
                3, .05, 1, 1.218926455,
            ],
            [
               [ [1,2], [2,3], [4,5], [5,7], [6,8] ],  // when q gets large, pi approaches ci.
                3, .1, 10000000, 0.383431394
            ],
        ];
    }
    
    /**
     * @dataProvider dataProviderForFProbability
     */
    public function testFProbability(array $points, $probability)
    {
        $regression = new Linear($points);
        $Fprob = $regression->FProbability();
        $this->assertEquals($probability, $Fprob, '', .0000001);
    }
    
    public function dataProviderForFProbability()
    {
        return [
            [
                [ [1,2], [2,3], [4,5], [5,7], [6,8] ],
                .999304272,
            ],
        ];
    }
    
    /**
     * @dataProvider dataProviderForTProbability
     */
    public function testTProbability(array $points, $beta0, $beta1)
    {
        $regression = new Linear($points);
        $Tprob = $regression->tProbability();
        $this->assertEquals($beta0, $Tprob['m'], '', .0000001);
        $this->assertEquals($beta1, $Tprob['b'], '', .0000001);
    }
    
    public function dataProviderForTProbability()
    {
        return [
            [
                [ [1,2], [2,3], [4,5], [5,7], [6,8] ],
                0.999652136, 0.913994632,
            ],
        ];
    }
    
    /**
     * @dataProvider dataProviderForLeverages
     */
    public function testLeverages($points, $leverages)
    {
        $regression = new Linear($points);
        $test_leverages = $regression->leverages();
        foreach ($leverages as $key => $value) {
            $this->assertEquals($value, $test_leverages[$key], '', .0000001);
        }
    }
    
    public function dataProviderForLeverages()
    {
        return [
            [
                [ [1,2], [2,3], [4,5], [5,7], [6,8] ],
                [0.593023255813953, 0.348837209302325, 0.209302325581395, 0.313953488372093, 0.534883720930232],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForDF
     */
    public function testDF(array $points, $df)
    {
        $regression = new Linear($points);
        $this->assertEquals($df, $regression->degreesOfFreedom(), '', .0000001);
    }
    
    public function dataProviderForDF()
    {
        return [
            [
                [ [1,2], [2,3], [4,5], [5,7], [6,8] ],
                3,
            ],
        ];
    }
    
    /**
     * @dataProvider dataProviderForGetProjection
     */
    public function testGetProjection($points, $P)
    {
        $regression = new Linear($points);
        $test_P = $regression->getProjectionMatrix();
        foreach ($P as $row_num => $row) {
            foreach ($row as $column_num => $value) {
                $this->assertEquals($value, $test_P[$row_num][$column_num], '', .0000001);
            }
        }
    }
    
    public function dataProviderForGetProjection()
    {
        return [
            [
                [ [1,2], [2,3], [4,5], [5,7], [6,8] ],
                [ [0.593023255813953, 0.441860465116279, 0.13953488372093, -0.0116279069767443, -0.162790697674419],
                  [0.441860465116279, 0.348837209302325, 0.162790697674418, 0.069767441860465, -0.0232558139534887],
                  [0.13953488372093, 0.162790697674418, 0.209302325581395, 0.232558139534884, 0.255813953488372],
                  [-0.0116279069767442, 0.069767441860465, 0.232558139534884, 0.313953488372093, 0.395348837209302],
                  [-0.162790697674419, -0.0232558139534885, 0.255813953488372, 0.395348837209302, 0.534883720930232] ],
            ],
        ];
    }
    
    /**
     * @dataProvider dataProviderForMeanSquares
     */
    public function testMeanSquares(array $points, $force, $sums)
    {
        $regression = new Linear($points, $force);
        $this->assertEquals($sums['mse'], $regression->meanSquareResidual(), '', .0000001);
        $this->assertEquals($sums['msr'], $regression->meanSquareRegression(), '', .0000001);
        $this->assertEquals($sums['mst'], $regression->meanSquareTotal(), '', .0000001);
        $this->assertEquals($sums['sd'], $regression->errorSD(), '', .0000001);
    }
    
    public function dataProviderForMeanSquares()
    {
        return [
            [
                [ [1,2], [2,3], [4,5], [5,7], [6,8] ],
                [0,0],
                [
                    'mse' => 0.1201550388,
                    'msr' => 25.6395348837,
                    'mst' => 6.5,
                    'sd' => 0.3466338685,
                ],
            ],
        ];
    }
    
    /**
     * @dataProvider dataProviderForOutliers
     */
    public function testOutliers($points, $cook, $DFFITS)
    {
        $regression = new Linear($points);
        $test_cook = $regression->cooksD();
        $test_dffits = $regression->DFFITS();
        foreach ($test_cook as $key => $value) {
            $this->assertEquals($value, $cook[$key], '', .0000001);
        }
        foreach ($test_dffits as $key => $value) {
            $this->assertEquals($value, $DFFITS[$key], '', .0000001);
        }
    }
    
    public function dataProviderForOutliers()
    {
        return [
            // Example data from http://www.real-statistics.com/multiple-regression/outliers-and-influencers/
            [
                [ [5, 80], [23, 78], [25, 60], [48, 53], [17, 85], [8, 84], [4, 73], [26, 79], [11, 81], [19, 75], [14, 68], [35, 72], [29, 58], [4, 92], [23, 65] ],
                [0.012083306344603, 0.0300594698005975, 0.0757553251307135, 0.0741065959898502, 0.0624057528075083, 0.0142413619931789, 0.212136415565691, 0.0755417128075708, 0.00460659919090967, 0.00088992920763197, 0.0592838137660013, 0.142372813997539, 0.0975938916424623, 0.157390753959856, 0.0261198759356697],
                [-0.150079950062248, 0.24285101704604, -0.401412101080541, -0.372557646651725, 0.363674389274495, 0.163387818699222, -0.679956836684882, 0.398634868702933, 0.0925181155407344, 0.0405721294627194, -0.349647454278992, 0.540607683240147, -0.45315456934644, 0.572499188557405, -0.225453165214519],
            ],
        ];
    }
}