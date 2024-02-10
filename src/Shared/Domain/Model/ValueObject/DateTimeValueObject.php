<?php

declare(strict_types=1);

namespace App\Shared\Domain\Model\ValueObject;

use App\Shared\Domain\Model\ValueObject;
use DateTimeImmutable;
use DateTimeZone;
use Exception;

class DateTimeValueObject extends DateTimeImmutable implements ValueObject
{
    private const TIME_ZONE = "UTC";

    private const TIME_FORMAT = 'Y-m-d\TH:i:s.uP';

    final private function __construct(string $datetime, DateTimeZone $timezone)
    {
        parent::__construct(
            $datetime,
            $timezone
        );
    }

    /**
     * @throws Exception
     */
    public static function from(string $str): static
    {
        return new static($str, new DateTimeZone(self::TIME_ZONE));
    }

    /**
     * @throws Exception
     */
    final public static function fromFormat(string $format, string $str): static
    {
        $dateTime = \DateTimeImmutable::createFromFormat($format, $str, new \DateTimeZone(self::TIME_ZONE));

        return static::from($dateTime->format(self::TIME_FORMAT));
    }

    /**
     * @throws Exception
     */
    final public static function now(): static
    {
        return static::from('now');
    }

    public function value(): string
    {
        return $this->format(DATE_ATOM);
    }

    public function jsonSerialize(): string
    {
        return $this->value();
    }
}
