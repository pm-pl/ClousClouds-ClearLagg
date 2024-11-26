<?php

use Rector\Config\RectorConfig;
use Rector\Core\ValueObject\PhpVersion;
use Rector\PhpDocParser\ValueObject\Type\StringType;
use Rector\PhpDocParser\ValueObject\Type\IntegerType;
use Rector\PHPStanStaticTypeMapper\ValueObject\PHPStan\Type\ArrayType;
use Rector\PhpDoc\Rector\ClassMethod\AddArrayReturnDocTypeRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->setPhpVersion(PhpVersion::PHP_80);
    $rectorConfig->rules([
        AddArrayReturnDocTypeRector::class,
    ]);
};
