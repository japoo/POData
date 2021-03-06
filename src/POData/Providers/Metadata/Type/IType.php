<?php

declare(strict_types=1);

namespace POData\Providers\Metadata\Type;

/**
 * Class IType.
 */
interface IType
{
    /**
     * Gets the type code for the type implementing this interface.
     *
     * @return TypeCode
     */
    public function getTypeCode(): TypeCode;

    /**
     * Checks the type implementing this interface is compatible with another type.
     *
     * @param IType $type Type to check compatibility
     *
     * @return bool
     */
    public function isCompatibleWith(IType $type): bool;

    /**
     * Validate a value in Astoria uri is in a format for the type implementing this
     * interface
     * Note: implementation of IType::validate.
     *
     * @param string      $value     The value to validate
     * @param string|null &$outValue The stripped form of $value that can be used in PHP
     *                               expressions
     *
     * @return bool
     */
    public function validate(string $value, ?string &$outValue): bool;

    /**
     * Gets full name of the type implementing this interface in EDM namespace
     * Note: implementation of IType::getFullTypeName.
     *
     * @return string
     */
    public function getFullTypeName(): string;

    /**
     * Converts the given string value to this type.
     *
     * @param string $stringValue value to convert
     *
     * @return mixed
     */
    public function convert(string $stringValue);

    /**
     * Convert the given value to a form that can be used in OData uri.
     *
     * @param mixed $value value to convert
     *
     * @return string
     */
    public function convertToOData($value): string;

    /**
     * Gets full name of the type implementing this interface in EDM namespace
     * Note: implementation of IType::getFullTypeName.
     *
     * @return string
     */
    public function getName(): string;
}
