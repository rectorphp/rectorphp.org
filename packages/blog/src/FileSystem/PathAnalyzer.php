<?php

declare(strict_types=1);

namespace Rector\Website\Blog\FileSystem;

use DateTimeInterface;
use Nette\Utils\DateTime;
use Nette\Utils\Strings;
use Rector\Website\Exception\ShouldNotHappenException;
use Symplify\SmartFileSystem\SmartFileInfo;

final class PathAnalyzer
{
    /**
     * @see https://regex101.com/r/UD1dMk/1
     * @var string
     */
    private const DATE_REGEX = '(?<year>\d{4})-(?<month>\d{2})-(?<day>\d{2})';

    /**
     * @see https://regex101.com/r/2TMMR2/1
     * @var string
     */
    private const NAME_REGEX = '(?<name>[\w\d-]*)';

    public function detectDate(SmartFileInfo $fileInfo): ?DateTimeInterface
    {
        $match = Strings::match($fileInfo->getFilename(), '#' . self::DATE_REGEX . '#');
        if ($match === null) {
            return null;
        }

        $date = sprintf('%d-%d-%d', $match['year'], $match['month'], $match['day']);

        return DateTime::from($date);
    }

    public function getSlug(SmartFileInfo $fileInfo): string
    {
        $date = $this->detectDate($fileInfo);

        if ($date === null) {
            throw new ShouldNotHappenException();
        }

        $dateAndNamePattern = sprintf('#%s-%s#', self::DATE_REGEX, self::NAME_REGEX);

        $match = (array) Strings::match($fileInfo->getFilename(), $dateAndNamePattern);

        return $date->format('Y/m/d') . '/' . $match['name'];
    }
}
