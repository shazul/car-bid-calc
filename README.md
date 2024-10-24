# Car Bid Calculation Tool

Bonjour à toute l'équipe,  
Je suis ravi de soumettre cette solution dans le cadre du processus de sélection. Ayant vécu au Québec pendant plusieurs années, j'espère que ce projet répondra à vos attentes.


This is a simple web application for calculating the total price of a vehicle at an auction, including various fees based on the vehicle type and base price.

## Technologies

- Backend: Laravel
- Frontend: Vue.js
- Package Manager: Composer, npm

## Installation

Follow these steps to install and run the project locally:

1. **Clone the repository**:
   ```bash
   git clone git@github.com:shazul/car-bid-calc.git
    ```

2. **Navigate to the project directory**:  
   ```bash
   cd car-bid-calc
   ```

4. **Install backend dependencies**:  
   ```bash
   composer install
   ```

6. **Create the `.env` file**:  
   ```bash
   cp .env.example .env
   ```

8. **Generate the application key**:  
   ```bash
   php artisan key:generate
   ```

10. **Cache the configuration**:  
    ```bash
    php artisan config:cache
    ```

12. **Install frontend dependencies**:  
    ```bash
    npm install
    ```

## Running the Project

1. **Start the Laravel development server**:  
   ```bash
   php artisan serve
   ```

3. **Compile the frontend assets**:  
   ```bash
   npm run dev
   ```

5. **Access the application** in your browser at:  
   `http://localhost:8000/`
