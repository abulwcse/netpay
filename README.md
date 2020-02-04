# NetPay #

This is a simple application made on Symfony and ReactJS for 2 simple usecase
   - Store and retrieve the file path a file, stored in database.
   - Multi contact form with front-end and back end validation with React JS and PHP.

## System Requirement ##
- MySql 8 
- PHP72

You also need the Nodejs and npm in your development environment to build the webpack.


## How to run locally ##
1. Clone the repository `git clone https://github.com/abulwcse/netpay.git`
2. Run `composer install` in your project root directory.
3. Run `npm install` to install all the webpack dependencies.
3. Duplicate `.env` file in the name `.env.local`
4. Update your database connection details in the `.env.local` file
5. Run `bin/console --env=dev doctrine:database:create` if you haven't created database already, this command with create an empty database for you.
6. Run `bin/console --env=dev doctrine:migrations:migrate` this will create you the required table.
7. Run `npm run build` that will compile and dump the webpack assets.
8. Run `symfony serve` this is start a local php server, and you will now be able to browse the application on your site.  

## How to import the file structure into database ##
A symfony console command is implemented to import the file structure into the database.
To run the command, run the following from your project root directory.
```$sh
bin/console netpay:generate 
```
This will import a in-build example file `demo/file.txt`.

You can also pass a user defined file, using the option `--file` in the same command. 
