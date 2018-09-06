# fillindata
take the .csv file's data fill into database table 

#### How to use:
1. require it: 
    `composer require noahprot/fillindata`
2. you must have the `/resources/csv/{tableName}.csv` File.
    ```
    name,description,quantity
    Beverages,consumption,2
    Cakes,baked,3
    Baked,baking,4
    Cookies,Cookies cakes,5
    Canned,Canning,6
    ```
3. Then use `php artisan fill:data {modelName}`;

