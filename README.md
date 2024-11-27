# Trade Finance Guarantee System

The TradeFinance Guarantee System is a Laravel-based application for managing financial guarantees, including Bank, Bid Bond, Insurance, and Surety types.
It supports secure CRUD operations, manual data entry, and bulk processing through CSV, JSON, or XML uploads, with files stored as database blobs. 
The system ensures data integrity with robust validation and is containerized for deployment using Podman.

## Team Members

Pranav Panchal  
Rajat Sachdeva
Shrabani Sagareeka
Nayeem Khan
Mitali Sharma


## Screenshots

Index Page
![image](https://github.com/user-attachments/assets/155ebd9d-7fac-4645-a216-8766463a18cf)

Login Page
![image](https://github.com/user-attachments/assets/5cd3fe1e-fb58-4b6a-8ca6-6cfd31eaae35)

Register Page
![image](https://github.com/user-attachments/assets/566dcb87-4c86-43c3-a04f-4e17bbf5ab2e)

Applicant Dashboard
![image](https://github.com/user-attachments/assets/95865fb8-2908-4e32-b0da-c4e6ce5fb8c6)
![image](https://github.com/user-attachments/assets/4b632930-e4db-4d34-a8e5-b6036b69a76d)

Reviewer Dashboard
![image](https://github.com/user-attachments/assets/d8636d7f-5fc5-49d4-8b62-b2f9ac58d149)

Reviewer - Guarantee Review
![image](https://github.com/user-attachments/assets/610b04c8-de9d-49ee-bfae-c25ede4c4f02)

Admin Dashboard
![image](https://github.com/user-attachments/assets/1e637b07-fc72-4d8f-8357-ee3aedafa9d7)

Admin - Manage Users
![image](https://github.com/user-attachments/assets/71866641-4f63-46f8-9d99-8cdd27812709)
![image](https://github.com/user-attachments/assets/4723461d-21be-4bcb-a16e-f5185dc82f70)

Admin - Manage Guarantees
![image](https://github.com/user-attachments/assets/e6a353c3-c1a1-44b8-9918-94b2f907739b)
![image](https://github.com/user-attachments/assets/7c4ca513-14b7-4ed5-914f-cf4539642098)

Admin - Manage Files
![image](https://github.com/user-attachments/assets/a9838065-8d5d-4a8e-ad56-3d616d45ea83)

# Podman Deployment Instructions 


## 1. Start the Application Using Docker Compose
 
To bring up the entire application stack, run the following command in your project root directory:
 
```bash
docker-compose up
```
 
Or, if you prefer to run the containers in the background, use:
 
```bash
docker-compose up -d
```
 
This will start the services defined in your `docker-compose.yml` file, including the PHP application, MySQL database, and any other necessary services.
 
---
 
## 2. Set Up the PHP Application
 
Once the services are up and running, follow these steps to set up the PHP application:
 
### Access the PHP Container
 
```bash
docker exec -it trade-finance-app bash
```
 
### Generate the Laravel Application Key
 
```bash
php artisan key:generate
```
 
### Run Migrations
 
```bash
php artisan migrate
```
 
### Update and Install Node.js Dependencies
 
```bash
apt-get update
apt-get install -y nodejs npm
```
 
### Install NPM Dependencies
 
```bash
npm install
```
 
### Run the Development Server
 
```bash
npm run dev
```
 
---
 
## 3. Set Up MySQL Database
 
Next, set up the MySQL database by following these steps:
 
### Access the MySQL Container
 
```bash
docker exec -it mysql bash
```
 
### Log in to MySQL
 
```bash
mysql -u root -p
```
 
- **Password:** `root`
 
### Select the Database
 
```bash
USE trade_finance;
```
 
### Show the Tables
 
```bash
SHOW TABLES;
```
 
### Import the Database Dump
 
The database dump file (`TradeFinance.sql`) can be imported it into the `trade_finance` database:
 
```bash
mysql -u root -p trade_finance < /path/to/TradeFinance.sql
```
 
---
 
## 4. Build the Docker Image
 
If you need to build the Docker image manually, follow these steps:
 
### Build the Image from the Dockerfile
 
In the project root directory, run the following command to build the Docker image:
 
```bash
docker build -t trade-finance-app .
```
 
This command will:
 
- Use the `Dockerfile` in the current directory.
- Build the image with the tag `trade-finance-app`.
 
Once the build process is complete, the image will be ready for use
