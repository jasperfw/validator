# Jasper FW - Validator

The Validator library provides a comprehensive, yet easy to implement and expand, input and data validation system.

## Features

- Supports a wide variety of common inputs
- Allows custom validation rules through the use of constraints
- Can pre-sanitize values with the use of filters
- Can easily be expanded with new data types, constraints and filters.

# Instructions

## Installation
Install using composer `composer require "jasperfw\validator"`

## Basic Usage
IMPORTANT: When doing validations, unless the Required constraint is set, empty values ALWAYS PASS!
### Quickly validate a single value
```php
$trim = new Trim() // This filter will trim the value before validating
$required = new Required() // This constraint will cause validation to fail if the value is empty
$minLegnth = new MinimumLength(5); // Make sure the value contains at least 5 characters
$errorMessage = null // This will be a string with the error message if validation fails. Optional.
$result = Alpha::quickValidate('bob', [$trim], [$required, $minLength], $errorMessage);
```
### Validate a set of data

Validate a set of data by creating a validationSet object and adding validators to it. Note that when processing a form,
data does not need to be passed in. Simply set a InputSource of GET or POST and the validator will get the values
automatically.
```php
$required = new Required(); // Some values will be required.
$validationSet = new ValidationSet();
$validationSet->addValidator(newAlpha('username', InputSources::GET, [$required], [new StripTags(), new Trim()]));
$validationSet->addValidator(newPassword('password', InputSources::GET, [$required], [new Trim()]));
$isValid = $validationSet->isValid(); // Check the entire set.
$isUsernameValid = $validationSet->isFieldValid('username'); // Check if a single field is valid
$errors = $validationSet->getErrorMessages(); // Get all the errors as an array of strings
$value = $validationSet->getFieldValue('username'); // Get the value of a field, or null if the value was not valid
```

## Included classes

## Validators
These are the included validators. New validators can be created by extending the Validator class.

- **Alpha** - Allows only letters.
- **AlphaNumeric** - Allows only letters or numbers.
- **Boolean** - Allows "true", "false", "y" or "n" - this is not case sensitive.
- **Date** - The value must be resolvable into a data by PHP's date_create function.
- **Decimal** - The value must be an integer or decimal (such as a price).
- **Email** - The value must be a validly formatted email address.
- **MultilineString** - Allows pretty much any multiline string. Same as TextString but allows newlines.
- **Name** - Allows letters, spaces and apostrophes, common characters in names.
- **Number** - Allows only digits.
- **Password** - Allows any character except newline. To force complexity, use ComplexPassword constraint. Use with
MinimumLength and MaximumLength constraints to force a certain length.
- **Phone** - Validates international phone numbers in the format +NNN NNNNNNNNNxNNNNN, with six or more digits, not
counting the country code, and an optional extension preceeded by an x. The x may have a space in front of it. The
country code may be 1 to 3 digits. No other punctuation or formatting characters are allowed.
- **PhoneUS** - Validator for US phone numbers. Removes any leading 1 as well as dashes and parenthesis.
- **PostalCodeCA** - Validator for Canadian postal codes.
- **PostalCodeUS** - Validator for US postal codes / ZIP codes.
- **TextString** - Allows any character other than newlines.
- **Time** - Basic validator for time strings. Expects HH:MM, but doesn't do very much checking beyond that.
- **Username** - Basic username validation. Accepts any characters by default, except newlines.

### Filters
Filters alter input before the validation is done. Currently, there are only two filters. New filters can be created by
extending the Filter class.

- **Trim** - Trims the passed value. Same as PHP `trim()`.
- **StripTags** - Removes any HTML tags. Same as PHP `striptags()`

### Constraints
Constraints are used to modify what is allowed by the base validator. These constraints are only checked if the base
validation succeeds, so they can not be used to turn a failed validation into a success.

- **ComplexPassword** - A complex password requiring at least one letter, one number and one special character. Use
with the MinimumLength and MaximumLength constraints to enforce password length.
- **DateFormat** - Checks that the provided value is a recognizeable date and/or time format, using \DateTime.
- **InArray** - Add this constraint to fields that must contain a value from a list. Great for validating a select field
in a form.
- **MaximumLength** - Verifies that the value contains no more than a certain number of characters.
- **MaximumValue** - Check that the provided value is less than or equal to a certain amount.
- **MinimumLength** - Verifies that the value contains at least a certain number of characters.
- **MinimumValue** - Check that the provided value is greater than or equal to a certain amount.
- **Regex** - Set a custom regex to validate the value. Combined with TextString or MultilineString, this will allow a
completely new Validator to be created on the fly.
- **Required** - By default, empty values automatically bypass all other validations and constraints and are considered
to be valid. This includes MinimumLength and MaximumLength. Setting the Required constraint will cause validation to
fail if the value is empty.