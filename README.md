# php-string-numbers
A conversion class from text to numbers and vice versa

# Install
## Using composer
`composer install itvisionsy/php-string-numbers`
## Direct download
It is only 1 class! Copy and paste it or download it directly!
[StringNumbers PHP Class](./src/StringsNumbers.php)

# How to use
There are two public static methods 
 * `::numbersToWords($string)` converts all digits numbers to written numbers.
 * `::wordsToNumbers($string)` converts all written numbers to word numbers.
## Note
some space characters may get added or removed by the conversion method.
Use with care!

# Examples
```PHP
echo StringNumbers::wordsToNumbers('one hundred fifty five');
//155

echo StringNumbers::wordsToNumbers('There are two hundred fifty five thousand two hundred twelve leaves on the tree');
//There are 255212 leaves on the tree

echo StringNumbers::wordsToNumbers('Ten men bought 2 hundred devices in less than a week for more than two million dollars');
//10 men bought 200 devices in less than a week for more than 2000000 dollars

echo StringNumbers::numbersToWords('155');
//one hundred fifty five

echo StringNumbers::numbersToWords('There are 366 days in a leap year and 2016 was a leap year');
//There are three hundred sixty six days in a leap year two thousand sixteen was a leap year
```

# License
PHP String Numbers project is under the [MIT Licence](./LICENSE)
