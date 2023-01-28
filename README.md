# Log Reader

- This project is a technical test of Bugloos

## import log:
- We use the following command to import log data:
```bash
php artisan import:log [path/to/log/file]
```
 for example:
```bash
php artisan import:log /var/log/log.txt
```

**note:** 
- In order to have a high speed in importing the log file into the database, Query Builder is used instead of Eloquent


## get count of log file
- First of all, a static function (**filterViaParams**) has been added to the **log model** to convert the query params into an eloquent.


- You can implement more modes for searching in the log file with this function and try to include all the columns of the relevant table


- this is [postman collection](https://api.postman.com/collections/16990586-6b41d255-5b52-4134-af12-91fd3f9ab66a?access_key=PMAT-01GQW2C0ZY6ZPKY5C0J57YPJQW) (including the number of tested responses)


## test
- Several test scenarios have been considered for this project, which can be tested with the following command؛
```bash
php artisan test 
```

- The tests include the scenario for **validating the inputs**, **checking the response format** and also checking the **correctness of the received information**


- It was possible to write more tests in more time to test all modes of the query param and the corresponding intervals
