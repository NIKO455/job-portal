# Job Portal Website

This is a job portal website created with Laravel. It allows users to browse job listings, apply for jobs, and manage their job applications.

## Features
- User Authentication: Users can sign up, log in, and log out.
- Job Listings: Users can browse job listings posted by employers.
- Job Search: Users can search for jobs based on keywords, categories, or locations.
- Apply for Jobs: Users can apply for jobs by submitting their resume and cover letter.
- Employer Dashboard: Employers can post job listings, review applications, and manage their job listings.

## Installation

1. Clone the repository:
    ```bash
   git clone https://github.com/NIKO455/job-portal.git
   ```

2. Navigate to the project directory:

   ```bash
   cd job-portal
   ```

3. Install dependencies:

   ```bash
   composer install
   npm install
   ```

4. Set up environment variables:

   Rename the `.env.example` file to `.env` and update the database connection settings.

5. Generate application key:

   ```bash
   php artisan key:generate
   ```

6. Migrate the database:

   ```bash
   php artisan migrate --seed
   ```

7. Start the development server:

   ```bash
   php artisan serve
   ```

8. Access the application:

   Open your web browser and visit http://localhost:8000.


