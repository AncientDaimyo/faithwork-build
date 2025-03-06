<?php

namespace App\Shared\Domain\Type;

class Decimal
{
    private string $value;

    private int $scale;

    public function __construct($value, int $scale = 2)
    {
        $this->scale = $scale;
        $this->value = $this->normalize($value);
    }

    private function normalize(string|int|Decimal $value): string
    {
        if ($value instanceof Decimal) {
            return $value->getValue();
        }

        if (is_int($value)) {
            return (string)$value . '.0';
        }

        if (!is_string($value)) {
            return '0.0';
        }

        // Убираем пробелы и знаки + и -
        $value = trim($value, ' +-');

        // Добавляем недостающие нули
        if (strpos($value, '.') === false) {
            $value .= '.' . str_repeat('0', $this->scale);
        }

        return $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function add(Decimal $other): Decimal
    {
        $scale = max($this->scale, $other->scale);
        $result = bcadd($this->value, $other->value, $scale);
        return new self($result, $scale);
    }

    public function sub(Decimal $other): Decimal
    {
        $scale = max($this->scale, $other->scale);
        $result = bcsub($this->value, $other->value, $scale);
        return new self($result, $scale);
    }

    public function mul(Decimal $other): Decimal
    {
        $scale = max($this->scale, $other->scale);
        $result = bcmul($this->value, $other->value, $scale);
        return new self($result, $scale);
    }

    public function div(Decimal $other): Decimal
    {
        $scale = max($this->scale, $other->scale) * 2;
        $result = bcdiv($this->value, $other->value, $scale);
        return new self($result, $scale);
    }

    public function compare(Decimal $other): int
    {
        $scale = max($this->scale, $other->scale);
        $result = bccomp($this->value, $other->value, $scale);
        return $result;
    }

    public function round(int $precision = 0, int $mode = PHP_ROUND_HALF_UP): Decimal
    {
        $result = bcround($this->value, $precision);
        return new self($result, $precision);
    }

    public function __toString(): string
    {
        return $this->format($this->scale);
    }

    public function format(string $decimalSeparator = '.', string $thousandSeparator = ''): string
    {
        $parts = explode('.', $this->value);
        $integerPart = $parts[0];
        $decimalPart = isset($parts[1]) ? substr($parts[1], 0, $this->scale) : str_repeat('0', $this->scale);

        if ($thousandSeparator) {
            $integerPart = number_format($integerPart, 0, '', $thousandSeparator);
        }

        return $decimalPart === '0' ? $integerPart : $integerPart . $decimalSeparator . $decimalPart;
    }

    public function equals(Decimal $other): bool
    {
        return $this->compare($other) === 0;
    }

    public function greaterThan(Decimal $other): bool
    {
        return $this->compare($other) === 1;
    }

    public function lessThan(Decimal $other): bool
    {
        return $this->compare($other) === -1;
    }

    public function pow(int $power): Decimal
    {
        $result = bcpow($this->value, $power, $this->scale);
        return new self($result, $this->scale);
    }

    public function sqrt(): Decimal
    {
        $result = bcsqrt($this->value, $this->scale);
        return new self($result, $this->scale);
    }

    public function isPositive(): bool
    {
        return bccomp($this->value, '0', $this->scale) === 1;
    }

    public function isNegative(): bool
    {
        return bccomp($this->value, '0', $this->scale) === -1;
    }

    public function isZero(): bool
    {
        return bccomp($this->value, '0', $this->scale) === 0;
    }
}
