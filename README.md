# Assytech

Technologies Used:

 1. Laravel 5.7.28
 2. Vue Js 2.6.10
 3. laravel-dompdf
 4. Vue formwizard
 6. Namirial Api

## How it works
1. Login using your dedicated account.
2. Fill the first form appeared and sign on the generated pdf to proceed.
3. After completion of first form fill the second form and click submit.
4. After completing second form select choices in the form wizard steps.
5. Fill the last form and sign on the generated pdfs using all the three generated urls.

### How to use

-   Clone the repository with  **git clone**
-   Copy  **.env.example**  file to  **.env**  and edit database credentials there
-   Run  **composer install**
-   Run  **php artisan key:generate**
-   Import  **new_assytech.sql**
-   Run  **npm install**
-   Run  **npm run watch**
-   Set  Namirial Api credentials and domain url in registersalecontroller.php