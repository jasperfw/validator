<?php

namespace JasperFW\Validator\Filter;

use JasperFW\Validator\Exception\BadDefinitionException;
use JasperFW\Validator\Validator\Validator;

/**
 * Class Filter
 *
 * A filter alters or transforms incoming data before validation. Common filters might include StripTags (for dealing
 * with XSS vulnerabilities) and Trim (for removing whitespace).
 *
 * @package JasperFW\Validator\Filter
 */
abstract class Filter
{
    /**
     * @var Validator|null
     */
    protected $validator;

    /**
     * Create a constraint according to the passed definition array. The definition must contain a class, which is the
     * fully qualified name of the constraint class. Optionally, it can also contain a rule value appropriate for the
     * constraint class in question, and an error message to override the default error message.
     *
     * @param array $definition
     *
     * @return Filter|null
     * @throws BadDefinitionException If the definition file is not valid
     */
    public static function factory(array $definition): ?Filter
    {
        // Make sure a class has been defined.
        if (!isset($definition['class'])) {
            throw new BadDefinitionException('The constraint could not be constructed.');
        }
        $class = $definition['class'];
        return new $class();
    }

    /**
     * @param Validator $validator The validator this constraint is attached to
     */
    public function __construct(?Validator $validator = null)
    {
        $this->validator = $validator;
    }

    /**
     * Set a reference to the validator
     *
     * @param Validator $validator
     *
     * @return Filter
     */
    public function setValidator(Validator &$validator): Filter
    {
        $this->validator = $validator;
        return $this;
    }

    abstract public function filter(&$value);
}