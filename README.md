Task tracking:

1- Add code template

2- Task creation page: 3 hours

    a- view
        1- update the form template to match the inputs 
        2- add select2 input for users select

    b- the controller "use existing template" 
        1- update the validation rules
        2- save the data 
        3- add endpoint for the users select

    c- add new db table for tasks 

3- tasks list 2 hours

    a- update the view
    b- fix pagination issue
    c- get the name of the admin and the user

4- tasks statistics 1 hour

    a- add new view for tasks statistics table
    b- add new cotroller function 
    c- add model function to query the db and retrun the tasks statistics

5- unit testing 2 hour

    a- add unit test classes
    b- add feature tests for task creation & tasks list route & tasks statistics route
    c- add unit test for tasks response code

6- seeding .5 hour

    a- add db seeder for users
    b- run and test the seeders

7- add run testing on github actions .5 hour

-----------------------

//create books table command
//php artisan make:migration create_books_table --create=books
//create checkouts table command
//php artisan make:migration create_checkouts_table --create=checkouts
//create books controller command
//php artisan make:controller BooksController --resource --model=Book

