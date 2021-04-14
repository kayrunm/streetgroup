# Homeowner Names - Technical Test

I have added a full test suite for the code that I have written.

## Parser class

You can find the main CSV parsing class at `app/CsvParser`. The parser class contains two public methods,
which are as follows:

* `withoutHeader` (chainable)

  This allows for a file to be parsed whether it has a header or not. The header is not used in any
  parsing, so if the CSV file has a header it is simply skipped.

* `parse`

  The `parse` method accepts one argument, `$path`, which is a path from the `resources/csvs/`
  directory within the app where the CSV file is located.


## Console command
A console command is also provided which accepts similar arguments. The console command can be
called by running `php artisan names:parse`. The first argument for the command is the path for the
file which, as above, is the path to the file from the `resources/csvs/` directory within the app.

A flag for skipping the header is also accepted, `--without-header`.

E.g.
```
php artisan names:parse examples_without_header --without-header`
```

## Notes

The spec (./spec.md) says the output should look like the following:
```
$person[‘title’] => ‘Mr’,
$person[‘first_name’] => null,
$person[‘initial’] => “J”,
$person[‘last_name’] => “Smith”
```

But I have opted to just output the full names from the console command. The `CsvParser` class
will output an array of `Name` value objects which expose the following methods:

* `getTitle()`
* `getFirstName()`
* `getInitial()`
* `getLastName()`

As well as allowing you to cast the value object to a string, like so:

```
(string) (new Name('Mr. Kieran Marshall')) // Mr Kieran Marshall
```

## Assumptions

Some assumptions have been made in the creation of this solution to the code test. These are as follows:

1. An input with two names, in the format `[title] & [title] [first name] [last name]` will treat the two
   names as a married couple. This means a name such as `Mr & Mrs David Beckham` would have the second name (in this case, Vicotria Beckham) named as `Mrs David Beckham`.

2. An input with more than two names is invalid input.
