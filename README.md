# CareerLink – Web-Based Job and Internship Portal

## Project Overview

CareerLink is a web-based job and internship portal designed to connect students and job seekers with companies offering employment and internship opportunities.

The system allows users to create accounts, manage profiles, browse available opportunities, apply for jobs or internships, and track their applications. Companies can create profiles, post opportunities, manage job postings, and review applications. An admin section provides basic system management.

## Technologies Used

* HTML5
* CSS3
* JavaScript
* Bootstrap 5
* PHP
* MySQL
* XAMPP
* phpMyAdmin
* Visual Studio Code
* Git and GitHub

## Project Modules

### Module 1 – User and Company Management

This module provides the basic account and authentication functionality.

**Features:**

* User registration
* Company registration
* User login and logout
* Secure password hashing
* Session-based authentication
* User profile management
* Company profile management
* User dashboard
* Company dashboard
* Role-based access

### Module 2 – Job Posting and Search

This module allows companies to create and manage job and internship opportunities.

**Features:**

* Create job and internship posts
* Edit job posts
* Delete job posts
* View company's posted opportunities
* Browse available opportunities
* Search and filter opportunities
* Display job type, location, salary/stipend, requirements, and deadline
* Automatically hide expired opportunities

### Module 3 – Application Management

This module connects job seekers with companies through an online application system.

**Features:**

* Apply for jobs and internships
* Submit a cover letter
* View application history
* Company application management
* View applications for posted opportunities
* Update application status
* Track submitted applications
* Application status management

### Module 4 – Admin and Frontend Enhancement

The final module focuses on improving the overall system interface and providing basic administrative management.

**Features:**

* Admin login
* Admin dashboard
* Basic system management
* Improved website navigation
* Consistent header and footer
* Improved visual design
* Responsive Bootstrap-based interface
* Professional layout and styling
* Improved user experience

## User Roles

### Job Seeker / Student

Users can:

* Register and log in
* Create and update their profile
* Browse job and internship opportunities
* Apply for opportunities
* Submit cover letters
* View application history
* Track application status

### Company

Companies can:

* Register and log in
* Create and manage company profiles
* Post job and internship opportunities
* Edit and delete job posts
* View their posted opportunities
* View applications
* Update application status

### Admin

The administrator can access the administrative section of the system and perform basic system management tasks.

## Project Structure

```text
careerlink/
│
├── admin/
│   └── Admin management files
│
├── company/
│   ├── create_post.php
│   ├── delete_post.php
│   ├── edit_post.php
│   ├── my_posts.php
│   ├── applications.php
│   └── update_application.php
│
├── config/
│   └── db.php
│
├── user/
│   ├── dashboard.php
│   ├── profile.php
│   ├── browse_jobs.php
│   ├── apply.php
│   └── application_history.php
│
├── index.php
├── login.php
├── logout.php
├── register.php
└── README.md
```

## Database

CareerLink uses **MySQL** as its database system.

The database is managed using **phpMyAdmin** through XAMPP.

The database stores information related to:

* Users
* Companies
* Job and internship postings
* Applications
* Application statuses
* User and company profiles

## Installation and Setup

1. Install XAMPP.
2. Start **Apache** and **MySQL** from the XAMPP Control Panel.
3. Copy the `careerlink` project folder into:

```text
C:\xampp\htdocs\
```

4. Create the CareerLink database in phpMyAdmin.
5. Configure the database connection in:

```text
config/db.php
```

6. Open the project in a web browser:

```text
http://localhost/careerlink/
```

## Development Tools

The project was developed using:

* Visual Studio Code for coding
* XAMPP for the local Apache and MySQL environment
* phpMyAdmin for database management
* Git for version control
* GitHub for source-code hosting

## Project Objectives

The main objectives of CareerLink are:

* To provide a centralized platform for job and internship opportunities.
* To help students and job seekers find relevant opportunities.
* To allow companies to publish and manage openings.
* To provide an online application process.
* To allow users to track their applications.
* To provide a simple and responsive web interface.
* To demonstrate practical full-stack web development skills.

## Future Enhancements

Possible future improvements include:

* Email notifications
* Advanced job search
* Resume/CV upload
* Company verification
* Advanced admin controls
* Application analytics
* Improved security features
* Personalized job recommendations
* Deployment to a live web server

## Author

**Muqaddas Khalil**

**Program:** Full Stack Development Internship

**Project:** CareerLink – A Web-Based Job and Internship Portal

## Repository

CareerLink source code is maintained using Git and GitHub.
