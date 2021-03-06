<?php
namespace MathPHP\NumberTheory;

use MathPHP\Algebra;
use MathPHP\Exception;

class Integer
{
    /**
     * Detect if an integer is a perfect power.
     * A perfect power is a positive integer that can be expressed as an integer power of another positive integer.
     * If n is a perfect power, then exists m > 1 and k > 1 such that mᵏ = n.
     * https://en.wikipedia.org/wiki/Perfect_power
     *
     * Algorithm:
     *  For each divisor of n (as m), consider all possible values of k from 2 to log₂n.
     *   - If mᵏ = n, return true
     *   - If exhaust all possible mᵏ combinations, return false.
     *
     * @param  int $n
     *
     * @return bool True if n is a perfect power; false otherwise.
     */
    public static function isPerfectPower(int $n): bool
    {
        if (empty(self::perfectPower($n))) {
            return false;
        }
        return true;
    }

    /**
     * If n is a perfect power, compute an m and k such that mᵏ = n.
     * A perfect power is a positive integer that can be expressed as an integer power of another positive integer.
     * If n is a perfect power, then exists m > 1 and k > 1 such that mᵏ = n.
     * https://en.wikipedia.org/wiki/Perfect_power
     *
     * Algorithm:
     *  For each divisor of n (as m), consider all possible values of k from 2 to log₂n.
     *   - If mᵏ = n, return m and k
     *   - If exhaust all possible mᵏ combinations, return empty array.
     *
     * An integer n could have multiple perfect power scenarios.
     * Only one is returned.
     *
     * @param  int $n
     *
     * @return array [m, k]
     */
    public static function perfectPower(int $n): array
    {
        $√n = sqrt($n);
        $ms = array_filter(
            Algebra::factors($n),
            function ($m) use ($√n) {
                return ($m > 1 && $m <= $√n);
            }
        );
        $max_k = ceil(log($n, 2));

        foreach ($ms as $m) {
            foreach (range(2, $max_k) as $k) {
                $mᵏ = $m**$k;
                if ($mᵏ == $n) {
                    return [$m, $k];
                }
            }
        }

        return [];
    }

    /**
     * Prime factorization
     * The prime factors of an integer.
     * https://en.wikipedia.org/wiki/Prime_factor
     *
     * @todo   Use a better algorithm.
     *
     * @param  int $n
     *
     * @return array of prime factors
     *
     * @throws Exception\OutOfBoundsException if n is < 2.
     */
    public static function primeFactorization(int $n): array
    {
        if ($n < 2) {
            throw new Exception\OutOfBoundsException("n must be ≥ 2. ($n provided)");
        }

        $remainder = $n;
        $factors   = [];
        $divisor   = 2;

        while ($remainder > 1) {
            while ($remainder % $divisor === 0) {
                $factors[] = $divisor;
                $remainder = intdiv($remainder, $divisor);
            }
            $divisor++;
        }

        return $factors;
    }
}
